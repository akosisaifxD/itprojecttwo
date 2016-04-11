self.addEventListener('message', function(e) {
  // Send the message back.
  var x = e.data.split("-parse-parse-");
  var dataArray = [['Year', x[6] + "-" + x[5]]];
  var counter = 1;
  var years = JSON.parse(x[1]);
  
  if(x[0] == "initial") {
	  for(var key in years) {
		dataArray [counter] = [key+'', 0];
		counter++;
	  }
  } else if(x[0] == "search") {
	  console.log("searchworker");
	  var searchResults = JSON.parse(x[2]);
	  var chartcat = x[3];
	  console.log(chartcat);
	  var validationsPool = JSON.parse(x[4]);
	  
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
  }
  
  self.postMessage(JSON.stringify(dataArray));
}, false);