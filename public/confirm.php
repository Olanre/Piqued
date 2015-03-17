<?php
/*****************
 This file receives the new request for a user to be registered
 it checks the input received, checks the database if one has not already
 been taken and prints out some HTML to display the success or failure
 
	@author: Olanrewaju Okunlola
	@date: 2014-07-06
*/
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
#initialize our session
session_start();
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $_SESSION['timeout'])) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
	header('index.php');
}
$_SESSION['LAST_ACTIVITY'] = time();



#include the database class and create object
#we will use this for any database related functions
require_once('/classes/Database.php');

#Variables sent via post method to this page
$sUser = isset($_REQUEST['ua'])? $_REQUEST['ua'] : '';
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Node</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.js"></script>
		<script src="js/jquery.poptrox.min.js"></script>
		 <script src="js/skel.min.js"></script> 
		<script src="js/init.js"></script> 
		
		<noscript>
			 <link rel="stylesheet" href="css/skel.css" /> 
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-wide.css" />
			<link rel="stylesheet" href="css/style-normal.css" />
		</noscript>
		
		<script src="js/main.js"></script>
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
	</head>
	<body>
		<div id = "intro">
			<!-- Header -->
			<header id="header">

				<!-- Logo -->
					<h1 id="logo"><a href="#">Welcome to The Node</a></h1>
				
				<!-- Nav -->
					<nav id="nav">
						<ul>
							<li><a href="index.html"><b>Home</b></a></li>
							<li><a href="#intro"> <span style="color:blue;font-weight:600"> Register </span></a></li>
						</ul>
					</nav>

			</header>
		</div>
		<div id = "content">
			
		<!-- Intro -->
			<section id="intro" class="main style1 dark fullscreen">
				<div class="content container small">
	
					<?php
					#our error message
					$message = "<span style='color:#700000 '> <h3> Oh No! <h3> </span> ";
					
					#validate the user, the string most not 
					#be empty and should only contain letters
					# or/and numbers
					if( $sUser == "" || !(ctype_alnum($sUser))){

						echo $message .= error_message(1);
						
					#if things check out proceed to check if 
					#this user exists in the database	
					}else{

						$sUser = str_replace("'", "\'", $sUser);
						$query = "Select iId, sUserName from tUsers where sSalt = :Salt AND bArchived = 0";
						
						$stmt = $MySql->prepareStatement( $query);
						$query_fields = array(":Salt");
						$query_values = array($sUser);
						
						$MySql->executePreparedStatement( $stmt, $query_fields, $query_values);
						
						$rows = $MySql->numberAffected();
						//var_dump($rows);
						#so the user does exist in our database
						if( $rows == 1){
						
							$result = $MySql->fetchRowAssociative();
							//print_r($result);
							$iId = $result[0]['iId'];
							$sUserName = $result[0]['sUserName'];	
							
							#Set the bActive boolean value to 1 for the user
							$fields = array("bActive");
							$values = array("1");
							$MySql->update( "tUsers", $fields, $values, "iId", $iId );
							?>
							<header>
								<h2>Welcome back</h2>
							</header>
							<div id= "intro_statement">
								<p> Thank you, your email address has now being confirmed </p> <br/>
							</div>
							<div id="Login" >
								<?php
									echo file_get_contents('ajax/UserLogin.php');
								?>
								
							</div>
						<?php
						}else{
						
							echo $message .= error_message(2);
							
						}
					}

					?>
				</div>
			</section>
		</div>
	</body>
</html>
<?php

function error_message($type){
	if($type == 1){
		$message = "<h3> The link you provided is not valid. <br>
		Please check your email for the proper link.</h3>";
	}
	else if($type == 2){
		$message = "<h3> This user does not exist in our database! </h3>";
	}
	return $message;
}

?>
			