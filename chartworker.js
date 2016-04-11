self.addEventListener('message', function(e) {
  var x = e.data.split("-parse-parse-");
  var searchResults = "empty";
  var years = JSON.parse(x[1]);
  var dataArray = [['Year', 'Rate']];
  var counter = 1;
  var chartcat = x[2];
  var validationsPool = JSON.parse(x[3]);
  
  if(x[0] == '"initial"') {
	for(var key in years) {
		years[key]["survivalRate"] = years[key]["survivalRateSum"] / years[key]["survivalRateCount"];
		
		if(isFinite(years[key]["survivalRate"])) {
			dataArray[counter] = [key+'', years[key]["survivalRate"]];
		} else {
			dataArray[counter] = [key+'', 0];
		}
		
		counter++;
	}
	
  } else {
	searchResults = JSON.parse(x[0]);
	
	if(chartcat == "survivalRate") {
		for(var key in years) {			
			years[key]["survivalRateCount"] = 0;
			years[key]["survivalRateSum"] = 0;
			years[key]["survivalRate"] = 0;
		}
		
		for(var key in searchResults) {
			if(validationsPool.hasOwnProperty(key) == true) {
				for(var key2 in validationsPool[key]) {
					var date = key2.split(" ")[0].split("-")[0];
					if(years.hasOwnProperty(date) && isFinite(validationsPool[key][key2]["survivalRate"])) {
						years[date]["survivalRateCount"] += 1;
						years[date]["survivalRateSum"] += validationsPool[key][key2]["survivalRate"];
					}
				}
			}
		}
		
		for(var key in years) {
			years[key]["survivalRate"] = (years[key]["survivalRateSum"]/years[key]["survivalRateCount"]);
		}
	} else if(chartcat == "growthRate") {
		for(var key in years) {
			years[key]["growthRate"] = 0;
		}
		
		for(var key in searchResults) {
			if(validationsPool.hasOwnProperty(key) == true) {
				for(var key2 in validationsPool[key]) {
					var date = key2.split(" ")[0].split("-")[0];
					if(years.hasOwnProperty(date)) {
						years[date]["growthRate"] += validationsPool[key][key2]["total"];
					}
				}
			}
		}
	}
		
	for(var key in years) {
		if(isFinite(years[key][chartcat])) {
			dataArray[counter] = [key+'', years[key][chartcat]];
		} else {
			dataArray[counter] = [key+'', 0];
		}
		
		counter++;
	}
	
  }//end of else  
	  
  self.postMessage(JSON.stringify(dataArray) + "-parse-parse-" + JSON.stringify(years));
}, false);