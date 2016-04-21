var yearsSearch = [];
var validationYears = [];
var provinceSearch = [];
var cenroSearch = [];
var orgNameSearch = [];
var specieSearch = [];
var provinces = {};
var cenros = {};
var seedlings;
var validation;
var site = {};
var years = {};
var yearsArray = [];
var tables = [];
var newWindow2;
var validationsPool = {};
var inventoryPool = {};
var sortable = [];
var overallInventory = {};
var reportType;
var yearSelected;

var entry = {"sYear":[],"vYear":[],"province":[],"cenro":[],"orgname":[],"species":[]};

$('#sYearInput').keyup(function(e){
    if(e.keyCode == 13) {
        enter("sYear");
    }
});

$('#vYearInput').keyup(function(e){
    if(e.keyCode == 13) {
        enter("vYear");
    }
});

$('#provinceInput').keyup(function(e){
    if(e.keyCode == 13) {
        enter("province");
    }
});

$('#cenroInput').keyup(function(e){
    if(e.keyCode == 13) {
        enter("cenro");
    }
});

$('#orgnameInput').keyup(function(e){
    if(e.keyCode == 13) {
        enter("orgname");
    }
});

$('#speciesInput').keyup(function(e){
    if(e.keyCode == 13) {
        enter("species");
    }
});


$.get("autocomplete2.php?q=species").done(function(data) {
	specieSearch = data.split(",");
	
	$('#speciesInput').autocomplete({
		source: function(request, response) {
			var results = $.ui.autocomplete.filter(specieSearch, request.term);
			response(results.slice(0, 5));
		}
	});	
});

$.get("autocomplete2.php?q=year").done(function(data) {
	yearsSearch = data.split(",");
			
	$("#sYearInput").autocomplete({
		source: function(request, response) {
			var results = $.ui.autocomplete.filter(yearsSearch, request.term);
			response(results.slice(0, 5));
		}
	});
});

$.get("autocomplete2.php?q=vyear").done(function(data) {
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

$.get("autocomplete2.php?q=province").done(function(data) {
	provinceSearch = data.split(",");
	
	$("#provinceInput").autocomplete({
		source: function(request, response) {
			var results = $.ui.autocomplete.filter(provinceSearch, request.term);
			response(results.slice(0, 5));
		}
	});
});
	
$.get("autocomplete2.php?q=cenro").done(function(data) {
	cenroSearch = data.split(",");
	$("#cenroInput").autocomplete({
		source: function(request, response) {
			var results = $.ui.autocomplete.filter(cenroSearch, request.term);
			response(results.slice(0, 5));
		}
	});
});
	
$.get("autocomplete2.php?q=orgname").done(function(data) {
	orgNameSearch = data.split(",");
	
	$("#orgnameInput").autocomplete({
		source: function(request, response) {
			var results = $.ui.autocomplete.filter(orgNameSearch, request.term);
			response(results.slice(0, 5));
		}
	});
	
});


function enter(category) {
	var inputboxID = "#" + category + "Input";
	var labelID = "#" + category + "Selected";
	var value = $(inputboxID).val().trim();
	if(value.length > 0) {
		var pID = category + "-" + value.replace(/\s/g, '');
		var pID2 = category + "-" + value;
		
		if(entry[category].indexOf(value) < 0) {
			entry[category].push(value);
			
			$(labelID).append('<p id=' + pID + '>' + value + '<button id="removeButton" onclick="removeEntry(\'' + pID2 + '\');">X</button></p>');
			
			$(inputboxID).val("");
		}	
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
	
	
	counter = 0;
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
	
	
	if(queryStringSeedlings == "WHERE") {
		queryStringSeedlings = "";
	}
	
	if(queryStringValidation == "WHERE") {
		queryStringValidation = "";
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
				site[seedlings[i].sitecode]["province"] = seedlings[i].provinceName;
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
		provinces = {};
		cenros = {};
		validation = JSON.parse(data);
		for(var i = 0; i < validation.length; i++) {
			if(validationsPool.hasOwnProperty(validation[i].siteID) == false) {
			validationsPool[validation[i].siteID] = {};
			}
			if(validationsPool[validation[i].siteID].hasOwnProperty(validation[i].startDate)) {
				if(validationsPool[validation[i].siteID][validation[i].startDate].hasOwnProperty(validation[i].commonname)) {
					validationsPool[validation[i].siteID][validation[i].startDate][validation[i].commonname]["quantity"] += parseInt(validation[i].quantity);
				} else {
					validationsPool[validation[i].siteID][validation[i].startDate][validation[i].commonname] = {};
					validationsPool[validation[i].siteID][validation[i].startDate][validation[i].commonname]["quantity"] = parseInt(validation[i].quantity); 
				}
				
				lastSite = validation[i].siteID;
				lastDate = validation[i].startDate;
			} else {
				validationsPool[validation[i].siteID][validation[i].startDate] = {};
				validationsPool[validation[i].siteID][validation[i].startDate][validation[i].commonname] = {};
				validationsPool[validation[i].siteID][validation[i].startDate][validation[i].commonname]["quantity"] = parseInt(validation[i].quantity); 
			}
			
			if(site.hasOwnProperty(validation[i].sitecode) == false) {
				site[validation[i].sitecode] = {};
				site[validation[i].sitecode]["validation"] = {};
			}
			
			if(site[validation[i].sitecode].hasOwnProperty("Year") == false) {
				site[validation[i].sitecode]["Year"] = validation[i].year;
			}
			
			if(site[validation[i].sitecode].hasOwnProperty("Cenro") == false) {
				site[validation[i].sitecode]["Cenro"] = validation[i].cenroName;
				
				if(cenros.hasOwnProperty(validation[i].cenroName)) {
					cenros[validation[i].cenroName] += 1;
				} else {
					cenros[validation[i].cenroName] = 1;
				}
			}
			
			
			if(site[validation[i].sitecode].hasOwnProperty("Province") == false) {
				site[validation[i].sitecode]["Province"] = validation[i].provinceName;
				
				if(provinces.hasOwnProperty(validation[i].provinceName)) {
					provinces[validation[i].provinceName] += 1;
				} else {
					provinces[validation[i].provinceName] = 1;
				}
			}
			
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
		
		for(var key in validationsPool) {
			var lastDate = new Date("1900-01-01 00:00:00");
			var lastDateString = "";
			var latestDate = "";
			
			for(var key2 in validationsPool[key]) {
				var newDate = new Date(key2);
				if(newDate > lastDate) {
					latestDate = key2;
				} else {
					latestDate = lastDateString;
				}
				lastDate = newDate;
				lastDateString = key2;
			}
			
			for(var key3 in validationsPool[key][latestDate]) {
				if(key3 != "survivalRate" && key3 != "total") {
					if(inventoryPool.hasOwnProperty(key) == false) {
						inventoryPool[key] = {};
					}
					inventoryPool[key][key3] = parseInt(validationsPool[key][latestDate][key3]["quantity"]);
				}
			}
		}
		
		var counter = 0;
		for(var key in inventoryPool) {
			for(var key2 in inventoryPool[key]) {
				if(overallInventory.hasOwnProperty(key2)) {
					overallInventory[key2] += inventoryPool[key][key2];
				} else {
					overallInventory[key2] = inventoryPool[key][key2];
				}
			}
		}
		
		sortable = [];
		for (var key in overallInventory) {
			sortable.push([key, overallInventory[key]]);
			sortable.sort(function(a, b) {return b[1] - a[1]});
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
		
		reportType = $("#reportType option:selected").text();
		yearSelected = $("#yearEndValue").val();
		
		if($("#reportType").val() == "validation") {
			drawTable1();
		} else if($("#reportType").val() == "yearend") {
			drawTable2();
		}
	});

}

function drawCharts() {
	var provinceArray = [['Province', 'Number of Sites']];
	var counter = 1;
	
	for(var key in provinces) {
		if(isFinite(provinces[key])) {
			provinceArray[counter] = [key, provinces[key]];
			counter++;
		}
	}
	
	var provinceData = google.visualization.arrayToDataTable(provinceArray);
	
	var options = {
	  title: 'Number of NGP Sites by Province',
	  width: '100%',
	  height: '100%',
	  'chartArea': {'width': '90%'},
	  'legend': {'position': 'bottom'},
	};

	var chart = new google.visualization.PieChart(newWindow2.document.getElementById('provinceChart'));

	chart.draw(provinceData, options);
	
	
	var cenroArray = [['CENRO', 'Number of Sites']];
	counter = 1;
	
	for(var key in cenros) {
		if(isFinite(cenros[key])) {
			cenroArray[counter] = [key, cenros[key]];
			counter++;
		}
	}
	
	var cenroData = google.visualization.arrayToDataTable(cenroArray);
	
	var options2 = {
	  title: 'NGP Sites per CENRO',
	  legend: 'none'
	};

	var chart2 = new google.visualization.BarChart(newWindow2.document.getElementById('cenroChart'));

	chart2.draw(cenroData, options2);
	
	
	var dataArray = [['Species', 'Quantity']];
	var counter = 1;
	var othersCount = 0;
	
	for(var i = 0; i < sortable.length; i++) {
		if(i < 14) {
			dataArray[counter] = [sortable[i][0], sortable[i][1]];
			counter++;
		} else {
			othersCount += sortable[i][1];
		}
	}
	
	dataArray[counter] = ["Others", othersCount];
	var treesData = google.visualization.arrayToDataTable(dataArray);
	
	var options = {
		title: 'NGP Sites Tree Count',
		legend: 'none'
	};
	
	var chart = new google.visualization.BarChart(newWindow2.document.getElementById('treeChart'));
	
	chart.draw(treesData, options);
}

function drawTable2() {
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
		//table.appendChild(tr0);
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
			
							
			if(counter1 >= counter2) {
				var rowspanValue = counter1;
			} else {
				var rowspanValue = counter2;
			}
			
			if(counter1 > 0 && counter2 > 0) {
				var tr1 = document.createElement('tr');
				var td1 = document.createElement('td');
				var td2 = document.createElement('td');
				var td3 = document.createElement('td');
				var tdProvince = document.createElement('td');
				var tdTotal = document.createElement('td');
				var tdTotalQty = document.createElement('td');
				var tdAreaSeedlings = document.createElement('td');
				td1.style.textAlign = "center"
				tdProvince.style.textAlign = "center";
				td2.style.textAlign = "center"
				td3.style.textAlign = "left"
				tdTotal.style.textAlign = "right"
				tdTotalQty.style.textAlign = "left"
				tdAreaSeedlings.style.textAlign = "right"
				
				var speciesSeedlings = "";
				var speciesValidations = "";
				var counterA = 0;
				var counterB = 0;
				
				for(var x = 0; x < rowspanValue-1; x++) {
					if(site[key]["seedlingsArray"]) {
						
						if(x >= site[key]["seedlingsArray"].length) {
							
						} else {
							if(counterA == 0) {
								speciesSeedlings += site[key]["seedlingsArray"][x].split(":")[0];
							} else {
								speciesSeedlings += ", " + site[key]["seedlingsArray"][x].split(":")[0];
							}
							counterA++;
						}
					}
					
					for(var key2 in site[key]["validation"]) {
						var targetDate = key2.split(" ")[0].split("-")[0];
						if(targetDate == yearsArray[i]) {
							if(site[key]["validation"][key2]["validationArray"]) {
								
								if(x >= site[key]["validation"][key2]["validationArray"].length) {
									
								} else {
									if(counterB == 0) {
										speciesValidations += site[key]["validation"][key2]["validationArray"][x].split(":")[0];
									} else {
										speciesValidations += ", " + site[key]["validation"][key2]["validationArray"][x].split(":")[0];
									}
									counterB++;
								}
							}
						}
					}
				}
				
				
				var yearNode = document.createTextNode(site[key + ""]["Year"]);
				var provinceNode = document.createTextNode(site[key+""]["Province"]);
				var cenroNode = document.createTextNode(site[key + ""]["Cenro"]);
				var siteNode = document.createTextNode(key);
				var seedlingsTotal = document.createTextNode(site[key + ""]["totalSeedlings"]);
				var areaSeedlingsNode = document.createTextNode(site[key + ""]["seedlingsArea"]);
				
				td1.appendChild(yearNode);
				//td1.rowSpan = rowspanValue;
				td2.appendChild(cenroNode);
				//td2.rowSpan = rowspanValue;
				td3.appendChild(siteNode);
				//td3.rowSpan = rowspanValue;
				tdProvince.appendChild(provinceNode);
				//tdProvince.rowSpan = rowspanValue;
				tdTotal.appendChild(seedlingsTotal);
				tdTotalQty.appendChild(document.createTextNode(speciesSeedlings));
				tdAreaSeedlings.appendChild(areaSeedlingsNode);
				
				tr1.appendChild(td1);
				tr1.appendChild(tdProvince);
				tr1.appendChild(td2);
				tr1.appendChild(td3);
				tr1.appendChild(tdTotalQty);
				tr1.appendChild(tdTotal);
				tr1.appendChild(tdAreaSeedlings);
				
				for(var key2 in site[key]["validation"]) {
					var targetDate = key2.split(" ")[0].split("-")[0];
					if(targetDate == yearsArray[i]) {
						var dateNode = document.createTextNode(key2.split(" ")[0]);
						var totalNode = document.createTextNode(speciesValidations);
						var totalQty = document.createTextNode(site[key]["validation"][key2]["stats"]["totalQuantity"]);
						var areaNode = document.createTextNode(site[key]["validation"][key2]["stats"]["Area"]);
						var srNode = document.createTextNode(site[key]["validation"][key2]["stats"]["sr"].toFixed(2));
						
						var tdValidationDate = document.createElement('td');
						var tdValidationTotal = document.createElement('td');
						var tdValidationTotalQty = document.createElement('td');
						var tdValidationAreaNode = document.createElement('td');
						var tdSr = document.createElement('td');
						tdValidationDate.style.textAlign = "left"
						tdValidationTotal.style.textAlign = "left"
						tdValidationTotalQty.style.textAlign = "right"
						tdValidationAreaNode.style.textAlign = "right"
						tdSr.style.textAlign = "right"
						
						tdValidationDate.appendChild(dateNode);
						//tdValidationDate.rowSpan = rowspanValue;
						tdValidationTotal.appendChild(totalNode);
						tdValidationTotalQty.appendChild(totalQty);
						tdValidationAreaNode.appendChild(areaNode);
						//tdValidationAreaNode.rowSpan = rowspanValue;
						tdSr.appendChild(srNode);
						//tdSr.rowSpan = rowspanValue;
						
						tr1.appendChild(tdValidationDate);
						tr1.appendChild(tdValidationTotal);
						tr1.appendChild(tdValidationTotalQty);
						tr1.appendChild(tdValidationAreaNode);
						tr1.appendChild(tdSr);
						break;
					}
				}
				
				tables[i].appendChild(tr1);
				
				
				
				
			}
			
			
			
		}
	}
	
	newWindow2 = window.open('reportingBackend2.php');
	newWindow2.window.onload = function() {
		newWindow2.document.getElementById('table_div').innerHTML = "";
		if(tables.length > 0) {
			newWindow2.document.getElementById('reportTitle').innerHTML = yearSelected + " " + reportType;
			for(var i = 0; i < tables.length; i++) {
				newWindow2.document.getElementById('table_div').appendChild(tables[i]);
			}
			
			drawCharts();
		} else {
			newWindow2.document.getElementById('table_div').innerHTML = "No Results";
		}
	}

}

function drawTable1() {
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
		
		//tr0.appendChild(th0);
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
		//table.appendChild(tr0);
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
				var tdProvince = document.createElement('td');
				
				td1.style.textAlign = "center"
				td2.style.textAlign = "center"
				td3.style.textAlign = "left"
				tdTotal.style.textAlign = "right"
				tdTotalQty.style.textAlign = "left"
				tdAreaSeedlings.style.textAlign = "right"
				tdProvince.style.textAlign = "center";
				
				var yearNode = document.createTextNode(site[key + ""]["Year"]);
				var cenroNode = document.createTextNode(site[key + ""]["Cenro"]);
				var siteNode = document.createTextNode(key);
				var seedlingsTotal = document.createTextNode(site[key + ""]["totalSeedlings"]);
				var areaSeedlingsNode = document.createTextNode(site[key + ""]["seedlingsArea"]);
				var provinceNode = document.createTextNode(site[key + ""]["Province"]);
				
				if(counter1 >= counter2) {
					var rowspanValue = counter1;
				} else {
					var rowspanValue = counter2;
				}
				
				td1.appendChild(yearNode);
				td1.rowSpan = rowspanValue;
				tdProvince.appendChild(provinceNode);
				tdProvince.rowSpan = rowspanValue;
				td2.appendChild(cenroNode);
				td2.rowSpan = rowspanValue;
				td3.appendChild(siteNode);
				td3.rowSpan = rowspanValue;
				tdTotal.appendChild(seedlingsTotal);
				tdTotalQty.appendChild(document.createTextNode("Total"));
				tdAreaSeedlings.appendChild(areaSeedlingsNode);
				
				tdAreaSeedlings.rowSpan = rowspanValue;
				tr1.appendChild(td1);
				tr1.appendChild(tdProvince);
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
						tdValidationDate.style.textAlign = "left"
						tdValidationTotal.style.textAlign = "left"
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
					tdKey.style.textAlign = "left"
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
							tdKey2.style.textAlign = "left"
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
		newWindow.document.getElementById('reportTitle').innerHTML = reportType;
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
		document.getElementById("yearEndDiv").style.display = "block";
		entry["vYear"] = [];
		entry["vYear"][0] = $("#yearEndValue").val();
		$("#vYearSelected").val("");
	} else if(reportSelected == "validation") {
		document.getElementById("validationYearContainer").style.display = "block";
		document.getElementById("yearEndDiv").style.display = "none";
		entry["vYear"] = [];
	}
}

function updatevYear(year) {
	entry["vYear"][0] = year;
}