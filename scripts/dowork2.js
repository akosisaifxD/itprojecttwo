self.addEventListener('message', function(e) {
  var data = e.data;
  self.postMessage('from worker 2: ' + data);
}, false);