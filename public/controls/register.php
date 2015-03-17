<?php
/******************************************************
 This file receives the new request for a user to be registered
 it checks the input received, checks the database if one has not already
 been taken and prints out some HTML to display the success or failure
 
	@author: Olanrewaju Okunlola
	@date: 2014-07-06
	
*******************************************************/

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

#initialize our session for use
session_start();
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $_SESSION['timeout'])) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage

}
$_SESSION['LAST_ACTIVITY'] = time();

#include the database class and create object
#we will use this for any database related functions
require_once('../classes/Database.php');

#include class for getting location from IP
include_once('../include/IPlocation.php');

#include class for generating html email
include_once('email.php');

#include class for SMTP plugin PHPMailer
require_once('../PHPMailer/class.phpmailer.php');
include_once('../PHPMailer/class.smtp.php');
	


#Variables sent via post method to this page
$sUserName = isset($_REQUEST['username'])? $_REQUEST['username'] : '';
$sEmail = isset($_REQUEST['email'])? $_REQUEST['email'] : '';
$sPassword = isset($_REQUEST['password'])? $_REQUEST['password'] : '';
$iAge = isset($_REQUEST['Age'])? $_REQUEST['Age'] : 0;
$iSex = isset($_REQUEST['Sex'])? $_REQUEST['Sex'] : 0;
$sSalt = "";
	
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

	#Validate email address
	if($sEmail == '' ){
		$message .= error_message(2);
		$validate = false;
	}else{
		$sEmail = str_replace("'", "\'", $sEmail);
		$sEmail = filter_var($sEmail, FILTER_SANITIZE_EMAIL);
		if (!filter_var($sEmail, FILTER_VALIDATE_EMAIL)) {
			$message .= error_message(3);
            //$validate = false;
        } 
	}

	#Validate password
	if($sPassword == ''){
		$validate = false;
		$message .= error_message(4);
	}else{
		$sPassword = str_replace("'", "\'", $sPassword);
		$sPassword = filter_var($sPassword, FILTER_SANITIZE_STRING); 
		//encrypt our password using custom PHP function
		$sSalt = createSalt();
		$sPassword = crypt($sPassword, $sSalt);
	}
	
	#Validate age
	if($iAge == 0 || !is_numeric($iAge) || $iAge < 13){
		$message .= error_message(5);
		$validate = false;
	}
	
	#validate the sex
	if($iSex == 0 || !is_numeric($iSex)){
		$message .= error_message(6);
		$validate = false;
	}
	
	#country name from IP
	$sLocation = ip_info($cip, "City") .  " - " .  ip_info($cip, "Country"); 
	$sLocation = str_replace("'", "\'", $sLocation);
	
	if ($sLocation == " - "){
		$sLocation = "St. John's NL";
	}
	#we are authenticated, move on the create the user in our database
	if( $validate == true && checkUser( $sUserName, $sEmail, $message, $MySql)){
		$now = date("Y-m-d H:i:s");
		
		$fields = "dAddedOn,sUserName,sPassword,sSalt,sEmail,bActive,sLocation";
		$fields = explode(",", $fields);
		
		$values = "{$now},{$sUserName},{$sPassword},{$sSalt},{$sEmail},0,{$sLocation}";
		$values = explode(",", $values);
		
		$MySql->insert("tusers", $fields, $values);

		#send out the email for confirmation
		mail_send( $sUserName, $sEmail, $sSalt, $message);
?> 
	<p>
	Congratulations, you have become a part of the next stage of Real Time Networking .
	An email will be sent to your email address for verification.
	</p>
	<br>
	<a href="#intro" class="button style2 scrolly scrolly-centered"> Elevate My Awareness</a>
<?php
	
}else{

	print($message);

}
/***************
Create salt for password
*/
function createSalt(){
	$text = md5(uniqid(rand(), true));
	return substr($text, rand(0, 5), rand(15, 20));
}

/******************
Function to check is a given user name
or email address does not already exist 
in the database
@param UserName - the username provided
@param Email - the email address given
@param Message - the message to be displayed on error_get_last
*/
function checkUser($sUserName, $sEmail, $message2, $MySql){
	#query for the username and email address
	$MySql->query("Select * from tUsers where sUserName = '{$sUserName}' AND bArchived = 0 ");
	$rows = $MySql->numberAffected();
	$MySql->query("Select * from tUsers where sEmail = '{$sEmail}'AND bArchived = 0 ");
	$rows2 = $MySql->numberAffected();
	
	$returnval = true;
	if( $rows > 0){
		$message2 .= error_message(7);
		$returnval = false;
	}
	
	if( $rows2 > 0){
		$message2 .= error_message(8);
		$returnval = false;
	}
	return $returnval;
}

/**************************
	function to send the email
	out to the user with its own 
	unique identifier
*/
function mail_send($sUserName, $sEmail, $sSalt, $message){

	$to = $sEmail;

	$subject = 'Confirmation Email for Node';
	$mail_message = generateEmail( $sSalt, 1);

	# using phpMailer for our mailing
	$mail = new PHPMailer;
	$mail->isSMTP();                                      # Set mailer to use SMTP
	$mail->SMTPAuth = true;                               # Enable SMTP authentication
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
    $mail->Host = "smtp.gmail.com"; // Specify main and backup SMTP servers
    $mail->Port = 465; // or 587
	
	#Using my email address as smtp server
	$mail->Username = 'okunlola.olanre@gmail.com';                 # SMTP username
	$mail->Password = 'jumpstart777';                           # SMTP password

	$mail->From = ' noreply@node.ca';
	$mail->FromName = 'Node App';
	$mail->addAddress( $sEmail, 'Node Account User');     # Add a recipient

	$mail->WordWrap = 50;                                 # Set word wrap to 50 characters
	$mail->isHTML(true);                                  # Set email format to HTML

	$mail->Subject = $subject;
	$mail->Body    = $mail_message;

	if(!$mail->send()) {
		$message.= 'Email could not be sent.<br> Mailer Error: ' . $mail->ErrorInfo;
	}
		 
}

function error_message($type){
	if($type == 1){
		$message = "
		<h3> The user name is required, only letters and numbers </h3>";
	}
	else if($type == 2){
		$message = "
		<h3> The email address is required  </h3>";
	}
	else if($type == 3){
		$message = "
		<h3> Please enter a valid email address <br/> </h3>";
	}
	else if($type == 4){
		$message = "
		<h3> A valid password is required </h3>";
	}
	else if($type == 5){
		$message = "
		<h3> Please enter your age </h3>";
	}
	else if($type == 6){
		$message = "
		<h3> Please enter your sex </h3>";
	}
	else if($type == 7){
		$message = "
		<h3> This user already exists </h3>";
	}
	else if($type == 8){
		$message = "
		<h3> This email has an account associated with it </h3>";
	}
	
	return $message;
}


?>