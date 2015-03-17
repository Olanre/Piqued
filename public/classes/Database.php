<?php 
/** 
 * File: Database.php 
 * 
 * This class is designed to be the interface class with a database. 
 * This is currently setup to use SQL syntax however can be changed if needed in future for a different type of database. 
 * Using this class will save a lot of programming if a change was needed. 
 * Also works brilliantly for MySQL, used in 3 major projects so far :) 
 * 
 * @author     Daniel Rosser 
 * @edit     Olanrewaju Okunlola 
 * @version    1.0 
 *  
 */ 
  
class Database { 
    private $HOST  = "unix_socket=/cloudsql/piquednow:no-1"; 
    private $TABLE = "table"; 
	private $DATABASE = "clique2";
    private $USER  = ""; 
    private $PASS  = ""; 
    private $ERROR_CONNECT = "Could not connect to Database";  
    private $ERROR_QUERY   = "Could not query the Database"; 
    private $dbh; 
    private $lastResult; 
	private $DRIVER;
     
    /** 
     * Constructor 
     * @param username - username to connect to database 
	 * @param password - password to connect to database 
	 * @param host - location of the database on the network 
	 * @param database - the database to connect to
	 * @param driver - the database driver we are using
     */ 
    public function __construct($username, $password, $host, $database, $driver)  //php 5+ style constructor 
    { 
        $this->USER = $username; 
        $this->PASS = $password;  
		$this->HOST = $host;
		$this->DATABASE = $database;
		$this->DRIVER = $driver;
        $this->connect(); 
	
    } 
     
    /** 
     * Destructor 
     */ 
    function __destruct() 
    { 
       $this->dbh = null; 
    } 
	
	     
    /** 
     * Connect to the database 
     * @return connection 
     */ 
     
    function connect() 
    { 
      // $this->connection = mysql_connect($this->HOST,$this->USER,$this->PASS) or print mysql_error($this->ERROR_CONNECT); 
       //$result = mysql_select_db($this->TABLE,$this->connection); 
	   try {
		   $this->dbh = new PDO(''.$this->DRIVER.':'.$this->HOST.';dbname='.$this->DATABASE.';charset=utf8', ''.$this->USER.'', ''.$this->PASS.''); 
			$dbh = $this->dbh;
		}catch(PDOException $ex) {
			echo $ERROR_CONNECT; //user friendly message
			//some_logging_function($ex->getMessage());
		}
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return($dbh); 
    }   
     
    /** 
     * Delete a row from a table 
     * @param table - Table name 
     * @param id - ID of row 
     * @return result 
     */      
    function archive($table, $id) 
    { 
		$dbh = $this->dbh;
       $query = "UPDATE $table SET bArchived = 1 WHERE id='$id'"; 
       try {
			$result = $dbh->query($query); //execute the query
		} catch(PDOException $ex) {
			echo $ERROR_QUERY; //user friendly message
			//some_logging_function($ex->getMessage());
		}
       return($result); 
    }  
     
    /** 
     * Delete a row from a table 
     * @param table - Table name 
     * @param idName - name of the ID row 
     * @param id - ID of row 
     * @return result 
     */ 
    function archiveSpecific($table, $idName, $id) 
    { 
       $query = "UPDATE $table set bArchived = 1 WHERE $idName='$id'"; 
       try {
			$result = $dbh->query($query); //execute the query
		} catch(PDOException $ex) {
			echo $ERROR_QUERY; //user friendly message
			//some_logging_function($ex->getMessage());
		}
       return($result); 
    }  
    
	/** Prepare a string for later execution
		@param	string which is the query string to be prepared
	*/
	function prepareStatement( $string){
		$dbh = $this->dbh;
		$sth = $dbh->prepare($string);
		return $sth;
	}
	
	/** execute the statement, bind the parameters to the their destinated values
		try to execute it in a try catch
		@param $resource which is the resource for the prepared statement
		@param $fields which are the fields to have values inserted
		@param values which are the values to be replaced in the fields
	*/
	function executePreparedStatement( $resource, $fields, $values){
		$size   = sizeof($fields); // verify the size of the fields 
		$sizeV  = sizeof($values); 
		if($sizeV != $size) 
			echo "Developer Error, Size of Fields / Values are not the same- Fields:$size Values:$sizeV";
		for($i=0;$i <= ($size-1);$i++){ 
			$resource->bindParam("".$fields[$i]."", $values[$i]);
		}
		
		try {
			//execute the statement
			 $resource->execute();
			 $this->lastResult = $resource;
		} catch(PDOException $ex) {
			echo "An Error occured! ".$ex->getMessage(); //user friendly message
			//some_logging_function($ex->getMessage());
		}
	
	}
	 
    /** 
     * Disconnects and closes the connection with database 
     */ 
    function disconnect() 
    { 
       $this->dbh = null; 
    } 
     
    /** 
     * Insert fields, values into Table 
     * @param table - Table name 
     * @param fields - Fields to insert 
     * @param values - Values to insert 
     */ 
    function insert( $table, $fields, $values ) 
    { 
		$start  = "INSERT INTO $table("; 
		$middle = ") VALUES ("; 
		$end    = ")"; 
		$size   = sizeof($fields); // verify the size of the fields 
		$sizeV  = sizeof($values); 
		if($sizeV != $size) 
			echo "Developer Error, Size of Fields / Values are not the same- Fields:$size Values:$sizeV";
		$stringFields = ""; 
		for($i=0;$i <= ($size-1);$i++){ 
			$stringFields .= "$fields[$i]"; 
			if( $i != ($size-1) ){ 
				$stringFields .= ","; 
			} 
		} 
		$stringValues=""; 
		for( $k=0; $k <= ($size-1); $k++ ){ 
			$stringValues .= "\"$values[$k]\""; 
			if( $k != ($size-1) ){ 
				$stringValues .= ","; 
			} 
		} 
		$insert = "$start$stringFields$middle$stringValues$end";       
		$insert = str_replace('""', mysql_real_escape_string("NULL"), $insert); 
		$insert = str_replace('" "', mysql_real_escape_string("NULL"), $insert); 
		$insert= str_replace("''", "", $insert); 
		$insert = str_replace("' '", "", $insert);     
		$this->query($insert); 
    } 
     
    /** 
     * Update fields, values into Table 
     * @param table - Table name 
     * @param fields - Fields to insert 
     * @param values - Values to insert 
     * @param idName - Name of Primary Key row 
     * @param id - The unique identifier 
     */ 
    function update( $table, $fields, $values, $idName, $id ) 
    { 
      $start  = "UPDATE $table SET "; 
      $end    = " WHERE $idName=\"$id\";"; 
      $size   = sizeof($fields); // verify the size of the fields 
      $sizeV  = sizeof($values); 
      if($sizeV != $size) 
        echo "Developer Error, Size of Fields / Values are not the same- Fields:$size Values:$sizeV"; 
         
      $string = "";       
      for($i=0;$i <= ($size-1);$i++){ 
        $string .= "$fields[$i] = \"$values[$i]\""; 
        if( $i != ($size-1) ){ 
        $string .= " , "; 
        } 
      } 
      $update = "$start$string$end";          
      $update = str_replace('""', mysql_real_escape_string("NULL"), $update); 
      $update = str_replace('" "', mysql_real_escape_string("NULL"), $update); 
      $update = str_replace("''", "", $update); 
      $update = str_replace("' '", "", $update);       
      $this->query($update); 
    } 
     
    /** 
     * Use this for a SQL Query 
     * Data is stored inside $this->lastResult  
     * @param sql - SQL to query the database 
     */ 
    function query($sql) 
    { 
		$dbh = $this->dbh;
		//if(!($this->lastResult = $connection->query($sql) )) 
        //die("MySQL Error from Query. Error: ".mysql_error()." From SQL : $sql"); 
		try {
			//connect as appropriate as above
			$this->lastResult = $dbh->query($sql); 
		} catch(PDOException $ex) {
			echo "An Error occured! " . $ex->getMessage(); //user friendly message
			//some_logging_function($ex->getMessage());
		}
    } 
     
    /** 
     * Fetch rows from last query 
     * @return row array 
     */ 
    function fetchRow() 
    { 
		$lastResult = $this->lastResult;
        //return mysql_fetch_array($this->lastResult); 
		$result = $lastResult->fetchAll();
		return $result;
    } 
     
    /** 
     * Fetch rows from last query 
     * @return an associative array that corresponds to the fetched row and moves the internal data pointer ahead 
     */ 
    function fetchRowAssociative() 
    { 
        $lastResult = $this->lastResult;
		$result = $lastResult->fetchAll(PDO::FETCH_ASSOC);
		return $result;
    } 
     
     
     
    /** 
     * Number of rows in a table 
     * @param table - Table to query 
     */ 
    function number($table) 
    { 
		$dbh = $this->dbh;
        $stmt = $dbh->query('SELECT * FROM $table');
		$row_count = $stmt->rowCount();
        return($row_count); 
    } 
     
    /**  
     * Return the last id of an insertion 
     * @return last id of an insertion 
     */ 
    function lastId()  
    { 
		$dbh = $this->dbh;
       $insertId = $dbh->lastInsertId(); 
	   return $insertId;
    }  
     
    /** 
     * Return the number of rows affected on last query 
     * @return number of rows  
     */ 
    function numberAffected()  
    { 
		$lastResult = $this->lastResult;
       $row_count = $lastResult->rowCount();
       return($row_count); 
    }   
	
	function getDriver( ){
		return $this->DRIVER;
	}
   
     
}
/** Create an instance for mysql database*/
//$MySql = new Database("NodeUser", "TheGrid2356", "unix_socket=/cloudsql/piquednow:no-1", "clique2", "mysql");
$MySql = new Database("root", "", "unix_socket=/cloudsql/piquednow:no-1", "clique2", "mysql");

?> 