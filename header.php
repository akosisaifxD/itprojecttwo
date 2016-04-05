<style>
	@font-face {
		font-family: raleway;
		src: url(fonts/raleway/Raleway-SemiBold.ttf);
	}

	body #header{
		background-color: #156234;
		height: 100%;
		width: 100%;
	}
	
	#headerlogo{
		position: absolute;
		left: 5%;
		height: 95%;
	}
	
	#headertitle-part-1{
		font-family: raleway;
		position: absolute;
		top: 18%;
		left: 15%;
		font-size: 500%;
		color: white;
	}
	
	#headertitle-part-2{
		font-family: raleway;
		position: absolute;
		top: 31%;
		left: 16.5%;
		font-size: 380%;
		color: white;
	}
	
	#headersettings{
		position: absolute;
		cursor: pointer;
		top: 51%;
		left: 95%;
		color: white;
		display: inline-block;
	}
	
	#headersettings:hover, #headersettings:focus {
		color: #25b15e!important;
	}
	
	#settingscontent {
		font-family: raleway;
		font-size: 120%;
		display: none;
		position: absolute;
		top: 78%;
		left: 85%;
		z-index: 3;
		background-color: #f9f9f9;
		text-align: center;
		box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
		width: 15%;
		height: 50%;
	}
	
	.accoption{
		cursor: pointer;
	}
	
	.show {display:block!important;}
	
	.accoption{
		padding: 2.5%;
	}
	
	.accoption:hover, .accoption:focus{
		background-color: #25b15e!important;
	}
</style>

<div id = "header">
	<img src = "img/logo.png" id = "headerlogo" />
	<div id = "headertitle-part-1"> i </div> <div id = "headertitle-part-2"> PUNO </div>
	<div id = "headersettings" class = "headersettings" onclick = "accoptions()"> <i class="fa fa-cog fa-2x"></i> </div>
	<div id="settingscontent" class="settingscontent">
		<div id = "accsettings" class = "accoption"> Account Settings </div>
		<div id = "signout" class = "accoption"> Sign out </div>
	</div>
</div>

<script>
	function accoptions() {
		document.getElementById("settingscontent").classList.toggle("show");
	}

	// Close the dropdown menu if the user clicks outside of it
	window.onclick = function(event) {
	  if (!event.target.matches('.headersettings')) {

		var dropdowns = document.getElementsByClassName("settingscontent");
		var i;
		for (i = 0; i < dropdowns.length; i++) {
		  var openDropdown = dropdowns[i];
		  if (openDropdown.classList.contains('show')) {
			
		  }
		}
	  }
	}
</script>
