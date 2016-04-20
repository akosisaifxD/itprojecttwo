var yearsSearch = [];
var validationYears = [];
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

var entry = {"sYear":[],"vYear":[],"province":[],"cenro":[],"orgname":[],"species":[]};

$.get("autocomplete.php?q=year").done(function(data) {
	yearsSearch = data.split(",");
			
	$("#sYearInput").autocomplete({
		source: function(request, response) {
			var results = $.ui.autocomplete.filter(yearsSearch, request.term);
			response(results.slice(0, 5));
		}
	});
});

$.get("autocomplete.php?q=vyear").done(function(data) {
	validationYears = data.split(",");
			
	$("#vYearInput").autocomplete({
		source: function(request, response) {
			var results = $.ui.autocomplete.filter(validationYears, request.term);
			response(results.slice(0, 5));
		}
	});
	
	for(var i = 0; i < validationYears.length; i++) {
		var o = document.createElement("option");
		o.value = validationYears[i];
		o.text = validationYears[i];
		document.getElementById("yearEndValue").appendChild(o);
	}
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
	
	$('#speciesInput').autocomplete({
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
		
		$(labelID).append('<p id=' + pID + '>' + value + '<button id="removeButton" onclick="removeEntry(\'' + pID2 + '\');">X</button></p>');
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

var queryStringSeedlings;
var queryStringValidation;

function search() {
	queryStringSeedlings = "WHERE";
	queryStringValidation = "WHERE";
	var first = true;
	var counter = 0;
	var prefix = "";
	
	for(var key in entry) {
		if(entry[key].length > 0) {
			if(counter != 0) {
				queryStringValidation += ' AND';
			}
			for(var i = 0; i < entry[key].length; i++) {
				prefix = determinePrefix(key);
				if(i == 0) {
					if(entry[key].length == 1) {
						queryStringValidation += ' (' + prefix + '="' + entry[key][i] + '")';
					} else {
						queryStringValidation += ' (' + prefix + '="' + entry[key][i] + '"';
					}
				} else if(i == entry[key].length-1) {
					queryStringValidation += ' OR ' + prefix + '="' + entry[key][i] + '")';
				} else {
					queryStringValidation += ' OR ' + prefix + '="' + entry[key][i] + '"';
				}
			}
			counter++;
		}
	}
	
	for(var key in entry) {
		if(key != "vYear") {
			if(entry[key].length > 0) {
				if(counter != 0) {
					queryStringSeedlings += ' AND';
				}
				for(var i = 0; i < entry[key].length; i++) {
					prefix = determinePrefix(key);
					if(i == 0) {
						if(entry[key].length == 1) {
							queryStringSeedlings += ' (' + prefix + '="' + entry[key][i] + '")';
						} else {
							queryStringSeedlings += ' (' + prefix + '="' + entry[key][i] + '"';
						}
					} else if(i == entry[key].length-1) {
						queryStringSeedlings += ' OR ' + prefix + '="' + entry[key][i] + '")';
					} else {
						queryStringSeedlings += ' OR ' + prefix + '="' + entry[key][i] + '"';
					}
				}
				counter++;
			}
		}
	}
	
	if(queryStringSeedlings = "WHERE") {
		queryStringSeedlings = "";
	}
	getSeedlings(queryStringSeedlings);
}

function determinePrefix(key) {
	if(key == "sYear") {
		return "site.year";
	} else if(key == "orgname") {
		return "organization.organizationName";
	} else if(key == "cenro") {
		return "cenro.cenroName";
	} else if(key == "species") {
		return "species.commonName";
	} else if(key == "province") {
		return "province.provinceName";
	} else if(key == "vYear") {
		return "year (validation.startDate)"
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
		
		getValidations(queryStringValidation);
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
			site[validation[i].sitecode]["Province"] = validation[i].provinceName;
			site[validation[i].sitecode]["OrganizationName"] = validation[i].organizationName;
			if(site[validation[i].sitecode]["validation"].hasOwnProperty(validation[i].startDate) == false) {
				var targetDate = validation[i].startDate.split(" ")[0].split("-")[0];
				if(years.hasOwnProperty(targetDate) == false) {
					years[targetDate] = {};
					years[targetDate]["survivalRateSum"] = 0;
					years[targetDate]["survivalRateCount"] = 0;
					years[targetDate]["survivalRate"] = 0;
					years[targetDate]["growthRate"] = 0;
					yearsArray.push(targetDate);
					yearsArray.sort();
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
		//var tr0 = document.createElement('tr');
		//var th0 = document.createElement("th");
		//th0.style.textAlign = "center"

		//var heading = document.createTextNode('HEADING:DENR REPORT');
		//th0.appendChild(heading);
		//th0.rowSpan = "2";
		//tr0.appendChild(th0);
		var tr0 = document.createElement('tr');
		var tr1 = document.createElement('tr');   
		
		var th0 = document.createElement("th");
		var th1 = document.createElement("th");
		var th2 = document.createElement("th");
		var th3 = document.createElement("th");
		var th4 = document.createElement("th");
		var th5 = document.createElement("th");
		var thProvince = document.createElement("th");
		var thOrgName = document.createElement("th");
		
		th0.style.textAlign = "center"
		th1.style.textAlign = "center"
		th2.style.textAlign = "center"
		th3.style.textAlign = "center"
		th4.style.textAlign = "center"
		th5.style.textAlign = "center"
		thProvince.style.textAlign = "center"
		thOrgName.style.textAlign = "center"
		
		var heading = document.createTextNode('HEADING:DENR REPORT');
		var yearText = document.createTextNode('Year');
		var cenroText = document.createTextNode('CENRO');
		var siteCodeText = document.createTextNode('Site Code');
		var seedlingText = document.createTextNode('Seedling');
		var provinceText = document.createTextNode('Province');
		var orgnameText = document.createTextNode('Organization Name');
		var validationText = document.createTextNode('');
		
		th0.appendChild(heading);
		th1.appendChild(yearText);
		th2.appendChild(cenroText);
		th3.appendChild(siteCodeText);
		th4.appendChild(seedlingText);
		th5.appendChild(validationText);
		thProvince.appendChild(provinceText);
		thOrgName.appendChild(orgnameText);
		
		th0.colSpan = "12";
		th1.rowSpan = "2";
		th2.rowSpan = "2";
		th3.rowSpan = "2";
		th4.colSpan = "3";
		th5.colSpan = "5";
		thProvince.rowSpan = "2";
		thOrgName.rowSpan = "2";
		
		tr0.appendChild(th0);
		tr1.appendChild(th1);
		tr1.appendChild(thProvince);
		tr1.appendChild(th2);
		//tr1.appendChild(thOrgName);
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
		th6.style.textAlign = "center"
		th7.style.textAlign = "center"
		th8.style.textAlign = "center"
		th9.style.textAlign = "center"
		th10.style.textAlign = "center"
		th11.style.textAlign = "center"
		th12.style.textAlign = "center"
		th13.style.textAlign = "center"
		
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
		table.appendChild(tr0);
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
			if(counter1 > 0 && counter2 > 0) {
				var tr1 = document.createElement('tr');
				var td1 = document.createElement('td');
				var td2 = document.createElement('td');
				var td3 = document.createElement('td');
				var tdTotal = document.createElement('td');
				var tdTotalQty = document.createElement('td');
				var tdAreaSeedlings = document.createElement('td');
				td1.style.textAlign = "right"
				td2.style.textAlign = "right"
				td3.style.textAlign = "right"
				tdTotal.style.textAlign = "right"
				tdTotalQty.style.textAlign = "right"
				tdAreaSeedlings.style.textAlign = "right"
				
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
						var srNode = document.createTextNode(site[key]["validation"][key2]["stats"]["sr"].toFixed(2));
						
						var tdValidationDate = document.createElement('td');
						var tdValidationTotal = document.createElement('td');
						var tdValidationTotalQty = document.createElement('td');
						var tdValidationAreaNode = document.createElement('td');
						var tdSr = document.createElement('td');
						tdValidationDate.style.textAlign = "right"
						tdValidationTotal.style.textAlign = "right"
						tdValidationTotalQty.style.textAlign = "right"
						tdValidationAreaNode.style.textAlign = "right"
						tdSr.style.textAlign = "right"
						
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
					tdKey.style.textAlign = "right"
					tdQty.style.textAlign = "right"
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
							tdKey2.style.textAlign = "right"
							tdQty2.style.textAlign = "right"
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
	
	var newWindow = window.open('reportingBackend2.php');
	newWindow.window.onload = function() {
		newWindow.document.getElementById('table_div').innerHTML = "";
		if(tables.length > 0) {
			for(var i = 0; i < tables.length; i++) {
				newWindow.document.getElementById('table_div').appendChild(tables[i]);
			}
		} else {
			newWindow.document.getElementById('table_div').innerHTML = "No Results";
		}
	}
	
	//drawTrends();
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

function updateFilter(reportSelected) {
	if(reportSelected == "yearend") {
		document.getElementById("validationYearContainer").style.display = "none";
		document.getElementById("yearEndDiv").style.display = "inherit";
	} else if(reportSelected == "validation") {
		document.getElementById("validationYearContainer").style.display = "inherit";
		document.getElementById("yearEndDiv").style.display = "none";
	}
}