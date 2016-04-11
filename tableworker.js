self.addEventListener('message', function(e) {
	var x = e.data.split("-parse-parse-");
	var inventoryPool = JSON.parse(x[1]);
	var overallInventory = {};
	var searchResults = "empty";
	
	if(x[0] == '"initial"') {
		for(var key in inventoryPool) {
			for(var key2 in inventoryPool[key]) {
				if(overallInventory.hasOwnProperty(key2)) {
					overallInventory[key2] += inventoryPool[key][key2];
				} else {
					overallInventory[key2] = inventoryPool[key][key2];
				}
			}
		}
		
	} else {
		searchResults = JSON.parse(x[0]);
		
		for(var key in inventoryPool) {
			if(searchResults.hasOwnProperty(key)) {
				for(var key2 in inventoryPool[key]) {
					if(overallInventory.hasOwnProperty(key2)) {
						overallInventory[key2] += inventoryPool[key][key2];
					} else {
						overallInventory[key2] = inventoryPool[key][key2];
					}
				}
			}
		}
	}

	var dataArray = [];
	dataArray[0] = ['Tree Specie', 'Quantity'];

	var counter = 1;
  
	for(var key in overallInventory) {
		dataArray[counter] = [key+"", overallInventory[key]];
		counter++;
	}
	
	self.postMessage(JSON.stringify(dataArray) + "-parse-parse-" + JSON.stringify(overallInventory));
}, false);