<script>
	function polygonArea(X, Y, numPoints) { 
		area = 0;         // Accumulates area in the loop
		j = numPoints-1;  // The last vertex is the 'previous' one to the first

		for (i=0; i<numPoints; i++){ 
			area = area +  (X[j]+X[i]) * (Y[j]-Y[i]); 
			j = i;  //j is previous vertex to i
		}
		
		return area/2;
	}
	
	var xPts = [120.845687733,  120.845430885,  120.84490427,  120.844798956, 120.845662892, 120.846052646, 120.845865357];
	var yPts = [16.5202388455, 16.5205975753, 16.5207908987, 16.5209976058, 16.5207896947, 16.5202697144, 16.520267782];
	var a = polygonArea(xPts, yPts, 7);
	alert("Area  = " + a);
</script>