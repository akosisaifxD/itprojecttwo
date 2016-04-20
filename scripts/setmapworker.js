self.addEventListener('message', function(e) {
  // Send the message back.
  self.postMessage(e.data);
}, false);