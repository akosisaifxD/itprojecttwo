var site;
var trees;
var seedlings;
var siteAttributesPool = {};
var validationsPool = {};
var seedlingsPool = {};
var inventoryPool = {};
var statsPool = {};
var searchResults = "initial";
var remove = {};

var years = {};
var overallInventory = {};
var map;
var minYear = 9999;
var maxYear = 0;
var paused = false;
var stopped = true;

var filteredYear = false;
var filteredSearch = false;

var statistics = {};

var opt;
var value0;
var value1;
var oV2; // original value
var cV2; //current value

var searchValue = "";
var searchCategory = "";
var searchValue1 = "";
var searchValue2 = "";
var searchCategory1 = "";
var searchCategory2 = "";

var chartcat = $('input[name=chart]:radio:checked').val();
var chartcatcompare = $('input[name=comparecat]:radio:checked').val();
var result;
var dynamicsearch = [];

var chartWorker = new Worker('scripts/chartworker.js');
var tableWorker = new Worker('scripts/tableworker.js');
var setmapWorker = new Worker('scripts/setmapworker.js');
var area1Worker = new Worker('scripts/chartarea1.js');
var area2Worker = new Worker('scripts/chartarea2.js');

chartWorker.addEventListener('message', function(e) {
	var x = e.data.split("-parse-parse-");
	years = JSON.parse(x[1]);
	var dataArray = JSON.parse(x[0]);

	var data = google.visualization.arrayToDataTable(dataArray);

	if(chartcat == "survivalRate") {
		var titleCombo = "Survival Rate\n";
		titleCombo += "Year: "+ value0 + " - " + value1 + "\n";
		if(searchCategory != "" && searchValue != "") {
			titleCombo += searchCategory + ": " + searchValue;
		}
	} else if(chartcat == "growthRate") {
		var titleCombo = "Growth Rate\n";
		titleCombo += "Year: "+ value0 + " - " + value1 + "\n";
		if(searchCategory != "" && searchValue != "") {
			titleCombo += searchCategory + ": " + searchValue;
		}
	} else if(chartcat == "maturityRate") {
		var titleCombo = "Maturity Rate\n";
		titleCombo += "No data available.";
	}
	
	drawChart(data, titleCombo);
}, false);

tableWorker.addEventListener('message', function(e) {
	var x = e.data.split("-parse-parse-");
	var dataArray = JSON.parse(x[0]);
	
	overallInventory = JSON.parse(x[1]);
	
	var data = google.visualization.arrayToDataTable(dataArray);
	
	drawInventory(data);
}, false);

setmapWorker.addEventListener('message', function(e){
	var resultingKeys = JSON.parse(e.data);
	
	for(var key in siteAttributesPool) {
		if(resultingKeys.hasOwnProperty(key) == true && siteAttributesPool[key].isSet == true) {
			
		} else if(resultingKeys.hasOwnProperty(key) == true && siteAttributesPool[key].isSet == false) {
			siteAttributesPool[key].polygon.setMap(map);
			siteAttributesPool[key].isSet = true;
		} else if(resultingKeys.hasOwnProperty(key) == false && siteAttributesPool[key].isSet == true) {
			siteAttributesPool[key].polygon.setMap(null);
			siteAttributesPool[key].isSet = false;
		}
	}
});

area1Worker.addEventListener('message', function(e){
	dataArray1 = JSON.parse(e.data);
	mergeArrayData = dataArray1;
	
	var data = google.visualization.arrayToDataTable(dataArray1);
	
	if(chartcatcompare == "survivalRate") {
		var titleCombo = "Survival Rate\n";
		titleCombo += "Year: "+ minYear + " - " + maxYear;
	} else if(chartcatcompare == "growthRate") {
		var titleCombo = "Growth Rate\n";
		titleCombo += "Year: "+ minYear + " - " + maxYear;
	} else if(chartcatcompare == "maturityRate") {
		var titleCombo = "Maturity Rate\n";
		titleCombo += "No data available.";
	}
	
	drawChartArea1(data, titleCombo);
});

area2Worker.addEventListener('message', function(e){
	dataArray2 = JSON.parse(e.data);
	
	var data = google.visualization.arrayToDataTable(dataArray2);
	
	if(chartcatcompare == "survivalRate") {
		var titleCombo = "Survival Rate\n";
		titleCombo += "Year: "+ minYear + " - " + maxYear;
	} else if(chartcatcompare == "growthRate") {
		var titleCombo = "Growth Rate\n";
		titleCombo += "Year: "+ minYear + " - " + maxYear;
	} else if(chartcatcompare == "maturityRate") {
		var titleCombo = "Maturity Rate\n";
		titleCombo += "No data available.";
	}
	
	drawChartArea2(data, titleCombo);
});

function seedlingsObject() {
	this.seedlings = {"total":0};
}

function siteAttributes(id, year, color) {
	this.id = id;
	this.year = year;
	this.color = color;
	this.polygon = {};
	this.iWindow = 0;
	this.isSet = true;
	this.seedlings = {"total": 0};
	this.validation = {};
	this.inventory = {};
	this.stats = {};
}

function init() {
	$.when(
		$.get("initialize.php").done(function(data) {
			site = JSON.parse(data);
		}),
		
		$.get("treesstats.php").done(function(data) {
			trees = JSON.parse(data);
		}),
		
		$.get("seedlings.php").done(function(data) {
			seedlings = JSON.parse(data);
		})
	).then(function() {
		initMap();
	});
}

function initMap() {
	$('ul.tabs li').click(function() {
		var tab_id = $(this).attr('data-tab');

		$('ul.tabs li').removeClass('current');
		$('.tab-content').removeClass('current');

		$(this).addClass('current');
		$("#" + tab_id).addClass('current');
	});
	
	var styles = [
    {
        "featureType": "all",
        "elementType": "labels.text",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "administrative",
        "elementType": "labels.text",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "administrative.province",
        "elementType": "geometry",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "administrative.province",
        "elementType": "labels.text",
        "stylers": [
            {
                "hue": "#ff0000"
            },
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "administrative.locality",
        "elementType": "labels.text",
        "stylers": [
            {
                "color": "#9f5b38"
            },
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "administrative.neighborhood",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "administrative.neighborhood",
        "elementType": "geometry",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "administrative.neighborhood",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "administrative.neighborhood",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "administrative.neighborhood",
        "elementType": "labels",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "administrative.neighborhood",
        "elementType": "labels.text",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "administrative.land_parcel",
        "elementType": "geometry",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "administrative.land_parcel",
        "elementType": "labels",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "administrative.land_parcel",
        "elementType": "labels.text",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "geometry",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "landscape.man_made",
        "elementType": "geometry",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "landscape.man_made",
        "elementType": "labels.text",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "landscape.natural.landcover",
        "elementType": "geometry",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "landscape.natural.landcover",
        "elementType": "labels.text",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "landscape.natural.terrain",
        "elementType": "geometry",
        "stylers": [
            {
                "visibility": "off"
            },
            {
                "lightness": "-13"
            },
            {
                "saturation": "43"
            },
            {
                "gamma": "0.00"
            }
        ]
    },
    {
        "featureType": "landscape.natural.terrain",
        "elementType": "labels.text",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "poi.attraction",
        "elementType": "geometry",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "poi.attraction",
        "elementType": "labels",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "poi.business",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "poi.government",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "poi.medical",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "poi.park",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "poi.place_of_worship",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "poi.school",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "poi.sports_complex",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    }
];
	var styledMap = new google.maps.StyledMapType(styles, {name: "Map"});
	
	var mapOptions = {
		zoom: 9,
		center: new google.maps.LatLng(16.52023885, 120.8456877),
		mapTypeControlOptions: {
		  mapTypeIds: ['hybrid', 'map_style'],
		  style: google.maps.MapTypeControlStyle.VERTICAL_BAR,
		  position: google.maps.ControlPosition.LEFT_CENTER
		}
	};
	
	map = new google.maps.Map(document.getElementById('map'), mapOptions);
	map.mapTypes.set('map_style', styledMap);
	map.setMapTypeId('map_style');
	google.maps.event.addListener(map, 'maptypeid_changed', function() {
		if(this.getMapTypeId()=='hybrid') {
			this.setOptions(
                {
                  styles:[
                          {
                            featureType: "road",
                            stylers: [{ visibility:'off'}]
						  },
						  {
							featureType: "water",
							elementType: "all",
							stylers: [
								{
									"visibility": "off"
								}
							] 
						  }
                        ]
                }
			);

			
		}
	});
	google.maps.event.trigger(map,'maptypeid_changed');
	
	var lastSiteAdded = site[0].siteID;
	var coords;
	var counter = 0;
	var siteID;
	for(var i = 0; i < site.length; i++){
		if(lastSiteAdded == site[i].siteID && i != 0) {

			var point = new google.maps.LatLng(parseFloat(site[i].latitude), parseFloat(site[i].longitude));
			coords.insertAt(coords.length, point);
			
			if(i == site.length-1) {
				var sitePolygon = new google.maps.Polygon({
					paths: coords,
					strokeColor: siteAttributesPool[lastSiteAdded + ""].color,
					strokeOpacity: 0.8,
					strokeWeight: 1,
					fillColor: siteAttributesPool[lastSiteAdded + ""].color,
					fillOpacity: 0.35
				});
				
				siteAttributesPool[lastSiteAdded + ""].polygon = sitePolygon;
				sitePolygon.setMap(map);
			}
		} else {
			if(i != 0) {
				var sitePolygon = new google.maps.Polygon({
					paths: coords,
					strokeColor: siteAttributesPool[lastSiteAdded + ""].color,
					strokeOpacity: 0.8,
					strokeWeight: 1,
					fillColor: siteAttributesPool[lastSiteAdded + ""].color,
					fillOpacity: 0.35
				});
				
				siteAttributesPool[lastSiteAdded + ""].polygon = sitePolygon;
				sitePolygon.setMap(map);
				counter++;
			}
			
			var point = new google.maps.LatLng(parseFloat(site[i].latitude), parseFloat(site[i].longitude));
			var x = new siteAttributes(site[i].siteID, site[i].year, site[i].color);
			siteID = site[i].siteID + "";
			siteAttributesPool[siteID] = x;

			if(years[site[i].year] === undefined) {
				years[site[i].year] = {};
				years[site[i].year]["color"] = site[i].color;
				years[site[i].year]["survivalRate"] = 0;
				years[site[i].year]["survivalRateSum"] = 0;
				years[site[i].year]["survivalRateCount"] = 0;
				years[site[i].year]["growthRate"] = 0;
			}
			
			coords = new google.maps.MVCArray();
			coords.insertAt(coords.length, point);
		}
		lastSiteAdded = site[i].siteID;
    }
	
	setLegend("initial");
	setSlider();
	getAutoComplete("province");
	getAutoComplete("province", "forcompare");
	search1("initial");
	search2("initial");
	setStats();
	setAreaInfo();
}

/*
sets legend when:
initial (pass "iniital" string when all the years need to be selected)
filtered by year (pass "filtered" string and get years selected)
heatmap applied for survival rate
heatmap applied for trees(?tentative. no permanent algorithm yet)
*/
function setLegend(category, combinatons) {
	//initial legend
	if(category == "initial") {
		$("#legend_div").html("");
		for(var key in years) {
			if(parseInt(key) > maxYear) {
				maxYear = parseInt(key);
			}
			
			if(parseInt(key) < minYear) {
				minYear = parseInt(key);
			}
			$("#legend_div").append(key + "<div id='legendColor' style='background-color:" + years[key]["color"] + ";'></div>" + "\n");
		}
	
		value0 = minYear;
		value1 = maxYear;
	} else if(category == "survivalrate") {
		$("#legend_div").html("");
		$("#legend_div").append("Above 85%<div id='legendColor' style='background-color: yellow;'></div>\n");
		$("#legend_div").append("<hr/>");
		$("#legend_div").append("Below 85%<div id='legendColor' style='background-color: red;'></div>\n");
	} else if(category == "filtered") {
		
	}
	
}

/*
sets slider for filtering years:
minYear - minimum year from database
maxYear - maximum year from database
*/

function setSlider() {
	$("#slider-range").slider({
		range: true,
		min: minYear,
		max: maxYear,
		values: [minYear, maxYear],
		animate: "fast",
		step: 1,
		slide: function(event, ui) {
			paused = false;
			stopped = true;
			value0 = ui.values[0];
			value1 = ui.values[1];
			filter();
		}
	}).each(function() {
		opt = $(this).data().uiSlider.options;
		var vals = opt.max - opt.min;
		for (var i = 0; i <= vals; i++) {
			var el = $('<label>' + (opt.min + i) + '</label>').css('left', (i / vals * 100) + '%');
			$("#slider-range").append(el);
		}
		
		$("#animatebtn").click(function() {
			value0 = opt.values[0];
			value1 = opt.values[1];
			var diff = value1 - value0;
			if (paused && !stopped) {
				var ct = (oV2 - cV2 - 4) * -1;
				diff = oV2 - value0;
				animate(diff, value0, ct);
				paused = false;
				stopped = false;
			} else {
				oV2 = value1;
				animate(diff, value0, 0);
			}
		});
	})
}

/*
code for temporal
*/

function animate(diff, v0, counter) {
	var interval = 2000;
	if (paused) {
		interval = 0;
	}
	setTimeout(function() {
		var v1 = v0 + (counter);
		counter++;
		if (counter <= diff + 1 && !paused) {
			$("#slider-range").slider('values', [v0, v1]);
			value1 = v1;
			filter();
			animate(diff, v0, counter);
		}

		if (counter > diff + 1) {
			stopped = true;
			paused = false;
		}
	}, interval);
}

function setAreaInfo() {
	for(var key in siteAttributesPool) {
		addInfoWindow(siteAttributesPool[key].polygon, siteAttributesPool[key].id);
	}
}

var lastId = 0;

function addInfoWindow(polygon, id) {
	polygon.addListener('click', function(e) {
		$.get("areainfo.php?q='" + id + "'").done(function(data) {
			result = JSON.parse(data);
			if(data == "[]") {
				var location = e.latLng;
				if(siteAttributesPool[id + ""].iWindow == 0) {
					var iWindow = new google.maps.InfoWindow;
					iWindow.setContent('<center><b>Area Informaton</b></center> <br/>'+
					'No data available.');
					iWindow.setPosition(location);
					iWindow.open(map);
					
					siteAttributesPool[id+""].iWindow = iWindow;
				} else {
					siteAttributesPool[id+""].iWindow.setPosition(location);
					siteAttributesPool[id+""].iWindow.open(map);
				}
			} else {
				var barangays = result[0].barangayname;
				var orgs = result[0].organizationname;
				var treeStats = "";
				if(result.length > 1) {
					for(var i = 1; i < result.length; i++) {
						if(barangays.indexOf(result[i].barangayname) == -1) {
							barangays += ", " + result[i].barangayname;
						}
						
						if(orgs.indexOf(result[i].organizationname) == -1) {
							orgs += ", " + result[i].organizationname;
						}
					}
					//console.log()
				}
				
				for(var key in inventoryPool[id + ""]) {
					//console.log(key);
					treeStats += key + ": " + inventoryPool[id][key] + "<br/>";			
				}
				
				if(treeStats == "") {
					treeStats = "No data available";
				}
				
				var location = e.latLng;
				if(siteAttributesPool[id + ""].iWindow == 0) {
					var iWindow = new google.maps.InfoWindow;
					iWindow.setContent('<center><b>Area Informaton</b></center> <br/> Province: ' + result[0].provincename + 
					'<br/> Municipality: ' + result[0].municipalityname + 
					'<br/>Barangay: ' + barangays + 
					'<br/> Declared Area: ' + result[0].declaredarea + 
					'<br/> Computed Area: ' + result[0].computedarea + 
					'<br/> Component: ' + result[0].component + 
					'<br/> Zone: ' + result[0].zone + 
					'<br/> Organization: ' + orgs + 
					'<br/> <center><b>Tree Statistics</b></center>' + 
					'<br/>' + treeStats);
					iWindow.setPosition(location);
					iWindow.open(map);
					
					siteAttributesPool[id+""].iWindow = iWindow;
				} else {
					siteAttributesPool[id+""].iWindow.setPosition(location);
					siteAttributesPool[id+""].iWindow.open(map);
				}
			}
			
		});
	});
}

function setStats() {
	for(var i = 0; i < seedlings.length; i++) {
		if(seedlingsPool.hasOwnProperty(seedlings[i].siteID) == false) {
			seedlingsPool[seedlings[i].siteID] = {};
			seedlingsPool[seedlings[i].siteID]["total"] = 0;
		}
		
		if(seedlingsPool[seedlings[i].siteID].hasOwnProperty(seedlings[i].commonname)) {
			seedlingsPool[seedlings[i].siteID][seedlings[i].commonname] += parseInt(seedlings[i].quantity);
			seedlingsPool[seedlings[i].siteID]["total"] += parseInt(seedlings[i].quantity);
		} else {
			seedlingsPool[seedlings[i].siteID][seedlings[i].commonname] = parseInt(seedlings[i].quantity);
			seedlingsPool[seedlings[i].siteID]["total"] += parseInt(seedlings[i].quantity);
		}
	}

	
	var lastDate = "";
	var lastSite = "";
	
	for(var i = 0; i < trees.length; i++) {
		if(validationsPool.hasOwnProperty(trees[i].siteID) == false) {
			validationsPool[trees[i].siteID] = {};
		}
		if(validationsPool[trees[i].siteID].hasOwnProperty(trees[i].startDate)) {
			if(validationsPool[trees[i].siteID][trees[i].startDate].hasOwnProperty(trees[i].commonname)) {
				//console.log("rare: " + i);
				validationsPool[trees[i].siteID][trees[i].startDate][trees[i].commonname]["quantity"] += parseInt(trees[i].quantity);
				validationsPool[trees[i].siteID][trees[i].startDate]["total"] += parseInt(trees[i].quantity);
				var targetYear = trees[i].startDate.split(" ")[0].split("-")[0];
				
				if(years.hasOwnProperty(targetYear)) {
					years[targetYear]["growthRate"] += parseInt(trees[i].quantity);
				}
				
				if(inventoryPool.hasOwnProperty(trees[i].siteID) == false) {
					inventoryPool[trees[i].siteID][trees[i].commonname] = {};
				}
				
				inventoryPool[trees[i].siteID][trees[i].commonname] = parseInt(validationsPool[trees[i].siteID][trees[i].startDate][trees[i].commonname]["quantity"]);
				
				if(seedlingsPool.hasOwnProperty(trees[i].siteID)) {
					if(seedlingsPool[trees[i].siteID].hasOwnProperty(trees[i].commonname)) {
						validationsPool[trees[i].siteID][trees[i].startDate][trees[i].commonname]["survivalRate"] = 
						(validationsPool[trees[i].siteID][trees[i].startDate][trees[i].commonname]["quantity"]/
						seedlingsPool[trees[i].siteID][trees[i].commonname]) * 100;
					}
				}
			} else {
				validationsPool[trees[i].siteID][trees[i].startDate][trees[i].commonname] = {};
				validationsPool[trees[i].siteID][trees[i].startDate][trees[i].commonname]["quantity"] = parseInt(trees[i].quantity); 
				validationsPool[trees[i].siteID][trees[i].startDate]["total"] += parseInt(trees[i].quantity);
				
				var targetDate = trees[i].startDate.split(" ")[0].split("-")[0];
				if(years.hasOwnProperty(targetDate)) {
					years[targetDate]["growthRate"] += parseInt(trees[i].quantity);
				}
				
				if(inventoryPool.hasOwnProperty(trees[i].siteID) == false) {
					inventoryPool[trees[i].siteID] = {};
				}
				
				inventoryPool[trees[i].siteID][trees[i].commonname] = parseInt(trees[i].quantity);
				
				if(seedlingsPool.hasOwnProperty(trees[i].siteID)) {
					if(seedlingsPool[trees[i].siteID].hasOwnProperty(trees[i].commonname)) {
						validationsPool[trees[i].siteID][trees[i].startDate][trees[i].commonname]["survivalRate"] = 
						(validationsPool[trees[i].siteID][trees[i].startDate][trees[i].commonname]["quantity"]/
						seedlingsPool[trees[i].siteID][trees[i].commonname]) * 100;
					}
				}
			}
			
			if(i == trees.length - 1) {
				var lastYear = (lastDate.split(" ")[0].split("-")[0]);
				var survivalRate = (validationsPool[trees[i].siteID][trees[i].startDate]["total"]/seedlingsPool[trees[i].siteID]["total"]) * 100;
				if(isFinite(survivalRate)) {
					if(statsPool.hasOwnProperty(lastSite) == false) {
						statsPool[lastSite] = {};
					}
					statsPool[lastSite]["survivalRate"] = survivalRate;
					validationsPool[lastSite][lastDate]["survivalRate"] = survivalRate;
					if(years.hasOwnProperty(lastYear)) {
						years[lastYear]["survivalRateSum"] += survivalRate;
						years[lastYear]["survivalRateCount"] += 1;
					}
				}
			}
			lastSite = trees[i].siteID;
			lastDate = trees[i].startDate;
		} else {
			validationsPool[trees[i].siteID][trees[i].startDate] = {};
			validationsPool[trees[i].siteID][trees[i].startDate][trees[i].commonname] = {};
			validationsPool[trees[i].siteID][trees[i].startDate][trees[i].commonname]["quantity"] = parseInt(trees[i].quantity); 
			validationsPool[trees[i].siteID][trees[i].startDate][trees[i].commonname]["survivalRate"] = 0;
			validationsPool[trees[i].siteID][trees[i].startDate]["total"] = parseInt(trees[i].quantity);
			
			var targetDate = trees[i].startDate.split(" ")[0].split("-")[0];
			if(years.hasOwnProperty(targetDate)) {
				years[targetDate]["growthRate"] += parseInt(trees[i].quantity);
			}
			
			if(inventoryPool.hasOwnProperty(trees[i].siteID) == false) {
				inventoryPool[trees[i].siteID] = {};
			}
			inventoryPool[trees[i].siteID][trees[i].commonname] = parseInt(trees[i].quantity);

			if(seedlingsPool.hasOwnProperty(trees[i].siteID)) {
				if(seedlingsPool[trees[i].siteID].hasOwnProperty(trees[i].commonname)) {
					validationsPool[trees[i].siteID][trees[i].startDate][trees[i].commonname]["survivalRate"] = 
					(validationsPool[trees[i].siteID][trees[i].startDate][trees[i].commonname]["quantity"]/
					seedlingsPool[trees[i].siteID][trees[i].commonname]) * 100;
				}
			}
			
			
			if(lastDate != trees[i].startDate && i != 0) {
				var lastYear = (lastDate.split(" ")[0].split("-")[0]);
				if(seedlingsPool.hasOwnProperty(lastSite)) {
					var survivalRate = (validationsPool[lastSite][lastDate]["total"]/seedlingsPool[lastSite]["total"]) * 100;
					if(isFinite(survivalRate)) {
						if(statsPool.hasOwnProperty(lastSite) == false) {
							statsPool[lastSite] = {};
						}
						statsPool[lastSite]["survivalRate"] = survivalRate;
						validationsPool[lastSite][lastDate]["survivalRate"] = survivalRate;
						if(years.hasOwnProperty(lastYear)) {
							years[lastYear]["survivalRateSum"] += survivalRate;
							years[lastYear]["survivalRateCount"] += 1;
						}
					}
				} else {
					
				}
				
			}
			
			
			lastSite = trees[i].siteID;
			lastDate = trees[i].startDate;
		}
		
		
	}
	setTrends();
}

function setTrends() {
	chartWorker.postMessage(JSON.stringify(searchResults) + "-parse-parse-" + JSON.stringify(years) + "-parse-parse-" + 
							chartcat + "-parse-parse-" + JSON.stringify(validationsPool));
	
	tableWorker.postMessage(JSON.stringify(searchResults) + "-parse-parse-" + JSON.stringify(inventoryPool));
}

function drawInventory(data) {
	var dashboard = new google.visualization.Dashboard(document.getElementById('tab-2'));

	var filterForString = new google.visualization.ControlWrapper({
		'controlType': 'StringFilter',
		'containerId': 'filter_div',
		'options': {
			'filterColumnLabel': 'Tree Specie'
		}
	});

	var table = new google.visualization.ChartWrapper({
		'chartType': 'Table',
		'containerId': 'table_div',
		'options': {
			width: 350,
			height: 300,
			showRowNumber: true,
			allowHtml: true
		}
	});

	dashboard.bind(filterForString, table);
	dashboard.draw(data);
}

function drawChart(data, titleCombo) {
	var options = {
		title: titleCombo,
		legend: {
			position: 'bottom'
		}
	};

	var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

	chart.draw(data, options);
}

function heatmapChart(isChecked) {
	if(isChecked) {
		for(var key in siteAttributesPool) {
			if(statsPool.hasOwnProperty(key) == false) {
				siteAttributesPool[key].polygon.setOptions({
					strokeWeight: 1,
					fillColor: 'red',
					strokeColor: 'red'
				});
			} else if(statsPool[key]["survivalRate"] >= 85) {
				siteAttributesPool[key].polygon.setOptions({
					strokeWeight: 1,
					fillColor: 'yellow',
					strokeColor: 'yellow'
				});
			} else {
				siteAttributesPool[key].polygon.setOptions({
					strokeWeight: 1,
					fillColor: 'red',
					strokeColor: 'red'
				});
			}
		}
		
		setLegend("survivalrate");
	} else {
		for(var key in siteAttributesPool) {
			siteAttributesPool[key].polygon.setOptions({
				strokeWeight: 1,
				fillColor: siteAttributesPool[key].color,
				strokeColor: siteAttributesPool[key].color
			});
		}
		
		setLegend("initial")
	}
}

function search() {
	searchValue = $("#search_val").val().trim();
	searchCategory = $("#search_choices").val();
	filter();
}

function filter() {
	searchResults = {};
	var queryString = "WHERE";
	
	var counter = 0;
	for(var i = value0; i <= value1; i++) {
		if(counter == 0) {
			queryString += "(site.year=" + i;
		} else {
			queryString += " OR site.year=" + i;
		}

		counter++;
	}
	
	queryString += ")";
	
	if(searchValue.length > 0) {
		if(searchCategory == "province") {//
			queryString += ' AND province.provinceName="' + searchValue + '"';
		} else if(searchCategory == "muni_city") {//
			queryString += ' AND municipality.municipalityName="' + searchValue + '"';
		} else if(searchCategory == "cenro") {//
			queryString += ' AND cenro.cenroName="' + searchValue + '"';
		} else if(searchCategory == "components") {//
			queryString += ' AND site.component="' + searchValue + '"';
		} else if(searchCategory == "zone") {
			queryString += ' AND site.zone="' + searchValue + '"';
		} else if(searchCategory == "species") {
			queryString += ' AND species.commonName="' + searchValue + '"';
		} else if(searchCategory == "commodities") {
			queryString += ' AND commodity.commodityName="' + searchValue + '"';
		} else if(searchCategory == "orgname") {//
			queryString += ' AND organization.organizationName="' + searchValue + '"';
		} else if(searchCategory == "orgtype") {//
			queryString += ' AND organizationType.organizationTypeName="' + searchValue + '"';
		}
	}
	
	$.get("filter.php?q= " + queryString).done(function(data) {
		searchResults = JSON.parse(data);
		setmapWorker.postMessage(JSON.stringify(searchResults));
		chartWorker.postMessage(JSON.stringify(searchResults) + "-parse-parse-" + JSON.stringify(years) + "-parse-parse-" + chartcat + "-parse-parse-" + JSON.stringify(validationsPool));
		tableWorker.postMessage(JSON.stringify(searchResults) + "-parse-parse-" + JSON.stringify(inventoryPool));
	});
}

function applyFilter() {	
	for(var key in siteAttributesPool) {
		if(searchResults.hasOwnProperty(key) == true && siteAttributesPool[key].isSet == false) {
			siteAttributesPool[key].polygon.setMap(map);
			siteAttributesPool[key].isSet = true;
		} else if(searchResults.hasOwnProperty(key) == false && siteAttributesPool[key].isSet == true) {
			siteAttributesPool[key].polygon.setMap(null);
			siteAttributesPool[key].isSet = false;
		}
	}
}

function changeCategory() {
	chartcat = $('input[name=chart]:radio:checked').val();
	if(chartcat == "survivalRate") {
		$('#heatmapbtn').css('display', 'inherit');
	} else {
		$('#heatmapbtn').css('display', 'none');
	}
	
	chartWorker.postMessage(JSON.stringify(searchResults) + "-parse-parse-" + JSON.stringify(years) + "-parse-parse-" + 
							chartcat + "-parse-parse-" + JSON.stringify(validationsPool));
}

var searchvalue1 = "";
var searchvalue2 = "";
var mergeArrayData;
var dataArray1;
var dataArray2;


function changeCompare(value) {
	chartcatcompare = $('input[name=comparecat]:radio:checked').val();
	search1();
	search2();
}

function search1(initial) {
	if(initial) {
		area1Worker.postMessage("initial" + "-parse-parse-" + JSON.stringify(years));
	} else {
		var queryString = "WHERE";
		
		searchValue1 = $("#val_area1").val().trim();
		searchCategory1 = $("#search_area").val().trim();
		
		if(searchValue1.length > 0) {
			if(searchCategory1 == "province") {//
				queryString += ' province.provinceName="' + searchValue1 + '"';
			} else if(searchCategory1 == "muni_city") {//
				queryString += ' municipality.municipalityName="' + searchValue1 + '"';
			} else if(searchCategory1 == "cenro") {//
				queryString += ' cenro.cenroName="' + searchValue1 + '"';
			} else if(searchCategory1 == "components") {//
				queryString += ' site.component="' + searchValue1 + '"';
			} else if(searchCategory1 == "zone") {
				queryString += ' site.zone="' + searchValue1 + '"';
			} else if(searchCategory1 == "species") {
				queryString += ' species.commonName="' + searchValue1 + '"';
			} else if(searchCategory1 == "commodities") {
				queryString += '  commodity.commodityName="' + searchValue1 + '"';
			} else if(searchCategory1 == "orgname") {//
				queryString += ' organization.organizationName="' + searchValue1 + '"';
			} else if(searchCategory1 == "orgtype") {//
				queryString += ' organizationType.organizationTypeName="' + searchValue1 + '"';
			}
			console.log(queryString);
			
			$.get("filter.php?q= " + queryString).done(function(data) {
				var searchResults1 = JSON.parse(data);
				area1Worker.postMessage("search" + "-parse-parse-" + JSON.stringify(years) + "-parse-parse-" + JSON.stringify(searchResults1) + "-parse-parse-" + chartcatcompare + "-parse-parse-" + JSON.stringify(validationsPool) + "-parse-parse-" + searchValue1 + "-parse-parse-" + searchCategory1);
			});
		} else {
			area1Worker.postMessage("initial" + "-parse-parse-" + JSON.stringify(years));
		}
	}
}

function search2(initial) {
	if(initial) {
		area2Worker.postMessage("initial" + "-parse-parse-" + JSON.stringify(years));
	} else {
		var queryString = "WHERE";
		
		searchValue2 = $("#val_area2").val().trim();
		searchCategory2 = $("#search_area").val().trim();
		
		if(searchValue2.length > 0) {
			if(searchCategory2 == "province") {//
				queryString += ' province.provinceName="' + searchValue2 + '"';
			} else if(searchCategory2 == "muni_city") {//
				queryString += ' municipality.municipalityName="' + searchValue2 + '"';
			} else if(searchCategory2 == "cenro") {//
				queryString += ' cenro.cenroName="' + searchValue2 + '"';
			} else if(searchCategory2 == "components") {//
				queryString += ' site.component="' + searchValue2 + '"';
			} else if(searchCategory2 == "zone") {
				queryString += ' site.zone="' + searchValue2 + '"';
			} else if(searchCategory2 == "species") {
				queryString += ' species.commonName="' + searchValue2 + '"';
			} else if(searchCategory2 == "commodities") {
				queryString += ' commodity.commodityName="' + searchValue2 + '"';
			} else if(searchCategory2 == "orgname") {//
				queryString += ' organization.organizationName="' + searchValue2 + '"';
			} else if(searchCategory2 == "orgtype") {//
				queryString += ' organizationType.organizationTypeName="' + searchValue2 + '"';
			}
			
			$.get("filter.php?q= " + queryString).done(function(data) {
				var searchResults2 = JSON.parse(data);
				area2Worker.postMessage("search" + "-parse-parse-" + JSON.stringify(years) + "-parse-parse-" + JSON.stringify(searchResults2) + "-parse-parse-" + chartcatcompare + "-parse-parse-" + JSON.stringify(validationsPool) + "-parse-parse-" + searchValue2 + "-parse-parse-" + searchCategory2);
			});
		} else {
			area2Worker.postMessage("initial" + "-parse-parse-" + JSON.stringify(years));
		}
	}
}

function drawChartArea1(data, titleCombo) {
	var options = {
		title: titleCombo,
		'width': 350,
		'height': 200,
		legend: {
			position: 'bottom'
		}
		
	};

	var chart = new google.visualization.LineChart(document.getElementById('chart1'));

	chart.draw(data, options);
}

function drawChartArea2(data, titleCombo) {
	var options = {
		title: titleCombo,
		'width': 350,
		'height': 200,
		legend: {
			position: 'bottom'
		}
	};

	var chart = new google.visualization.LineChart(document.getElementById('chart2'));

	chart.draw(data, options);
}

function merge() {
	mergeArrayData[0].push(dataArray2[0][1]);
	for(var i = 1; i < mergeArrayData.length; i++) {
		mergeArrayData[i].push(dataArray2[i][1]);
	}
	
	var data = google.visualization.arrayToDataTable(mergeArrayData);
	if(chartcatcompare == "survivalRate") {
		var titleCombo = "Survival Rate\n";
		titleCombo += "Year: "+ minYear + " - " + maxYear;
	} else if(chartcatcompare == "growthRate") {
		var titleCombo = "Growth Rate\n";
		titleCombo += "Year: "+ minYear + " - " + maxYear;
	} else if(chartcatcompare == "maturityRate") {
		var titleCombo = "Maturity Rate\n";
		titleCombo += "No data available.";
	}
	
	
	drawChartArea1(data, titleCombo);
	searchValue2 = "";
	searchCategory2 = "";
	search2("initial");
}

function getAutoComplete(category, isCompare) {
	if(isCompare) {
		search1('initial');
		search2('initial');
		if(category == "zone") {
			var dynamicsearchCompare = ['Protection', 'Production', 'Protection/Production'];
			
			$("#val_area1").autocomplete({
				source: function(request, response) {
					var results = $.ui.autocomplete.filter(dynamicsearchCompare, request.term);
					response(results.slice(0, 5));
				}
			});
			
			$("#val_area2").autocomplete({
				source: function(request, response) {
					var results = $.ui.autocomplete.filter(dynamicsearchCompare, request.term);
					response(results.slice(0, 5));
				}
			});
		} else {
			$.get("autocomplete.php?q=" + category).done(function(data) {
				dynamicsearchCompare = data.split(",");
			});
			
			$("#val_area1").autocomplete({
				source: function(request, response) {
					var results = $.ui.autocomplete.filter(dynamicsearchCompare, request.term);
					response(results.slice(0, 5));
				}
			});
			
			$("#val_area2").autocomplete({
				source: function(request, response) {
					var results = $.ui.autocomplete.filter(dynamicsearchCompare, request.term);
					response(results.slice(0, 5));
				}
			});
		}
	} else {
		if(category == "zone") {
			dynamicsearch = ['Protection', 'Production', 'Protection/Production'];
			
			$("#search_val").autocomplete({
				source: function(request, response) {
					var results = $.ui.autocomplete.filter(dynamicsearch, request.term);
					response(results.slice(0, 5));
				}
			});
		} else {
			$.get("autocomplete.php?q=" + category).done(function(data) {
				dynamicsearch = data.split(",");
			});
			
			$("#search_val").autocomplete({
				source: function(request, response) {
					var results = $.ui.autocomplete.filter(dynamicsearch, request.term);
					response(results.slice(0, 5));
				}
			});
		}
	}
}