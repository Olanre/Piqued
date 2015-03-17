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
	header('../index.php');
}
$_SESSION['LAST_ACTIVITY'] = time();

#include the database class and create object
#we will use this for any database related functions
include_once('../classes/Database.php');

#Variables sent via post method to this page
$sUserName = isset($_REQUEST['username'])? $_REQUEST['username'] : '';
$sPassword = isset($_REQUEST['password'])? $_REQUEST['password'] : '';
	
	#perform user input validation and sanitation to prevent 1st or 2nd order
	#injection attacks on our database. We want only alpha-numeric characters
	#with no quotes
	$validate = true;
	#error message string;
	$message = "<span style='color:#700000 '> <h3> Oh No! <h3> </span> ";
	
	
	#Validate user name
	if( $sUserName == '' || !(ctype_alnum($sUserName))){
		$validate = false;
		$message .= error_message(1);
	}else{
		$sUserName = str_replace("'", "\'", $sUserName);
		$sUserName = filter_var($sUserName, FILTER_SANITIZE_STRING);
	}
	

	#Validate password
	if($sPassword == ''){
		$validate = false;
		$message .= error_message(2);
	}else{
		$sPassword = str_replace("'", "\'", $sPassword);
		$sPassword = filter_var($sPassword, FILTER_SANITIZE_STRING); 
		
	}
	
	
	if( $validate == true){
		#check the username and password with the database
		$query = "Select iId, sLocation, sUserName, sSalt, sPassword from tUsers where sUserName = :sUser AND bArchived = 0 ";
						
		$stmt = $MySql->prepareStatement( $query);
		$query_fields = array(":sUser");
		$query_values = array($sUserName);
		
		$MySql->executePreparedStatement( $stmt, $query_fields, $query_values);
		$result = $MySql->fetchRowAssociative();
		#parse relevant data in variables to be used later
		$sSalt = $result[0]['sSalt'];
		$sStoredPass = $result[0]['sPassword'];
		$iUserId = $result[0]['iId'];
		$sUserName = $result[0]['sUserName'];
		$sLocation = $result[0]['sLocation'];
		$now = date("Y-m-d H:i:s");

		$rows = $MySql->numberAffected();

		#so the user does exist in our database
		if( $rows == 1){
			$sCryptedPassword = crypt($sPassword, $sSalt);
			if( $sCryptedPassword == $sStoredPass){
				
				
				#log this as a login with this username
				$query = "INSERT INTO tloggin ( dLogIn, iUserId) VALUES ( :Date , :User)";		
				$stmt = $MySql->prepareStatement( $query);
				$query_fields = array( ":Date", ":User");
				$query_values = array($now,  $iUserId);
				$MySql->executePreparedStatement( $stmt, $query_fields, $query_values);
				
				#set the session user to be the user logged in
				$_SESSION['luser'] = $iUserId;
				$_SESSION['user'] = $sUserName;
				$_SESSION['location'] = $sLocation;
				
			}else{
				$message .= error_message(3);
				echo $message;
				
				#log this as a login attempt with this username
				$query = "INSERT INTO tlogin_attempts ( iUserId, dDate) VALUES ( :User , :Date)";		
				$stmt = $MySql->prepareStatement( $query);
				$query_fields = array(":User", ":Date");
				$query_values = array( $iUserId, $now);
				$MySql->executePreparedStatement( $stmt, $query_fields, $query_values);
			}
		
		}else{
			echo $message;
		}

	}else{

		$message .= error_message(4);
		echo $message;

	}
	
	function error_message($type){
	if($type == 1){
		$message = "
		<h3> The user name is required, only letters and numbers </h3>";
	}
	else if($type == 2){
		$message = "
		<h3> A valid password is required  </h3>";
	}
	else if($type == 3){
		$message = "
		<h3> Username or Password is incorrect</h3>";
	}
	else if($type == 4){
		$message = "
		<h3> No account found with that username</h3>";
	}
	
	
	return $message;
}
?>