self.addEventListener('message', function(e) {
  var x = e.data.split("-parse-parse-");
  var searchResults = "empty";
  var years = JSON.parse(x[1]);
  var dataArray = [['Year', 'Rate']];
  var counter = 1;
  var chartcat = x[2];
  var validationsPool = JSON.parse(x[3]);
  var total = 0;
  
  if(x[0] == '"initial"') {
	  if(x[2] == "survivalRate") {
		for(var key in years) {
			years[key]["survivalRate"] = years[key]["survivalRateSum"] / years[key]["survivalRateCount"];
			
			if(isFinite(years[key]["survivalRate"])) {
				dataArray[counter] = [key+'', years[key]["survivalRate"].toFixed(2)];
			} else {
				dataArray[counter] = [key+'', 0];
			}
			
			counter++;
		}
	  } else if(x[2] == "growthRate") {
		for(var key in years) {		
			if(isFinite(years[key]["growthRate"])) {
				dataArray[counter] = [key+'', years[key]["growthRate"]];
			} else {
				dataArray[counter] = [key+'', 0];
			}
			
			counter++;
		}
	  } else if(x[2] == "maturityRate") {
		 for(var key in years) {		
			dataArray[counter] = [key+'', 0];
			counter++;
		} 
	  }
		
  } else {
	searchResults = JSON.parse(x[0]);
	
	if(chartcat == "survivalRate") {
		for(var key in years) {			
			years[key]["survivalRateCount"] = 0;
			years[key]["survivalRateSum"] = 0;
			years[key]["survivalRate"] = 0;
		}
		
		if(x[4] != "species") {
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
		} else if(x[4] == "species" && x[5].trim().length == 0) {
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
		} else {
			for(var key in searchResults) {
				if(validationsPool.hasOwnProperty(key) == true) {
					for(var key2 in validationsPool[key]) {
						var date = key2.split(" ")[0].split("-")[0];
						if(years.hasOwnProperty(date) && validationsPool[key][key2].hasOwnProperty(x[5].charAt(0).toUpperCase() + x[5].slice(1))) {
							var specie = x[5].charAt(0).toUpperCase() + x[5].slice(1);
							if(isFinite(validationsPool[key][key2][specie]["survivalRate"]) && validationsPool[key][key2][specie]["survivalRate"] > 0) {
								years[date]["survivalRateCount"] += 1;
								years[date]["survivalRateSum"] += validationsPool[key][key2][specie]["survivalRate"];
							}
						}
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
		
		if(x[4] != "species") {
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
		} else if(x[4] == "species" && x[5].trim().length == 0) {
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
		} else {
			for(var key in searchResults) {
				if(validationsPool.hasOwnProperty(key) == true) {
					for(var key2 in validationsPool[key]) {
						var date = key2.split(" ")[0].split("-")[0];
						if(years.hasOwnProperty(date) && validationsPool[key][key2].hasOwnProperty(x[5].charAt(0).toUpperCase() + x[5].slice(1))) {
							var specie = x[5].charAt(0).toUpperCase() + x[5].slice(1);
							years[date]["growthRate"] += validationsPool[key][key2][specie]["quantity"];
						} else {
							console.log(date);
						}
					}
				}
			}
		}
	}
		
	for(var key in years) {
		if(isFinite(years[key][chartcat])) {
			if(chartcat == "survivalRate") {
				dataArray[counter] = [key+'', years[key][chartcat].toFixed(2)];
			} else {
				dataArray[counter] = [key+'', years[key][chartcat]];
			}
			
		} else {
			dataArray[counter] = [key+'', 0];
		}
		
		counter++;
	}
	
  }//end of else  
	  
  self.postMessage(JSON.stringify(dataArray) + "-parse-parse-" + JSON.stringify(years));
}, false);