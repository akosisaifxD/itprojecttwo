self.addEventListener('message', function(e) {
	var x = e.data.split("-parse-parse-");
	var inventoryPool = JSON.parse(x[1]);
	var overallInventory = {};
	var searchResults = "empty";
	var total = 0;
	
	if(x[0] == '"initial"') {
		for(var key in inventoryPool) {
			for(var key2 in inventoryPool[key]) {
				if(overallInventory.hasOwnProperty(key2)) {
					overallInventory[key2] += inventoryPool[key][key2];
					total += inventoryPool[key][key2];
				} else {
					overallInventory[key2] = inventoryPool[key][key2];
					total += inventoryPool[key][key2];
				}
			}
		}
		
	} else {
		searchResults = JSON.parse(x[0]);
		
		if(x[2] != "species") {
			for(var key in searchResults) {
				if(inventoryPool.hasOwnProperty(key) == true) {
					for(var key2 in inventoryPool[key]) {
						if(overallInventory.hasOwnProperty(key2)) {
							overallInventory[key2] += inventoryPool[key][key2];
						} else {
							overallInventory[key2] = inventoryPool[key][key2];
						}
					}
				}
			}		
		} else if(x[2] == "species" && x[3].trim().length == 0) {
			for(var key in searchResults) {
				if(inventoryPool.hasOwnProperty(key) == true) {
					for(var key2 in inventoryPool[key]) {
						if(overallInventory.hasOwnProperty(key2)) {
							overallInventory[key2] += inventoryPool[key][key2];
						} else {
							overallInventory[key2] = inventoryPool[key][key2];
						}
					}
				}
			}		
		} else {
			
			for(var key in searchResults) {
				if(inventoryPool.hasOwnProperty(key) == true) {
					for(var key2 in inventoryPool[key]) {
						console.log(x[3].charAt(0).toUpperCase() + x[3].slice(1));
						if(key2 == x[3].charAt(0).toUpperCase() + x[3].slice(1)) {
							if(overallInventory.hasOwnProperty(key2)) {
								overallInventory[key2] += inventoryPool[key][key2];
							} else {
								overallInventory[key2] = inventoryPool[key][key2];
							}
						}
					}
				}
			}
			
		}
		
	}

	var dataArray = [];
	dataArray[0] = ['Tree Specie', 'Quantity'];

	var counter = 1;
  
	for(var key in overallInventory) {
		dataArray[counter] = [key+"", {v: overallInventory[key], f: numberWithCommas(overallInventory[key])}];
		counter++;
	}
	
	console.log(total);
	
	self.postMessage(JSON.stringify(dataArray) + "-parse-parse-" + JSON.stringify(overallInventory));
}, false);

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}