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

var data1;
var titleCombo1;
var tableData1;
var dataArea1;
var titleArea1;
var dataArea2;
var titleArea2;
var previousTab = "";
var hide = true;
var landArea = 0;

var entry = {"year":[],"province":[],"cenro":[],"orgname":[],"species":[]};
var yearsSearch = [];
var provinceSearch = [];
var cenroSearch = [];
var orgNameSearch = [];
var specieSearch = [];

var chartWorker = new Worker('scripts/chartworker.js');
var tableWorker = new Worker('scripts/tableworker.js');
var setmapWorker = new Worker('scripts/setmapworker.js');
var area1Worker = new Worker('scripts/chartarea1.js');
var area2Worker = new Worker('scripts/chartarea2.js');

chartWorker.addEventListener('message', function(e) {
	var x = e.data.split("-parse-parse-");
	years = JSON.parse(x[1]);
	var dataArray = JSON.parse(x[0]);
	var category = "";
	
	data1 = google.visualization.arrayToDataTable(dataArray);

	if(chartcat == "survivalRate") {
		titleCombo1 = "Survival Rate\n";
		
	} else if(chartcat == "growthRate") {
		titleCombo1 = "Growth Rate\n";
	} else if(chartcat == "maturityRate") {
		titleCombo1 = "Maturity Rate\n";
	}
	
	titleCombo1 += "Year: "+ value0 + " - " + value1 + "\n";
	if(searchCategory != "" && searchValue != "") {
		if(searchCategory == "muni_city") {
			titleCombo1 += "Municipality: " + searchValue;
		} else if(searchCategory == "commodities") {
			titleCombo1 += "Commodity: " + searchValue;
		} else if(searchCategory == "species") {
			titleCombo1 += "Species: " + searchValue;
		} else if(searchCategory == "zone") {
			titleCombo1 += "Zone: " + searchValue;
		} else if(searchCategory == "components") {
			titleCombo1 += "Components: " + searchValue;
		} else if(searchCategory == "orgname") {
			titleCombo1 += "Organization Name: " + searchValue;
		} else if(searchCategory == "orgtyp") {
			titleCombo1 += "Organization Type: " + searchValue;
		}
		
	}
	drawChart(data1, titleCombo1);
}, false);

tableWorker.addEventListener('message', function(e) {
	var x = e.data.split("-parse-parse-");
	var dataArray = JSON.parse(x[0]);
	
	overallInventory = JSON.parse(x[1]);
	
	tableData1 = google.visualization.arrayToDataTable(dataArray);
	
	drawInventory(tableData1);
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
	
	dataArea1 = google.visualization.arrayToDataTable(dataArray1);
	
	if(chartcatcompare == "survivalRate") {
		titleArea1 = "Survival Rate\n";
		titleArea1 += "Year: "+ minYear + " - " + maxYear;
	} else if(chartcatcompare == "growthRate") {
		titleArea1 = "Growth Rate\n";
		titleArea1 += "Year: "+ minYear + " - " + maxYear;
	} else if(chartcatcompare == "maturityRate") {
		titleArea1 = "Maturity Rate\n";
		titleArea1 += "No data available.";
	}
	
	drawChartArea1(dataArea1, titleArea1);
});

area2Worker.addEventListener('message', function(e){
	dataArray2 = JSON.parse(e.data);
	
	dataArea2 = google.visualization.arrayToDataTable(dataArray2);
	
	if(chartcatcompare == "survivalRate") {
		titleArea2 = "Survival Rate\n";
		titleArea2 += "Year: "+ minYear + " - " + maxYear;
	} else if(chartcatcompare == "growthRate") {
		titleArea2 = "Growth Rate\n";
		titleArea2 += "Year: "+ minYear + " - " + maxYear;
	} else if(chartcatcompare == "maturityRate") {
		titleArea2 = "Maturity Rate\n";
		titleArea2 += "No data available.";
	}
	
	drawChartArea2(dataArea2, titleArea2);
});

function seedlingsObject() {
	this.seedlings = {"total":0};
}

function siteAttributes(id, year, color, landArea) {
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
	this.landArea = landArea;
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
		}),
		
		$.get("autocomplete.php?q=year").done(function(data) {
			yearsSearch = data.split(",");

			$("#yearInput").autocomplete({
				source: function(request, response) {
					var results = $.ui.autocomplete.filter(yearsSearch, request.term);
					response(results.slice(0, 5));
				}
			});
			
		}),

		$.get("autocomplete.php?q=province").done(function(data) {
			provinceSearch = data.split(",");
			
			$("#provinceInput").autocomplete({
				source: function(request, response) {
					var results = $.ui.autocomplete.filter(provinceSearch, request.term);
					response(results.slice(0, 5));
				}
			});
			
		}),
			
		$.get("autocomplete.php?q=cenro").done(function(data) {
			cenroSearch = data.split(",");
			
			$("#cenroInput").autocomplete({
				source: function(request, response) {
					var results = $.ui.autocomplete.filter(cenroSearch, request.term);
					response(results.slice(0, 5));
				}
			});
			
		}),
			
		$.get("autocomplete.php?q=orgname").done(function(data) {
			orgNameSearch = data.split(",");
			
			$("#orgnameInput").autocomplete({
				source: function(request, response) {
					var results = $.ui.autocomplete.filter(orgNameSearch, request.term);
					response(results.slice(0, 5));
				}
			});
			
		}),
			
		$.get("autocomplete.php?q=species").done(function(data) {
			specieSearch = data.split(",");
			
			$("#speciesInput").autocomplete({
				source: function(request, response) {
					var results = $.ui.autocomplete.filter(specieSearch, request.term);
					response(results.slice(0, 5));
				}
			});
			
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

		if(tab_id != "tab-1") {
			$('#isHeat').prop('checked', false);
			heatmapChart(false);
		}
		
		if(tab_id == previousTab) {
			if(hide) {
				hide = false;
			} else {
				$(this).addClass('current');
				$("#" + tab_id).addClass('current');
				hide = true;
			}
		} else {
			$(this).addClass('current');
			$("#" + tab_id).addClass('current');
		}
		
		previousTab = tab_id;
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
			var x = new siteAttributes(site[i].siteID, site[i].year, site[i].color, site[i].computedArea);
			
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
	
	for(var key in siteAttributesPool) {
		if(key.indexOf("ring") < 0) {
			landArea += parseFloat(siteAttributesPool[key].landArea);
		}
	}
	
	var printLandArea = landArea.toFixed(2);
	$("#pLandArea").text("Land Area: " + numberWithCommas(printLandArea) + " hectares");
	
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
		$("#legend_div").append("<p>Map Legend</p>");
		for(var key in years) {
			if(parseInt(key) > maxYear) {
				maxYear = parseInt(key);
			}
			
			if(parseInt(key) < minYear) {
				minYear = parseInt(key);
			}
			$("#legend_div").append("<div id='legendColor' style='background-color:" + years[key]["color"] + "; '></div>" +key+ "<br>");
		}
	
		value0 = minYear;
		value1 = maxYear;
	} else if(category == "survivalrate") {
		$("#legend_div").html("");
		$("#legend_div").append("<p><b>Map Legend</b></p>");
		$("#legend_div").append("<div id='legendColor' style='background-color: yellow;'></div>Above 85%\n");
		$("#legend_div").append("<hr/>");
		$("#legend_div").append("<div id='legendColor' style='background-color: red;'></div>Below 85%\n");
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
			var result = JSON.parse(data);
			if(result == "[]") {
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
					treeStats += "<div id='TreeInformationDiv'>" + key + ":</div> <div display = 'inline' id='divTreeInformation'>" + inventoryPool[id][key] + "</div><br/>";			
				}
				
				if(treeStats == "") {
					treeStats = "No data available";
				}
				
				var location = e.latLng;
				//area info for css
				if(siteAttributesPool[id + ""].iWindow == 0) {
					var iWindow = new google.maps.InfoWindow;
					iWindow.setContent('<center><b><p id="areaInformation">Area Informaton</p></b></center> <br/> <div id="divAreaInformation">Province:</div> <div id="areaInformationDiv">' + result[0].provincename + 
					'</div><br/> <div id="divAreaInformation">Municipality:</div> <div id="areaInformationDiv">' + result[0].municipalityname + 
					'</div><br/> <div id="divAreaInformation">Barangay: </div> <div id="areaInformationDiv">' + barangays + 
					'</div><br/> <div id="divAreaInformation">Declared Area:</div> <div id="areaInformationDiv">' + result[0].declaredarea + ' ha' +
					'</div><br/> <div id="divAreaInformation">Computed Area: </div> <div id="areaInformationDiv">' + result[0].computedarea + ' ha' +
					'</div><br/> <div id="divAreaInformation">Component: </div> <div id="areaInformationDiv">' + result[0].component + 
					'</div><br/> <div id="divAreaInformation">Zone: </div> <div id="areaInformationDiv">' + result[0].zone + 
					'</div><br/> <div id="divAreaInformation">Organization: </div> <div id="areaInformationDiv">' + orgs + 
					'</div><br/> <center><b id="treeStatistics">Tree Statistics</b></center>' + 
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
			'filterColumnLabel': 'Tree Specie',
			'height': 300,
			'width': 500
		}
	});

	var table = new google.visualization.ChartWrapper({
		'chartType': 'Table',
		'containerId': 'table_div',
		'options': {
			height: 600,
			width: 1500,
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
	
	console.log(queryString);
	$.get("filter.php?q= " + queryString).done(function(data) {
		searchResults = JSON.parse(data);
		setmapWorker.postMessage(JSON.stringify(searchResults));
		chartWorker.postMessage(JSON.stringify(searchResults) + "-parse-parse-" + JSON.stringify(years) + "-parse-parse-" + chartcat + "-parse-parse-" + JSON.stringify(validationsPool) + "-parse-parse-" + searchCategory + "-parse-parse-" + searchValue);
		tableWorker.postMessage(JSON.stringify(searchResults) + "-parse-parse-" + JSON.stringify(inventoryPool) + "-parse-parse-" + searchCategory + "-parse-parse-" + searchValue);
		
		landArea = 0;
		for(var key in searchResults) {
			if(key.indexOf("ring") < 0) {
				landArea += parseFloat(siteAttributesPool[key].landArea);
			}
		}
		
		var printLandArea = landArea.toFixed(2);
		$("#pLandArea").text("Land Area: " + numberWithCommas(printLandArea) + " hectares");
	});
}

function applyFilter() {	
	for(var k33ey in siteAttributesPool) {
		if(searchResults.hasOwnProperty(key) == true && siteAttributesPool[key].isSet == false) {
			siteAttributesPool[key].polygon.setMap(map);
			siteAttributesPool[key].isSet = true;
		} else if(searchResults.hasOwnProperty(key) == false && siteAttributesPool[key].isSet == true) {
			si333teAttributesPool[key].polygon.setMap(null);
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
		$('#isHeat').prop('checked', false);
		heatmapChart(false);
	}
	
	chartWorker.postMessage(JSON.stringify(searchResults) + "-parse-parse-" + JSON.stringify(years) + "-parse-parse-" + 
							chartcat + "-parse-parse-" + JSON.stringify(validationsPool) + "-parse-parse-" + searchCategory + "-parse-parse-" + searchValue);
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

function enter(category) {
	var inputboxID = "#" + category + "Input";
	var labelID = "#" + category + "Selected";
	var value = $(inputboxID).val().trim();
	
	if(value.length == 0) {
		
	} else {
		var pID = category + "-" + value.replace(/\s/g, '');
		var pID2 = category + "-" + value;
		
		if(entry[category].indexOf(value) < 0) {
			entry[category].push(value);
			
			$(labelID).append('<p id=' + pID + '>' + value + '<button onclick="removeEntry(\'' + pID2 + '\');">X</button></p>');
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

function advancedSearch() {
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
	
	if(queryString != "WHERE") {
		$.get("filter.php?q= " + queryString).done(function(data) {
			searchCategory = "";
			searchValue = "";
			searchResults = JSON.parse(data);
			setmapWorker.postMessage(JSON.stringify(searchResults));
			chartWorker.postMessage(JSON.stringify(searchResults) + "-parse-parse-" + JSON.stringify(years) + "-parse-parse-" + chartcat + "-parse-parse-" + JSON.stringify(validationsPool));
			tableWorker.postMessage(JSON.stringify(searchResults) + "-parse-parse-" + JSON.stringify(inventoryPool));
			document.getElementById('myModal').style.display = "none";
		});
		
		landArea = 0;
		for(var key in searchResults) {
			if(key.indexOf("ring") < 0) {
				landArea += parseFloat(siteAttributesPool[key].landArea);
			}
		}
		
		var printLandArea = landArea.toFixed(2);
	$("#pLandArea").text("Land Area: " + numberWithCommas(printLandArea) + " hectares");
		
	} else {
		searchCategory = "";
		searchValue = "";
		filter();
		document.getElementById('myModal').style.display = "none";
	}
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

function clearText(id) {
	$("#" + id).val("");
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$("#search_val").keyup(function(event){
    if(event.keyCode == 13){
        search();
		clearText("search_val");
    }
});

$("#speciesInput").keyup(function(event){
    if(event.keyCode == 13){
        enter("species");
		clearText("speciesInput");
    }
});

$("#yearInput").keyup(function(event){
    if(event.keyCode == 13){
        enter("year");
		clearText("yearInput");
    }
});

$("#provinceInput").keyup(function(event){
    if(event.keyCode == 13){
        enter("province");
		clearText("provinceInput");
    }
});

$("#cenroInput").keyup(function(event){
    if(event.keyCode == 13){
        enter("cenro");
		clearText("cenroInput");
    }
});

$("#orgnameInput").keyup(function(event){
    if(event.keyCode == 13){
        enter("orgname");
		clearText("orgnameInput");
    }
});


$(document).ready(function() {
  $("#SearchDivButton").click(function(){
        $("#hide3").toggle();
	});
});
$(document).ready(function() {
  $("#tabButton").click(function(){
        $("#hide4").toggle();
    });
});
$(document).ready(function() {
  $("#legendButton").click(function(){
        $("#hide1").toggle();
    });
});
$(document).ready(function() {
  $("#sliderDivButton").click(function(){
        $("#hide2").toggle();
    });
});




$('.searchFilter').draggable({
  containment: "parent",
  zIndex: 103
});

var posStack = [];
var coordinates = function(element) {
    element = $(element);
    var top = element.position().top;
    var left = element.position().left;
    posStack.push({x:left,y:top});
}


$('.searchFilter').draggable({ containment: "parent", scroll: false,
    		start: function() { 
        		coordinates('.searchFilter');
    					},
   		 stop: function() {
        		//coordinates('#logo');
    				}
		});
$("#resetButton").on('click', function(){
    var pos = posStack.pop();
   // alert(pos.x);
 $('.searchFilter').css("left", pos.x);
     $('.searchFilter').css("top", pos.y);
});
$('#legend_div').draggable();
$('#slider_div').draggable();
    $( "#tab-1" ).resizable({
      minHeight: 333,
      minWidth: 475
    });
	
	$("#tab-1").resize(function(){
		if(this.resizeTO) clearTimeout(this.resizeTO);
		this.resizeTO = setTimeout(function(){
			drawChart(data1, titleCombo1);
		}, 500);
				
	});
	
	
	$( "#tab-2" ).resizable({
      minHeight: 358,
      minWidth: 475
    });
	
	$("#tab-2").resize(function(){
		if(this.resizeTO) clearTimeout(this.resizeTO);
		this.resizeTO = setTimeout(function(){
			drawInventory(tableData1);
		}, 500);
				
	});
	
	
	$( "#tab-3" ).resizable({
      minHeight: 658,
      minWidth: 475
    });
	
	$("#tab-3").resize(function(){
		if(this.resizeTO) clearTimeout(this.resizeTO);
		this.resizeTO = setTimeout(function(){
			drawChartArea1(dataArea1, titleArea1);
			drawChartArea2(dataArea2, titleArea2);
		}, 500);
				
	});