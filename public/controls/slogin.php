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
include_once('../classes/UserObject.php');

#include class for getting location from IP
include_once('../include/IPlocation.php');


#Variables sent via post method to this page
$jData = isset($_REQUEST['data'])? $_REQUEST['data'] : '';
$sType = isset($_REQUEST['type'])? $_REQUEST['type'] : '';
	
	
	#perform user input validation and sanitation to prevent 1st or 2nd order
	#injection attacks on our database. We want only alpha-numeric characters
	#with no quotes
	$validate = true;
	#error message string;
	$message = "<span style='color:#700000 '> <h3> Oh No! <h3> </span> ";
	$arr = array();
	
	#Validate user name
	if( $jData == '' || !is_array(json_decode($jData, true)) ){
		$validate = false;
		$message .= error_message(1);
	}else{
		//$jData = str_replace("'", "\'", $jData);
		$arr = json_decode($jData, true);
	}
	

	#Validate password
	if($sType == '' || !(ctype_alnum($sType))){
		$validate = false;
		$message .= error_message(2);
	}else{
		$sType = str_replace("'", "\'", $sType);
		$sType = filter_var($sType, FILTER_SANITIZE_STRING); 
		
	}
	#country name from IP
	$sLocation = ip_info($cip, "City") .  " - " .  ip_info($cip, "Country"); 
	$sLocation = str_replace("'", "\'", $sLocation);
	
	if( $validate == true){
	
		$now = date("Y-m-d H:i:s");
		#depending on whether we have a facebook login or google login, different types
		# of information must be decoded
		if($sType == 'fb'){
			
			echo " Facebook login detected";
			$name = isset($arr["name"]) ? $arr['name'] : '';
			$gender = isset($arr["gender"]) ? $arr['gender'] : '';
			$birthday = isset($arr['birthday']) ? $arr['birthday'] : '';
			$age = getAge($birthday) ;
			$image = isset($arr['data']['url']) ? $arr['data']['url'] : '';
			echo $image;
			$email = isset($arr["email"]) ? $arr['email'] : '';
			$firstname = isset($arr["first_name"]) ? $arr['first_name'] : '';
			$lastname = isset($arr["last_name"]) ? $arr['last_name'] : '';
			$profile = isset($arr["link"]) ? $arr['link'] : '';
			$password = generatePassword($i);
			$sSalt = createSalt();
			$sPassword = crypt($password, $sSalt);
						
			#check if the user already exists, if so log them in and proceed 
			#to create a session for them, otherwise create a user for individual
			$UserExists = checkUser($name, $email, $message, $MySql);
			$User_info = array(
					"name" => $name,
					"firstname" => $firstname,
					"lastname" => $lastname,
					"age" => $age,
					"gender" => $gender,
					"image" => $image,
					"email" => $email,
					"password" => $sPassword,
					"salt" => $sSalt,
					"location" => $sLocation,);
					
			if($UserExists !== false && isset($UserExists)){
				echo "User Exists";
				UserLogin( $UserExists, $now, $MySql, $User_info);
				echo "Logged In";
				
			}else{
					gateway($User_info, $MySql);
					echo "User account created";
					
			}
			
		
		}else if($sType == 'gog'){
			
			echo "Google login detected";
			$name = $arr["displayName"];
			$gender = $arr["gender"];
			$image = isset($arr["image"]["url"])? $arr["image"]["url"] : '';
			$firstname = $arr["name"]["givenName"];
			$lastname = $arr["name"]["familyName"];
			$email = $arr["emails"]["0"]["value"];
			$language = isset($arr["language"])? $arr["language"]: '';
			$lowerAge = isset($arr["ageRange"]["min"]) ? $arr["ageRange"]["min"] : '';
			$maxAge = isset($arr["ageRange"]["max"])? $arr["ageRange"]["max"]: '';
			$profile = isset($arr["url"])? $arr["url"]:'';
			$password = generatePassword($i);
			$sSalt = createSalt();
			$sPassword = crypt($password, $sSalt);
			
			#check if the user already exists, if so log them in and proceed 
			#to create a session for them, otherwise create a user for individual
			$UserExists = checkUser($name, $email, $message, $MySql);
			$User_info = array(
				"name" => $name,
				"firstname" => $firstname,
				"lastname" => $lastname,
				"age" => $lowerAge,
				"gender" => $gender,
				"image" => $image,
				"email" => $email,
				"password" => $sPassword,
				"salt" => $sSalt,
				"location" => $sLocation,);
				
			if($UserExists !== false && isset($UserExists)){
				echo "User Exists";
				UserLogin( $UserExists, $now, $MySql, $User_info);
				echo "Logged In";
				
			}else{
					gateway($User_info, $MySql);
					echo "User account created";
			}
		
		}

	}else{

		$message .= error_message(4);
		echo $message;

	}
/****************************************************************
function to return an error message based on the value the type

@param type which is the type of message
@return message which is the message to be displayed
*******************/
function error_message($type){
	if($type == 1){
		$message = "<h3> The data value supplied is not acceptable </h3>";
	}
	else if($type == 2){
		$message = "<h3> The type value is not acceptable  </h3>";
	}
	else if($type == 3){
		$message = "<h3> Error parsing the data array</h3>";
	}
	else if($type == 4){
		$message = "<h3> Validating data returned false </h3>";
	}
	
	return $message;
}

/**********************************************************
* Returns the age based on a birth date
@param then which is the birth date
@return $diff which is the difference between the years now and then
*/
function getAge($then) {
    $then = date('Ymd', strtotime($then));
    $diff = date('Ymd') - $then;
    return substr($diff, 0, -4);
}

/******************************************************
Function to generate a random password for a user
*/
function generatePassword($length = 8) {
    $chars = 'bcdfghjklmnpqrstvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ23456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }

    return $result;
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
	#$MySql->query("Select * from tusers where sUserName = '{$sUserName}' AND bArchived = 0 ");
	#$rows = $MySql->numberAffected();
	#$result = $MySql->fetchRowAssociative();
	$MySql->query("Select * from tusers where sEmail = '{$sEmail}'AND bArchived = 0 ");
	$rows2 = $MySql->numberAffected();
	$result2 = $MySql->fetchRowAssociative();
	
	$returnval = false;
	
	if( $rows2 > 0){
		$returnval = $result2[0]['iId'];
	}
	return $returnval;
}

/*******************************
Function to log a user in

@param UserId : id of the user to be logged in
*/
function UserLogin( $iUserId, $now, $MySql, $user){
	#log this as a login with this username
	$query = "INSERT INTO tloggin ( dLogIn, iUserId) VALUES ( :Date , :User)";		
	$stmt = $MySql->prepareStatement( $query);
	$query_fields = array( ":Date", ":User");
	$query_values = array($now,  $iUserId);
	$MySql->executePreparedStatement( $stmt, $query_fields, $query_values);
	
	#set the session user to be the user logged in
	$_SESSION['luser'] = $iUserId;
	$UserObj = new UserObject( $user['name'], $user['email']);
	$UserObj->setAge( $user['age']);
	$UserObj->setSex( $user['sex']);
	$UserObj->setLocation( $user['location']);
	$_SESSION['user'] = $UserObj;
	
}

/***************************************
Function from register.php to register
a new user in our database
*/
function gateway($user, $MySql){

	$now = date("Y-m-d H:i:s");		
	$fields = "dAddedOn,sUserName,sPassword,sSalt,sEmail,bActive,sLocation";
	$fields = explode(",", $fields);

	$values = "$now,".$user['name'].",".$user['password'].",".$user['salt'].",".$user['email'].",1,".$user['location']."";
	$values = explode(",", $values);

	$MySql->insert("tusers", $fields, $values);

	#Get the last inserted row
	$UserId = $MySql->lastId();

	#log the user in
	UserLogin($UserId, $now, $MySql, $user);

}


?>