<?php
	/*************************
	Simple logout page
		@author: Olanre Okunlola
		@date: July 12 2014
	*************************/
    session_start();
	#include the database class and create object
	#we will use this for any database related functions
	include_once('../classes/Database.php');
    
	$now = date("Y-m-d H:i:s");
	$iUserId = $_SESSION['luser'] ;
	
	#log this as a log out with this username
	$query = "INSERT INTO tloggin ( dLogOut, iUserId) VALUES ( :Date , :User)";		
	$stmt = $MySql->prepareStatement( $query);
	$query_fields = array( ":Date", ":User");
	$query_values = array($now,  $iUserId);
	$MySql->executePreparedStatement( $stmt, $query_fields, $query_values);
	
	#destroy session and any session variables
	
	session_destroy();
	#set the window location back to index
	header('Location: http://www.piquednow.appspot.com');
?>