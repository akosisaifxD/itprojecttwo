<script>
self.addEventListener('message', function(e) {
	alert('hi');
  self.postMessage("from worker1: " + e.data);
}, false);
</script>