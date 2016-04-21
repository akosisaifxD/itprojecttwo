var province = {};
var years = {};
var colors = {};
var validationsPool = {};
var inventoryPool = {};
var overallInventory = {};

$.get("getsitestats.php").done(function(data) {
	var results = JSON.parse(data);
			
	for(var i = 0; i < results.length; i++) {
		if(years.hasOwnProperty(results[i].year)) {
			years[results[i].year] += 1;
		} else {
			years[results[i].year] = 1;
		}
		
		if(province.hasOwnProperty(results[i].provinceName)) {
			province[results[i].provinceName] += 1;
		} else {
			province[results[i].provinceName] = 1;
		}
		
		if(colors.hasOwnProperty(results[i].year)) {
			
		} else {
			colors[results[i].year] = results[i].color;
		}
	}
	
	drawTrends();
});

var sortable;

$.get("treesstats.php").done(function(data) {
	var trees = JSON.parse(data);
	var lastDate = "";
	var lastSite = "";
	
	for(var i = 0; i < trees.length; i++) {
		if(validationsPool.hasOwnProperty(trees[i].siteID) == false) {
			validationsPool[trees[i].siteID] = {};
		}
		if(validationsPool[trees[i].siteID].hasOwnProperty(trees[i].startDate)) {
			if(validationsPool[trees[i].siteID][trees[i].startDate].hasOwnProperty(trees[i].commonname)) {
				validationsPool[trees[i].siteID][trees[i].startDate][trees[i].commonname]["quantity"] += parseInt(trees[i].quantity);
			} else {
				validationsPool[trees[i].siteID][trees[i].startDate][trees[i].commonname] = {};
				validationsPool[trees[i].siteID][trees[i].startDate][trees[i].commonname]["quantity"] = parseInt(trees[i].quantity); 
			}
			
			lastSite = trees[i].siteID;
			lastDate = trees[i].startDate;
		} else {
			validationsPool[trees[i].siteID][trees[i].startDate] = {};
			validationsPool[trees[i].siteID][trees[i].startDate][trees[i].commonname] = {};
			validationsPool[trees[i].siteID][trees[i].startDate][trees[i].commonname]["quantity"] = parseInt(trees[i].quantity); 
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
	
	drawTreeChart();
});

$.get("getsitestats.php").done(function(data) {
	var results = JSON.parse(data);
			
	for(var i = 0; i < results.length; i++) {
		if(years.hasOwnProperty(results[i].year)) {
			years[results[i].year] += 1;
		} else {
			years[results[i].year] = 1;
		}
		
		if(province.hasOwnProperty(results[i].provinceName)) {
			province[results[i].provinceName] += 1;
		} else {
			province[results[i].provinceName] = 1;
		}
		
		if(colors.hasOwnProperty(results[i].year)) {
			
		} else {
			colors[results[i].year] = results[i].color;
		}
	}
	
	drawTrends();
});


function drawTrends() {
	var yearsArray = [['Year', 'Number of Sites']];
	var counter = 1;
	var slicesArray = [];
	
	for(var key in years) {
		if(isFinite(years[key])) {
			yearsArray[counter] = [key, years[key]];
			slicesArray[counter-1] = {'color': colors[key]};
			counter++;
		}
	}
	
	var yearData = google.visualization.arrayToDataTable(yearsArray);
	
	var options = {
	  title: 'Total Number of NGP Sites in CAR',
	  slices: slicesArray,
	  is3D: true,
	  width: '100%',
	  height: '100%',
	  'chartArea': {'width': '90%', 'height': '90%'},
	  'legend': {'position': 'bottom'},
	pieSliceTextStyle:{color: 'black', fontSize: '15', bold:'true'}
 
	};

	var chart = new google.visualization.PieChart(document.getElementById('yearsites'));

	chart.draw(yearData, options);
	
	var provinceArray = [['Province', 'Number of Sites']];
	counter = 1;
	
	for(var key in province) {
		if(isFinite(province[key])) {
			provinceArray[counter] = [key, province[key]];
			counter++;
		}
	}
	
	var provinceData = google.visualization.arrayToDataTable(provinceArray);
	
	var options2 = {
	  title: 'NGP Sites Distribution'
	};

	var chart2 = new google.visualization.BarChart(document.getElementById('provincesites'));

	chart2.draw(provinceData, options2);
}

function drawTreeChart() {
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
		title: 'NGP Sites Tree Count'
	};
	
	var chart = new google.visualization.BarChart(document.getElementById('treechart'));
	
	chart.draw(treesData, options);
}