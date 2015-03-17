<!DOCTYPE HTML>
<?php
/*****************
 This is the main page of the web app
 most of the requests performed will be 
 manipulating elements and divs on 
 this page
 
	@author: Olanrewaju Okunlola
	@date: 2014-07-06
*/
#initialize our session for use
session_start();
$_SESSION['timeout'] = 18000; #set the time out for the session to be 3000 minutes
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $_SESSION['timeout'])) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
	header('index.php');
}
$_SESSION['LAST_ACTIVITY'] = time();

#include the database class and create object
#we will use this for any database related functions
include_once('classes/Database.php');

#include class for getting location from IP
include_once('include/IPlocation.php');

?>
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
		<script src="bootstrap/js/bootstrap.min.js"></script>
		
		
		
		<?php
		if(isset($_SESSION['luser'])){?>
			<!-- enable bootstrap  -->
			<link rel="stylesheet" href="/bootstrap/css/bootstrap.css"/>
			<link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.min.css"/> 
		<?php }else{ ?>
			<noscript>
				<link rel="stylesheet" href="css/skel.css" />
				<link rel="stylesheet" href="css/style.css" />
				<link rel="stylesheet" href="css/style-wide.css" />
				<link rel="stylesheet" href="css/style-normal.css" />
			</noscript>

		<? } ?>
		
		<script src="js/main.js"></script>
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
	</head>
	<body>
	<?php
	#if we detech that a user is logged in
	#retrieve the main page
	if(isset($_SESSION['luser'])){

		echo include('main.php');

	 }else{
	 
		echo include('first_page.php');
		
	 }
?>
	</body>
</html>

