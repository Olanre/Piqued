<?php 
/** 
 * File: UserService.php 
 * 
 * This class is designed to be the interface class with a database.  
 * Any service related to the user such as loggin in, checking their email etc
 * Are done through the user of this class
 * 
 * @author     Olanrewaju Okunlola 
 * @version    1.0
 * @date 		July 12 2014 
 * @dependencies Database.php object
 *  
 */
class UserService{
	
	#Instance variables
	private $UserName  = ""; 
	private $User = "";
    private $Password = ""; 
    private $Email  = ""; 
    private $ERROR   = "Generic error for UserService class, method: "; 
    private $MySql; 
    private $UserId; 
	private $login_attempts = 10;
	
	# Constructor
	public function __construct($user, $DBH)  //php 5+ style constructor 
    { 
        $this->UserName = $user->getUserName(); 
		$this->Email = $user->getEmail();
		$this->UserId = $user->getUserId();
		$this->Password = $user->getPassword();
		$this->MySql = $DBH;
		$this->User = $user;
	
    } 
     
    /** 
     * Destructor 
     */ 
    function __destruct() 
    { 
        $this->UserName = ""; 
		$this->Email = "";
		$this->Password = null;
		$this->User = null;
		$this->MySql = null;
    }
	
	#Log in the user with the given username, password and 
	# their unique identifier
	protected function login(){
		$UserId = $this->UserId;
		
		$now = date("Y-m-d H:i:s");
		$MySql = $this->MySql;
		try{
			#log this as a login with this username
			$query = "INSERT INTO tloggin ( dLogIn, iUserId) VALUES ( :Date , :User)";		
			$stmt = $MySql->prepareStatement( $query);
			$query_fields = array( ":Date", ":User");
			$query_values = array($now,  $iUserId);
			$MySql->executePreparedStatement( $stmt, $query_fields, $query_values);
			
			#set the session user to be the user logged in
			$_SESSION['luser'] = $iUserId;
		} catch( Exception $ex){
			echo $this->ERROR . "login() " . $ex;
		}
	}
	
	#Log out the user with the given unqiue id
	protected function logout( $id){
		$now = date("Y-m-d H:i:s");
		$iUserId = $_SESSION['luser'] ;
		$MySql = $this->MySql;
		try{
			#log this as a log out with this username
			$query = "INSERT INTO tloggin ( dLogOut, iUserId) VALUES ( :Date , :User)";		
			$stmt = $MySql->prepareStatement( $query);
			$query_fields = array( ":Date", ":User");
			$query_values = array($now,  $iUserId);
			$MySql->executePreparedStatement( $stmt, $query_fields, $query_values);
		} catch( Exception $ex){
			echo $this->ERROR . " logout() ". $ex;
		}
	}
	
	#Get a user given an identifier
	protected function getUser(){
		return $this->User;
	}
	
	
	#Check if a given user exists in the database given a username
	protected function checkUsername (){
		$MySql = $this->MySql;
		try{
			$MySql->query("Select * from tUsers where sUserName = '{$sUserName}' AND bArchived = 0 ");
			$rows = $MySql->numberAffected();
		} catch( Exception $ex){
			echo $this->ERROR . " checkUsername() ". $ex;
		}
		
		return $rows;
	}
	
	#Check if an email account given is valid
	protected function checkEmail (){
		$MySql = $this->MySql;
		$sEmail = $this->Email;
		$rows = null;
		try{
			$MySql->query("Select * from tUsers where sEmail = '{$sEmail}'AND bArchived = 0 ");
			$rows = $MySql->numberAffected();
		} catch( Exception $ex){
			echo $this->ERROR . " checkEmail() ". $ex;
		}
		return $rows;
		
	}
	
	
	#check the credentials of a user
	protected function checkCredentials(){
		$MySql = $this->MySql;
		$CryptedPassword = "";
		$sStoredPass = " null ";
		try{
			#check the username and password with the database
			$query = "Select iId, sSalt, sPassword from tUsers where sUserName = :sUser AND bArchived = 0 ";
							
			$stmt = $MySql->prepareStatement( $query);
			$query_fields = array(":sUser");
			$query_values = array($this->UserName);
			
			$MySql->executePreparedStatement( $stmt, $query_fields, $query_values);
			$result = $MySql->fetchRowAssociative();
			#parse relevant data in variables to be used later
			$sSalt = $result[0]['sSalt'];
			$sStoredPass = $result[0]['sPassword'];
		} catch( Exception $ex){
			echo $this->ERROR . " checkCredentials() ". $ex;
		}
		
		$sCryptedPassword = crypt($this->Password, $sSalt);
		if( $sCryptedPassword == $sStoredPass){
			return true;
		}else{
			return false;
		}
	}
	
	#Function to check the number of login attempts a user hash
	# if more than allowed attempts for today return false
	protected function checkAttempts(){
		$MySql = $this->MySql;
		$today = date("Y-m-d");
		try{
			#check the login attempts under this user
			$query = "SELECT * FROM tlogin_attempts WHERE DATE( dDate ) = '{$today}' AND sUserName = :sUser";
			$stmt = $MySql->prepareStatement( $query);
			$query_fields = array(":sUser");
			$query_values = array($this->UserName);
			
			$MySql->executePreparedStatement( $stmt, $query_fields, $query_values);
			$rows = $MySql->numberAffected();
			if( $rows >= $this->login_attempts){
				return false;
			}else{
				return true;
			}
		} catch( Exception $ex){
			echo $this->ERROR . " checkAttempts() ". $ex;
		}
	}
	
}
?>
	
} 
