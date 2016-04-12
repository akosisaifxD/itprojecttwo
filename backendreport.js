var yearsSearch = [];
var provinceSearch = [];
var cenroSearch = [];
var orgNameSearch = [];
var specieSearch = [];
var seedlings;
var validation;
var site = {};
var years = {};
var yearsArray = [];
var tables = [];

var entry = {"year":[],"province":[],"cenro":[],"orgname":[],"species":[]};

$.get("autocomplete.php?q=year").done(function(data) {
	yearsSearch = data.split(",");
	
		
	$("#yearInput").autocomplete({
		source: function(request, response) {
			var results = $.ui.autocomplete.filter(yearsSearch, request.term);
			response(results.slice(0, 5));
		}
	});
	
});

$.get("autocomplete.php?q=province").done(function(data) {
	provinceSearch = data.split(",");
	
	$("#provinceInput").autocomplete({
		source: function(request, response) {
			var results = $.ui.autocomplete.filter(provinceSearch, request.term);
			response(results.slice(0, 5));
		}
	});
	
});
	
$.get("autocomplete.php?q=cenro").done(function(data) {
	cenroSearch = data.split(",");
	
	$("#cenroInput").autocomplete({
		source: function(request, response) {
			var results = $.ui.autocomplete.filter(cenroSearch, request.term);
			response(results.slice(0, 5));
		}
	});
	
});
	
$.get("autocomplete.php?q=orgname").done(function(data) {
	orgNameSearch = data.split(",");
	
	$("#orgnameInput").autocomplete({
		source: function(request, response) {
			var results = $.ui.autocomplete.filter(orgNameSearch, request.term);
			response(results.slice(0, 5));
		}
	});
	
});
	
$.get("autocomplete.php?q=species").done(function(data) {
	specieSearch = data.split(",");
	
	$("#speciesInput").autocomplete({
		source: function(request, response) {
			var results = $.ui.autocomplete.filter(specieSearch, request.term);
			response(results.slice(0, 5));
		}
	});
	
});

function enter(category) {
	var inputboxID = "#" + category + "Input";
	var labelID = "#" + category + "Selected";
	var value = $(inputboxID).val().trim();
	var pID = category + "-" + value.replace(/\s/g, '');
	var pID2 = category + "-" + value;
	
	if(entry[category].indexOf(value) < 0) {
		entry[category].push(value);
		
		$(labelID).append('<p id=' + pID + '>' + value + '<button onclick="removeEntry(\'' + pID2 + '\');"></button></p>');
	}
}

function removeEntry(pID) {
	var splitID = pID;
	var category = splitID.split("-")[0];
	var value = splitID.replace(category+"-","");
	var index = entry[category].indexOf(value);
	if(index > -1) {
		entry[category].splice(index, 1);
		document.getElementById(pID.replace(/\s/g, '')).remove();
		//$("#" + pID.replace(/\s/g, '')).remove();
	}
}

function search() {
	var queryString = "WHERE";
	var first = true;
	var counter = 0;
	var prefix = "";
	
	for(var key in entry) {
		if(entry[key].length > 0) {
			if(counter != 0) {
				queryString += ' AND';
			}
			for(var i = 0; i < entry[key].length; i++) {
				prefix = determinePrefix(key);
				if(i == 0) {
					if(entry[key].length == 1) {
						queryString += ' (' + prefix + '="' + entry[key][i] + '")';
					} else {
						queryString += ' (' + prefix + '="' + entry[key][i] + '"';
					}
				} else if(i == entry[key].length-1) {
					queryString += ' OR ' + prefix + '="' + entry[key][i] + '")';
				} else {
					queryString += ' OR ' + prefix + '="' + entry[key][i] + '"';
				}
			}
			counter++;
		}
	}
	
	getSeedlings(queryString);
}

function determinePrefix(key) {
	if(key == "year") {
		return "site.year";
	} else if(key == "orgname") {
		return "organization.organizationName";
	} else if(key == "cenro") {
		return "cenro.cenroName";
	} else if(key == "species") {
		return "species.commonName";
	} else if(key == "province") {
		return "province.provinceName";
	}
}

function getSeedlings(queryString) {
	$.get("poseedlings.php?q=" + queryString).done(function(data) {
		seedlings = JSON.parse(data);
		site = {};
		years = {};
		yearsArray = [];
		var lastSite = "";
		for(var i = 0; i < seedlings.length; i++) {
			if(site.hasOwnProperty(seedlings[i].sitecode)) {
				if(site[seedlings[i].sitecode].hasOwnProperty(seedlings[i].sitecode)) {
					site[seedlings[i].sitecode]["seedlings"][seedlings[i].commonname] += parseInt(seedlings[i].quantity);
				} else {
					site[seedlings[i].sitecode]["seedlings"][seedlings[i].commonname] = parseInt(seedlings[i].quantity);
				}
			} else {
				site[seedlings[i].sitecode] = {};
				site[seedlings[i].sitecode]["seedlings"] = {};
				site[seedlings[i].sitecode]["validation"] = {};
				site[seedlings[i].sitecode]["seedlings"][seedlings[i].commonname] = parseInt(seedlings[i].quantity);
				site[seedlings[i].sitecode]["totalSeedlings"] = 0;
				site[seedlings[i].sitecode]["seedlingsArea"] = seedlings[i].areaValidated;
				site[seedlings[i].sitecode]["seedlingsArray"] = [];
			}
			lastSite = seedlings[i].sitecode;
		}
		
		for(var key in site) {
			for(var key2 in site[key]["seedlings"]) {
				site[key]["totalSeedlings"] += parseInt(site[key]["seedlings"][key2]);
				site[key]["seedlingsArray"].push(key2 + ":" + site[key]["seedlings"][key2]);
				site[key]["seedlingsArray"].sort();
			}
		}
		
		getValidations(queryString);
	});
}

function getValidations(queryString) {
	$.get("poreport.php?q=" + queryString).done(function(data) {
		validation = JSON.parse(data);
		for(var i = 0; i < validation.length; i++) {
			if(site.hasOwnProperty(validation[i].sitecode) == false) {
				site[validation[i].sitecode] = {};
				site[validation[i].sitecode]["validation"] = {};
			}
			
			site[validation[i].sitecode]["Year"] = validation[i].year;
			site[validation[i].sitecode]["Cenro"] = validation[i].cenroName;
			if(site[validation[i].sitecode]["validation"].hasOwnProperty(validation[i].startDate) == false) {
				var targetDate = validation[i].startDate.split(" ")[0].split("-")[0];
				if(years.hasOwnProperty(targetDate) == false) {
					years[targetDate] = {};
					years[targetDate]["survivalRateSum"] = 0;
					years[targetDate]["survivalRateCount"] = 0;
					years[targetDate]["survivalRate"] = 0;
					years[targetDate]["growthRate"] = 0;
					yearsArray.push(targetDate);
				}
				site[validation[i].sitecode]["validation"][validation[i].startDate] = {};
				site[validation[i].sitecode]["validation"][validation[i].startDate]["validationArray"] = [];
				site[validation[i].sitecode]["validation"][validation[i].startDate]["stats"] = {};
				site[validation[i].sitecode]["validation"][validation[i].startDate]["stats"]["Area"] = validation[i].areaValidated;
				site[validation[i].sitecode]["validation"][validation[i].startDate]["stats"]["totalQuantity"] = 0;
			}
			
			if(site[validation[i].sitecode]["validation"][validation[i].startDate].hasOwnProperty(validation[i].commonname)) {
				site[validation[i].sitecode]["validation"][validation[i].startDate][validation[i].commonname] += parseInt(validation[i].quantity);
				site[validation[i].sitecode]["validation"][validation[i].startDate]["stats"]["totalQuantity"] += parseInt(validation[i].quantity);
			} else {
				site[validation[i].sitecode]["validation"][validation[i].startDate][validation[i].commonname] = parseInt(validation[i].quantity);
				site[validation[i].sitecode]["validation"][validation[i].startDate]["stats"]["totalQuantity"] += parseInt(validation[i].quantity);
			}
		}
		
		
		for(var key in site) {
			for(var key2 in site[key]["validation"]) {
				var survivalRate = (site[key]["validation"][key2]["stats"]["totalQuantity"]/site[key]["totalSeedlings"])*100;
				site[key]["validation"][key2]["stats"]["sr"] = survivalRate;
				var targetDate = key2.split(" ")[0].split("-")[0];
				years[targetDate]["growthRate"] += site[key]["validation"][key2]["stats"]["totalQuantity"];
				if(isFinite(survivalRate)) {
					years[targetDate]["survivalRateSum"] += survivalRate;
					years[targetDate]["survivalRateCount"] += 1;
				}
				
				for(var key3 in site[key]["validation"][key2]) {
					if(key3 != "validationArray" && key3 != "stats") {
						site[key]["validation"][key2]["validationArray"].push(key3 + ":" + site[key]["validation"][key2][key3]);
						site[key]["validation"][key2]["validationArray"].sort();
					}
				}
			}
		}
		
		for(var key in years) {
			years[key]["survivalRate"] = years[key]["survivalRateSum"]/years[key]["survivalRateCount"];
		}
		
		drawTable();
	});

}

function drawTable() {
	tables = [];
	for(var key in years) {
		var tr1 = document.createElement('tr');   
		
		var th1 = document.createElement("th");
		var th2 = document.createElement("th");
		var th3 = document.createElement("th");
		var th4 = document.createElement("th");
		var th5 = document.createElement("th");
		
		var yearText = document.createTextNode('Year');
		var cenroText = document.createTextNode('CENRO');
		var siteCodeText = document.createTextNode('Site Code');
		var seedlingText = document.createTextNode('Seedling');
		var validationText = document.createTextNode('');
		
		th1.appendChild(yearText);
		th2.appendChild(cenroText);
		th3.appendChild(siteCodeText);
		th4.appendChild(seedlingText);
		th5.appendChild(validationText);
		
		th1.rowSpan = "2";
		th2.rowSpan = "2";
		th3.rowSpan = "2";
		th4.colSpan = "3";
		th5.colSpan = "5";
		
		tr1.appendChild(th1);
		tr1.appendChild(th2);
		tr1.appendChild(th3);
		tr1.appendChild(th4);
		tr1.appendChild(th5);

		
		var tr2 = document.createElement('tr');   
			
		var th6 = document.createElement("th");
		var th7 = document.createElement("th");
		var th8 = document.createElement("th");
		var th9 = document.createElement("th");
		var th10 = document.createElement("th");
		var th11 = document.createElement("th");
		var th12 = document.createElement("th");
		var th13 = document.createElement("th");
		
		var seedlingSpeciesText = document.createTextNode('Species');
		var seedlingQuantityText = document.createTextNode('Quantity');
		var seedlingAreaText = document.createTextNode('Area Validated');
		var validationDateText = document.createTextNode('Date');
		var validationSpeciesText = document.createTextNode('Species');
		var validationQuantityText = document.createTextNode('Quantity');
		var validationAreaText = document.createTextNode('Area Validated');
		var validationSurvivalRateText = document.createTextNode('Survival Rate');
		
		th6.appendChild(seedlingSpeciesText);
		th7.appendChild(seedlingQuantityText);
		th8.appendChild(seedlingAreaText);
		th9.appendChild(validationDateText);
		th10.appendChild(validationSpeciesText);
		th11.appendChild(validationQuantityText);
		th12.appendChild(validationAreaText);
		th13.appendChild(validationSurvivalRateText);
		
		tr2.appendChild(th6);
		tr2.appendChild(th7);
		tr2.appendChild(th8);
		tr2.appendChild(th9);
		tr2.appendChild(th10);
		tr2.appendChild(th11);
		tr2.appendChild(th12);
		tr2.appendChild(th13);
		
		validationText = document.createTextNode(key + " Validation");
		th5.appendChild(validationText);
		tr1.appendChild(th5);
		var table = document.createElement("table");
		table.appendChild(tr1);
		table.appendChild(tr2);
		
		tables.push(table);
	}

	var lastSite = "";

	for(var key in site) {
		for(var i = 0; i < tables.length; i++) {
			if(site[key]["seedlingsArray"]) {
				var counter1 = site[key]["seedlingsArray"].length + 1;
			} else {
				var counter1 = 0;
			}
			
			var counter2 = 0;
			for(var key2 in site[key].validation) {
				if(key2.split(" ")[0].split("-")[0] == yearsArray[i]) {
					if(site[key]["validation"][key2]["validationArray"]) {
						counter2 = site[key]["validation"][key2]["validationArray"].length + 1;
					}
				}
			}
			if(counter2 > 0 && counter1 > 0) {
				var tr1 = document.createElement('tr');
			var td1 = document.createElement('td');
			var td2 = document.createElement('td');
			var td3 = document.createElement('td');
			var tdTotal = document.createElement('td');
			var tdTotalQty = document.createElement('td');
			var tdAreaSeedlings = document.createElement('td');
			
			var yearNode = document.createTextNode(site[key + ""]["Year"]);
			var cenroNode = document.createTextNode(site[key + ""]["Cenro"]);
			var siteNode = document.createTextNode(key);
			var seedlingsTotal = document.createTextNode(site[key + ""]["totalSeedlings"]);
			var areaSeedlingsNode = document.createTextNode(site[key + ""]["seedlingsArea"]);
			
			if(counter1 >= counter2) {
				var rowspanValue = counter1;
			} else {
				var rowspanValue = counter2;
			}
			
			td1.appendChild(yearNode);
			td1.rowSpan = rowspanValue;
			td2.appendChild(cenroNode);
			td2.rowSpan = rowspanValue;
			td3.appendChild(siteNode);
			td3.rowSpan = rowspanValue;
			tdTotal.appendChild(seedlingsTotal);
			tdTotalQty.appendChild(document.createTextNode("Total"));
			tdAreaSeedlings.appendChild(areaSeedlingsNode);
			
			tdAreaSeedlings.rowSpan = rowspanValue;
			tr1.appendChild(td1);
			tr1.appendChild(td2);
			tr1.appendChild(td3);
			tr1.appendChild(tdTotalQty);
			tr1.appendChild(tdTotal);
			tr1.appendChild(tdAreaSeedlings);
			
			for(var key2 in site[key]["validation"]) {
				var targetDate = key2.split(" ")[0].split("-")[0];
				if(targetDate == yearsArray[i]) {
					var dateNode = document.createTextNode(key2.split(" ")[0]);
					var totalNode = document.createTextNode("Total");
					var totalQty = document.createTextNode(site[key]["validation"][key2]["stats"]["totalQuantity"]);
					var areaNode = document.createTextNode(site[key]["validation"][key2]["stats"]["Area"]);
					var srNode = document.createTextNode(site[key]["validation"][key2]["stats"]["sr"]);
					
					var tdValidationDate = document.createElement('td');
					var tdValidationTotal = document.createElement('td');
					var tdValidationTotalQty = document.createElement('td');
					var tdValidationAreaNode = document.createElement('td');
					var tdSr = document.createElement('td');
					
					tdValidationDate.appendChild(dateNode);
					tdValidationDate.rowSpan = rowspanValue;
					tdValidationTotal.appendChild(totalNode);
					tdValidationTotalQty.appendChild(totalQty);
					tdValidationAreaNode.appendChild(areaNode);
					tdValidationAreaNode.rowSpan = rowspanValue;
					tdSr.appendChild(srNode);
					tdSr.rowSpan = rowspanValue;
					
					tr1.appendChild(tdValidationDate);
					tr1.appendChild(tdValidationTotal);
					tr1.appendChild(tdValidationTotalQty);
					tr1.appendChild(tdValidationAreaNode);
					tr1.appendChild(tdSr);
				}
			}
			
			tables[i].appendChild(tr1);
			
			
			for(var x = 0; x < rowspanValue-1; x++) {
				var trSeedlings = document.createElement('tr');
				var tdKey = document.createElement('td');
				var tdQty = document.createElement('td');
				if(site[key]["seedlingsArray"]) {
					if(x >= site[key]["seedlingsArray"].length) {
					var nodeKey = document.createTextNode("");
					var nodeQty = document.createTextNode("");
					} else {
						var nodeKey = document.createTextNode(site[key]["seedlingsArray"][x].split(":")[0]);
						var nodeQty = document.createTextNode(site[key]["seedlingsArray"][x].split(":")[1]);
					}
				} else {
					var nodeKey2 = document.createTextNode("");
					var nodeQty2 = document.createTextNode("");
				}
				
				
				tdKey.appendChild(nodeKey);
				tdQty.appendChild(nodeQty);
				
				trSeedlings.appendChild(tdKey);
				trSeedlings.appendChild(tdQty);
				
				for(var key2 in site[key]["validation"]) {
					var targetDate = key2.split(" ")[0].split("-")[0];
					if(targetDate == yearsArray[i]) {
						var tdKey2 = document.createElement('td');
						var tdQty2 = document.createElement('td');
						if(site[key]["validation"][key2]["validationArray"]) {
							if(x >= site[key]["validation"][key2]["validationArray"].length) {
								var nodeKey2 = document.createTextNode("");
								var nodeQty2 = document.createTextNode("");
							} else {
								var nodeKey2 = document.createTextNode(site[key]["validation"][key2]["validationArray"][x].split(":")[0]);
								var nodeQty2 = document.createTextNode(site[key]["validation"][key2]["validationArray"][x].split(":")[1]);
							}
						} else {
							var nodeKey2 = document.createTextNode("");
							var nodeQty2 = document.createTextNode("");
						}
						
						tdKey2.appendChild(nodeKey2);
						tdQty2.appendChild(nodeQty2);
				
						trSeedlings.appendChild(tdKey2);
						trSeedlings.appendChild(tdQty2);
						tables[i].appendChild(trSeedlings);
					}
				}
			}
			}
			
		}
	}
	
	document.getElementById('table_div').innerHTML = "";
	for(var i = 0; i < tables.length; i++) {
		document.getElementById('table_div').appendChild(tables[i]);
	}
	
	drawTrends();
}

function drawTrends() {
	var survivalArray = [['Year', 'Survival Rate']];
	var growthArray = [['Year', 'Growth Rate']];
	
	var counter = 1;
	for(var key in years) {
		if(isFinite(years[key]["survivalRate"])) {
			survivalArray[counter] = [key+'', years[key]["survivalRate"]];
		} else {
			survivalArray[counter] = [key+'', 0];
		}
		
		growthArray[counter] = [key+'',years[key]["growthRate"]];
		counter++;
	}
	
	drawSurvivalRate(survivalArray);
	drawGrowthRate(growthArray);
}

function drawSurvivalRate(dataArray) {
	var data = google.visualization.arrayToDataTable(dataArray);
	
	var options = {
		title: 'Survival Rate',
		legend: {
			position: 'bottom'
		}
	}
	
	var chart = new google.visualization.LineChart(document.getElementById('chart_survival'));
	chart.draw(data, options);
}

function drawGrowthRate(dataArray) {
	var data = google.visualization.arrayToDataTable(dataArray);
	
	var options = {
		title: 'Survival Rate',
		legend: {
			position: 'bottom'
		}
	}
	
	var chart = new google.visualization.LineChart(document.getElementById('chart_growth'));
	chart.draw(data, options);
}