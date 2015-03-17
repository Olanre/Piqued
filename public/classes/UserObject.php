<?php
/** 
 * File: UserObject.php 
 * 
 * This class is designed to be the interface class with a database. 
 * Any action or event related to the user - as an a distinct object within
 * our system - is done by implementing the methods in this class
 * @author     Olanrewaju Okunlola 
 * @version    1.0
 * @date 		July 12 2014
 *  
 */
 
class UserObject{

	#Instance variables
	private $UserName  = ""; 
    private $Password = ""; 
	private $Sex = "Other";
    private $Email  = ""; 
    private $Location  = ""; 
    private $Age = 13;  
    private $ERROR   = "Generic error for UserObject "; 
    private $Type; 
    private $UserId; 
	
	# Constructor
	public function __construct($username, $email)  //php 5+ style constructor 
    { 
        $this->UserName = $username;  
		$this->Email = $email;
		$this->Type = 1;
	
    } 
     
    /** 
     * Destructor 
     */ 
    function __destruct() 
    { 
        $this->UserName = ""; 
        $this->PASS = "";  
		$this->Email = "";
		$this->Type = null; 
		$this->Sex = "";
		$this->Age = null;
		$this->Location = "";
    }
	#function to get the username
	protected function getUserName(){
		return $this->UserName;
	}

	#function to set the username
	protected function setUserName( $username ){
		$this->UserName = $username;
	}
	
	#function to get the password
	protected function getPassword(){
		return $this->Password;
	}
	
	#function to set the password
	protected function setPassword( $password){
		$this->Password = $password;
	}
	
	#function to get the phone number
	protected function getAge(){
		return $this->Age;
	}
	
	#function to set the phone number
	protected function setAge( $number ){
		$this->Age = $number;
	}
	
	#function to get the email
	protected function getEmail(){
		return $this->Email;
	}
	
	#function to set the email
	protected function setEmail($address){
		$this->Email = $address;
	}
	
	#function to get the location
	protected function getLocation(){
		return $this->Location
	}
	
	#function to set the location
	protected function setLocation( $location){
		$this->Location = $location;
	}
	
	#function to get the timezone
	protected function getSex(){
		return $this->Sex;
	}
	
	#function to set the timezone
	protected function setSex( $sex){
		$this->Sec = $sex;
	}
	
	#functiont to get the user Type
	protected function getType(){
		return $this->Type;
	}
	
	#function to set the user type
	protected function setType($type){
		$this->Type = $type;
	}
	
	#function to get the id of the user
	protected function getUserId(){
		return $this->$UserId;
	}
	
}
?>