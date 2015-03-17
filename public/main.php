<?php
	/**********************************************
		Once the user is logged in, this will be the main page 
		for them, contains the views, navigations and other items
		
		@autor: Olanre Okunlola
		@date: July 12 2014
	*/	
	
?>
			<?php
			#this section was retrieved from Open Maps API using Google Maps
			# our map will use the google maps API to interact with the OpenStreetMap
			# object. See page: http://harrywood.co.uk/maps/examples/google-maps/apiv3.view.html
			?>
			<style>
			  html, body { height:100%; }
		  </style>
			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB61jDvlikK0_BX-k6-SASjVoFrVuYUL2w">
			
			</script>
			<div id = "intro">
				<!-- Header -->
				<header id="header">

					<!-- Logo -->
				
					
					<!-- Nav
						<!-- From Twitter Bootstrap: http://getbootstrap.com/components/#nav -->
						<nav class="navbar navbar-default" role="navigation">
						  <div class="container-fluid">
							<!-- Brand and toggle get grouped for better mobile display -->
							<div class="navbar-header">
							  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							  </button>
							  <a class="navbar-brand" href="#">Piqued</a>
							  
							</div>
							
							<!-- Collect the nav links, forms, and other content for toggling -->
							<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							   <form class="navbar-form navbar-left" role="search">
								<div class="form-group">
								  <input type="text" class="form-control" placeholder="Search">
								</div>
								<button type="submit" class="btn btn-default">Submit</button>
							  </form>
							  <ul class="nav navbar-nav navbar-right">
							  <li class="dropdown">
								  <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Topics <span class="caret"></span></a>
								  <ul class="dropdown-menu" role="menu">
									<li><a href="#">Places</a></li>
									<li><a href="#">People</a></li>
									<li><a href="#">Groups</a></li>
									<li><a href="#">Events</a></li>
								  </ul>
								</li>
								<li><a href="#"> Explore </a></li>
								<li><a href="#"> Notifications </a></li>
								<li class="dropdown">
								  <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <?php echo ($_SESSION['user']); ?> <span class="caret"></span></a>
								  <ul class="dropdown-menu" role="menu">
									<li><a href="#">Privacy</a></li>
									<li><a href="#">Settings</a></li>
									<li><a href="#">Help</a></li>
									<li class="divider"></li>
									<li><a onclick="logout()">Logout</a></li>
								  </ul>
								</li>
							  </ul>
							</div><!-- /.navbar-collapse -->
						  </div><!-- /.container-fluid -->
						</nav>
					

				</header>
			</div>
		
			<div id = "content" class="page-content-wrapper" >
			
				<!-- Intro -->
				
				<section id="banner" class="main style1 primary" style="color:black; width:100%">
					<?php 
						
						$place = $cords = $ServLocation = "";
						$funcloco = getReverseCoord( $cip);
						echo $funcloco;
						//$arr = getPlaces("47.5745190,-52.7273560");
										
						?>
					<div class="jumbotron" style="width=60vh; width: 60%; margin:0 auto;text-align: center; border-radius: 25px;" >
					  <form method="post" >
						<h3> What's going on? </h3> 
						<h4>
							<textarea id="newTag" style="margin-left: auto; margin-right: auto;"placeholder="@Tagmark" /></textarea>  
							<a href="#" id="vid1"> @videos </a> &nbsp;&nbsp; <a href="#" id="pic1"> @pics </a> &nbsp;&nbsp; <a href="#" id="place1"> @places </a> &nbsp;&nbsp; <a href="#" id="place1"> @people </a>
						</h4>	
						<div style="display:none" id="dropdownpos" > </div>
						<h3> <input type="button" id="SubmitNewTag" onclick="newTag()" value="Post"/> </h3>
						</form>

					</div>
					<br>
					<br>
					<div class = "jumbotron" style="width=60vh; width: 60%; margin:0 auto;text-align: center; border-radius: 25px; background-color: #eee;" >
					<?php
						getTags();
					?>
					  
					</div>
					
					
					
				</section>
			</div>	
			<!-- Footer -->
			<footer id="footer">
			
				<!--
				     Social Icons
				     
				     Use anything from here: http://fortawesome.github.io/Font-Awesome/cheatsheet/)
				-->
					<ul class="actions">
						<li><a href="#" class="fa solo fa-twitter"><span>Twitter</span></a></li>
						<li><a href="#" class="fa solo fa-facebook"><span>Facebook</span></a></li>
						<li><a href="#" class="fa solo fa-google-plus"><span>Google+</span></a></li>
						<li><a href="#" class="fa solo fa-dribbble"><span>Dribbble</span></a></li>
						<li><a href="#" class="fa solo fa-pinterest"><span>Pinterest</span></a></li>
						<li><a href="#" class="fa solo fa-instagram"><span>Instagram</span></a></li>
					</ul>

				<!-- Menu -->
					<ul class="menu">
						<li>&copy; ProjectNode. All rights reserved.</li>
						<li>Design: <a href="http://html5up.net/">HTML5 UP</a></li>
					</ul>
			
			</footer>

<?php
/********************************* 
* Main page functions
******************************/
function getReverseCoord($ip){
	
	
	$place = isset($_SESSION['location']) ? $_SESSION['location'] : "St. John's NL" ;
	$place = urlencode($place);
	$result =  file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=".$place."&key=AIzaSyB61jDvlikK0_BX-k6-SASjVoFrVuYUL2w");
	$result = json_decode($result, TRUE);
	$alternate =  file_get_contents("http://www.geoplugin.net/json.gp?ip=$ip");
	$alternate = json_decode($alternate, TRUE);
	
	//use either the google provided coordinates or the geoplugin provided, which ever works best. 
	if( ( isset($alternate["geoplugin_status"]) && ($alternate["geoplugin_status"]  == 206)) || (isset($result['status']) && ($result['status']  == "ZERO_RESULTS")) ){
		$alternate = array("lat" => $alternate['geoplugin_latitude'] , "lng" =>  $alternate['geoplugin_longitude']);
		$result = $alternate;
	}else if($result["status"] == "OK"){
		$result = $result["results"]["geometry"]["location"];
	} 
	
	return $result;
}

function getPlaces( $coord){
	$result = file_get_contents("https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=".$coord."&rankby=prominence&key=AIzaSyB61jDvlikK0_BX-k6-SASjVoFrVuYUL2w");
	//echo "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=".$coord."&rankby=distance&type=food&key=AIzaSyB61jDvlikK0_BX-k6-SASjVoFrVuYUL2w";
	return json_decode($result, TRUE);


}

/**
From http://www.if-not-true-then-false.com/2009/
For converting a Std class object to an array
*/
function objectToArray($d) {
		if (is_object($d)) {
			// Gets the properties of the given object
			// with get_object_vars function
			$d = get_object_vars($d);
		}
 
		if (is_array($d)) {
			/*
			* Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return array_map(__FUNCTION__, $d);
		}
		else {
			// Return array
			return $d;
		}
	}

function getTags(){



}
?>
