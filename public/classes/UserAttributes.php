<?php
/** 
 * File: UserAttributes.php 
 * 
 * This class is designed to be the interface class with a database.  
 * Any service related to the user's attributes which
 * are not previously defined in the database are done through this class
 * 
 * @author     Olanrewaju Okunlola 
 * @version    1.0
 * @date 		July 12 2014 
 * @dependencies Database.php object
 *  
 */


class UserAttributes{
	
	#Instance variables
	private $attributes = array();
    private $User = null; 
	private $UserName  = ""; 
	private $UserId; 
	private $Email  = "";
    private $ERROR   = "Generic error for UserAttributes class, method: "; 
	
	# Constructor
	public function __construct($user, $DBH)  //php 5+ style constructor 
    { 

		$this->MySql = $DBH;
		$this->User = $user;
		$this->UserName = $user->getUserName(); 
		$this->Email = $user->getEmail();
		$this->UserId = $user->getUserId();
	
    } 
     
    /** 
     * Destructor 
     */ 
    function __destruct() 
    { 
		$this->User = null;
		$this->MySql = null;
    }
	
	#set the attributes of a user
	protected function setAttributes ($attributes){
		$UserId = $this->UserId;
		
		$now = date("Y-m-d H:i:s");
		$MySql = $this->MySql;
		try{
			#log this as a attribute for the user
			$query = "INSERT INTO tuserattributes ( dAddedOn, iAddedBy, iUserId, sName, sValue) VALUES ( {$now} , $UserId , $UserId, :sName, :sValue)";		
			$stmt = $MySql->prepareStatement( $query);
			foreach ($attributes as $sName => $sValue){
				$query_fields = array( ":sName", ":sValue");
				$query_values = array( $attributes[ $sName,  $sValue);
				$MySql->executePreparedStatement( $stmt, $query_fields, $query_values);
			}

		} catch( Exception $ex){
			echo $this->ERROR . "setAttributes() " . $ex;
		}
	}
	
	#update the attributes of a user
	protected function updateAttributes ( $fields, $values, $id ){
		$UserId = $this->UserId;
		$table = "tuserattributes";
		$now = date("Y-m-d H:i:s");
		$MySql = $this->MySql;
		try{
			#update this attribute for the user
			$Mysql->update( $table, $fields, $values, $UserId, $id ) 

		} catch( Exception $ex){
			echo $this->ERROR . "updateAttributes($fields, $values, $id) " . $ex;
		}
	}
	
	#get the attributes of a user based on their type
	protected function getAttributes ($type){
		$UserId = $this->UserId;
		$result = null;
		$now = date("Y-m-d H:i:s");
		$MySql = $this->MySql;
		try{
			#log this as a attribute for the user
			$query = "Select sName, sValue from tuserattributes where iUserId =:UserId ";		
			$stmt = $MySql->prepareStatement( $query);
			$query_fields = array( ":UserId");
			$query_values = array( $UserId);
			$MySql->executePreparedStatement( $stmt, $query_fields, $query_values);		
			$result = $MySql->fetchRowAssociative();
		} catch( Exception $ex){
			echo $this->ERROR . "getAttributes($type) " . $ex;
		}
		return $result;
	}
	
	#Get base attributes of a user, not related to their type
	protected function getDefaultAttributes(){
		$UserId = $this->UserId;
		$result = null;
		$now = date("Y-m-d H:i:s");
		$MySql = $this->MySql;
		try{
			#log this as a attribute for the user
			$query = "Select u.sEmail, t.sName , u.sLocation, u.sAddress from tusers  as u, ttypes as t where u.iId = :UserId and t.iId = u.iType ";		
			$stmt = $MySql->prepareStatement( $query);
			$query_fields = array( ":UserId");
			$query_values = array( $UserId);
			$MySql->executePreparedStatement( $stmt, $query_fields, $query_values);		
			$result = $MySql->fetchRowAssociative();
		} catch( Exception $ex){
			echo $this->ERROR . "getDefaultAttributes() " . $ex;
		}
		return $result;
	}
	
	protected function setDefaultLocation( $attributes ){
		$UserId = $this->UserId;
		
		$now = date("Y-m-d H:i:s");
		$MySql = $this->MySql;
		try{
			#log this as a attribute for the user
			$query = "INSERT INTO tuserattributes ( dAddedOn, iAddedBy, iUserId, sLocation, sAddress) VALUES ( {$now} , $UserId , $UserId, :sName, :sValue)";		
			$stmt = $MySql->prepareStatement( $query);
			foreach ($attributes as $sName => $sValue){
				$query_fields = array( ":sName", ":sValue");
				$query_values = array( $attributes[ $sName,  $sValue);
				$MySql->executePreparedStatement( $stmt, $query_fields, $query_values);
			}

		} catch( Exception $ex){
			echo $this->ERROR . "setAttributes() " . $ex;
		}
	}
	
	#function to get a specific attribute value by name 
	protected function getAttribute( $name){
		$UserId = $this->UserId;
		$result = null;
		$now = date("Y-m-d H:i:s");
		
		$MySql = $this->MySql;
		try{
			#log this as a attribute for the user
			$query = "Select sValue from tuserattributes where iUserId =:UserId AND sName = :sName ";		
			$stmt = $MySql->prepareStatement( $query);
			$query_fields = array( ":UserId", ":sName");
			$query_values = array( $UserId, $name);
			$MySql->executePreparedStatement( $stmt, $query_fields, $query_values);		
			$result = $MySql->fetchRowAssociative();
		} catch( Exception $ex){
			echo $this->ERROR . "getAttribute($name) " . $ex;
		}
		return $result;
	}
	
}
?>