var site;
var trees;
var seedlings;
var siteAttributesPool = {};
var searchResults = {};

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

var result;
var dynamicsearch = [];


function siteAttributes(id, year, color) {
	this.id = id;
	this.year = year;
	this.color = color;
	this.polygon = {};
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
	setAutoComplete();
	setStats();
	setAreaInfo();
}

function setAreaInfo() {
	for(var key in siteAttributesPool) {
		addInfoWindow(siteAttributesPool[key].polygon, siteAttributesPool[key].id);
	}
}

var lastOpenedId = -1;


function addInfoWindow(polygon, id) {
	polygon.addListener('click', function(e) {
		$.get("areainfo.php?q='" + id + "'").done(function(data) {
			result = JSON.parse(data);
		
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
			
			for(var key in siteAttributesPool[id + ""].inventory) {
				//console.log(key);
				treeStats += key + ": " + siteAttributesPool[id].inventory[key] + "<br/>";
			}
			
			//console.log(treeStats);
			
			var location = e.latLng;
			var iWindow = new google.maps.InfoWindow();
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
		});
	});
}

function setStats() {
	for(var i = 0; i < seedlings.length; i++) {
		if(siteAttributesPool[seedlings[i].siteID].seedlings.hasOwnProperty(seedlings[i].commonname)) {
			siteAttributesPool[seedlings[i].siteID].seedlings[seedlings[i].commonname] += parseInt(seedlings[i].quantity);
			siteAttributesPool[seedlings[i].siteID].seedlings["total"] += parseInt(seedlings[i].quantity);
		} else {
			siteAttributesPool[seedlings[i].siteID].seedlings[seedlings[i].commonname] = parseInt(seedlings[i].quantity);
			siteAttributesPool[seedlings[i].siteID].seedlings["total"] += parseInt(seedlings[i].quantity);

		}
	}
	
	var lastDate = "";
	var lastSite = "";
	
	for(var i = 0; i < trees.length; i++) {
		if(siteAttributesPool[trees[i].siteID].validation.hasOwnProperty(trees[i].startDate)) {
			if(siteAttributesPool[trees[i].siteID].validation[trees[i].startDate].hasOwnProperty(trees[i].commonname)) {
				//console.log("rare: " + i);
				siteAttributesPool[trees[i].siteID].validation[trees[i].startDate][trees[i].commonname]["quantity"] += parseInt(trees[i].quantity);
				siteAttributesPool[trees[i].siteID].validation[trees[i].startDate]["total"] += parseInt(trees[i].quantity);
				siteAttributesPool[trees[i].siteID].inventory[trees[i].commonname] = parseInt(siteAttributesPool[trees[i].siteID].validation[trees[i].startDate][trees[i].commonname]);
				if(siteAttributesPool[trees[i].siteID].seedlings.hasOwnProperty(trees[i].commonname)) {
					siteAttributesPool[trees[i].siteID].validation[trees[i].startDate][trees[i].commonname]["survivalRate"] = 
					(siteAttributesPool[trees[i].siteID].validation[trees[i].startDate][trees[i].commonname]["quantity"]/
					siteAttributesPool[trees[i].siteID].seedlings[trees[i].commonname]) * 100;
				}
			} else {
				siteAttributesPool[trees[i].siteID].validation[trees[i].startDate][trees[i].commonname] = {};
				siteAttributesPool[trees[i].siteID].validation[trees[i].startDate][trees[i].commonname]["quantity"] = parseInt(trees[i].quantity); 
				siteAttributesPool[trees[i].siteID].validation[trees[i].startDate]["total"] += parseInt(trees[i].quantity);
				siteAttributesPool[trees[i].siteID].inventory[trees[i].commonname] = parseInt(trees[i].quantity);
				if(siteAttributesPool[trees[i].siteID].seedlings.hasOwnProperty(trees[i].commonname)) {
					siteAttributesPool[trees[i].siteID].validation[trees[i].startDate][trees[i].commonname]["survivalRate"] = 
					(siteAttributesPool[trees[i].siteID].validation[trees[i].startDate][trees[i].commonname]["quantity"]/
					siteAttributesPool[trees[i].siteID].seedlings[trees[i].commonname]) * 100;
				}
			}
			
			lastSite = trees[i].siteID;
			lastDate = trees[i].startDate;
			
			if(i == trees.length - 1) {
				var lastYear = (lastDate.split(" ")[0].split("-")[0]);
				var survivalRate = (siteAttributesPool[trees[i].siteID].validation[trees[i].startDate]["total"]/siteAttributesPool[trees[i].siteID].seedlings["total"]) * 100;
				if(isFinite(survivalRate)) {
					siteAttributesPool[lastSite].stats["survivalRate"] = survivalRate;
					siteAttributesPool[lastSite].validation[lastDate]["survivalRate"] = survivalRate;
					if(years.hasOwnProperty(lastYear)) {
						years[lastYear]["survivalRateSum"] += survivalRate;
						years[lastYear]["survivalRateCount"] += 1;
					}
				}
			}
		} else {
			siteAttributesPool[trees[i].siteID].validation[trees[i].startDate] = {};
			siteAttributesPool[trees[i].siteID].validation[trees[i].startDate][trees[i].commonname] = {};
			siteAttributesPool[trees[i].siteID].validation[trees[i].startDate][trees[i].commonname]["quantity"] = parseInt(trees[i].quantity); 
			siteAttributesPool[trees[i].siteID].validation[trees[i].startDate][trees[i].commonname]["survivalRate"] = 0;
			siteAttributesPool[trees[i].siteID].validation[trees[i].startDate]["total"] = parseInt(trees[i].quantity);
			siteAttributesPool[trees[i].siteID].inventory[trees[i].commonname] = parseInt(trees[i].quantity);
			
			
			if(lastDate != trees[i].startDate && i != 0) {
				var lastYear = (lastDate.split(" ")[0].split("-")[0]);
				var survivalRate = (siteAttributesPool[lastSite].validation[lastDate]["total"]/siteAttributesPool[lastSite].seedlings["total"]) * 100;
				if(isFinite(survivalRate)) {
					siteAttributesPool[lastSite].stats["survivalRate"] = survivalRate;
					siteAttributesPool[lastSite].validation[lastDate]["survivalRate"] = survivalRate;
					if(years.hasOwnProperty(lastYear)) {
						years[lastYear]["survivalRateSum"] += survivalRate;
						years[lastYear]["survivalRateCount"] += 1;
					}
				}
				
			}
			
			
			lastSite = trees[i].siteID;
			lastDate = trees[i].startDate;
		}
	}
	
	setTrends();
}

function setTrends() {
	$('ul.tabs li').click(function() {
		var tab_id = $(this).attr('data-tab');

		$('ul.tabs li').removeClass('current');
		$('.tab-content').removeClass('current');

		$(this).addClass('current');
		$("#" + tab_id).addClass('current');
	});
	
	var counter = 1;
	var dataArray = [['Year', 'Rate']];
	
	for(var key in years) {
		years[key]["survivalRate"] = years[key]["survivalRateSum"] / years[key]["survivalRateCount"];
		
		if(isFinite(years[key]["survivalRate"])) {
			dataArray[counter] = [key+'', years[key]["survivalRate"]];
			counter++;
		}
	}
	
	for(var key in siteAttributesPool) {
		for(var key2 in siteAttributesPool[key].inventory) {
			if(overallInventory.hasOwnProperty(key2)) {
				overallInventory[key2] += siteAttributesPool[key].inventory[key2];
			} else {
				overallInventory[key2] = siteAttributesPool[key].inventory[key2];
			}
			
		}
	}
		
	var data = google.visualization.arrayToDataTable(dataArray);
	var titleCombo = "Survival Rate\n Year: 2011 - 2015";
	
	drawChart(data, titleCombo);
	
	var dataArray = [];
	dataArray[0] = ['Tree Specie', 'Quantity'];
	
	counter = 1;
	for(var key in overallInventory) {
		dataArray[counter] = [key+"", overallInventory[key]];
		counter++;
	}
	
	//console.log(dataArray);
	
	var data2 = google.visualization.arrayToDataTable(dataArray);
	//console.log(data2);
	
	titleString = "Tree Inventory for trees planted in 2011 - 2015";
	drawInventory(data2, titleString);
}

function drawInventory(data, titleCombo) {
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
			if(siteAttributesPool[key].stats["survivalRate"] >= 85) {
				siteAttributesPool[key].polygon.setOptions({
					strokeWeight: 1,
					fillColor: 'blue',
					strokeColor: 'blue'
				});
			} else {
				siteAttributesPool[key].polygon.setOptions({
					strokeWeight: 1,
					fillColor: 'yellow',
					strokeColor: 'yellow'
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

function searchAreaInfo(id) {
	
}

function setLegend(category, combinatons) {
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
		$("#legend_div").append("Above 85%<div id='legendColor' style='background-color: blue;'></div>\n");
		$("#legend_div").append("<hr/>");
		$("#legend_div").append("Below 85%<div id='legendColor' style='background-color: yellow;'></div>\n");
	}
	
}

function setSlider() {
	$("#slider-range").slider({
		range: true,
		min: minYear,
		max: maxYear,
		values: [minYear, maxYear],
		animate: "medium",
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
		
		function animate(diff, v0, counter) {
			var interval = 1500;
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
	})
}

function setAutoComplete() {
	getAutoComplete("province");
	
	$("#search_val").autocomplete({
		source: function(request, response) {
			var results = $.ui.autocomplete.filter(dynamicsearch, request.term);
			response(results.slice(0, 5));
		}
	});
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
		applyFilter();
	});
}

function applyFilter() {
	for(var key in siteAttributesPool) {
		if(searchResults.hasOwnProperty(key) == true && siteAttributesPool[key].isSet == true) {
			
		} else if(searchResults.hasOwnProperty(key) == true && siteAttributesPool[key].isSet == false) {
			siteAttributesPool[key].polygon.setMap(map);
			siteAttributesPool[key].isSet = true;
		} else if(searchResults.hasOwnProperty(key) == false && siteAttributesPool[key].isSet == true) {
			siteAttributesPool[key].polygon.setMap(null);
			siteAttributesPool[key].isSet = false;
		}
	}
	
	//to be implemented parallel
	applyChart();
}

function applyChart() {
	/*
	for(var key in siteAttributesPool) {
		if(searchResults.hasOwnProperty(key) == true) {
			
		}
	}
	*/
}

function updateSearch(category) {
	if(category == "zone") {
		dynamicsearch = ['Protection', 'Production', 'Protection/Production'];
	} else {
		getAutoComplete(category);
	}
	
	$("#search_val").autocomplete({
		source: function(request, response) {
			var results = $.ui.autocomplete.filter(dynamicsearch, request.term);
			response(results.slice(0, 5));
		}
	});
}

function getAutoComplete(category) {
	$.get("autocomplete.php?q=" + category).done(function(data) {
		dynamicsearch = data.split(",");
	});
}