<?php
 //Variables
 $flag = true;
 $row = 1;
 $columns = "iType, iOsmId, iLatitude, iLongitude, sName";
 $create_Table = "CREATE TABLE IF NOT EXISTS `tLocations` (
  `iId` bigint(20) NOT NULL AUTO_INCREMENT,
  `bArchived` tinyint(1) NOT NULL DEFAULT '0',
  `dAddedOn` datetime NOT NULL,
  `iType` bigint(20) NOT NULL,
  `iOsmId` bigint(20) NULL,
  `iLatitude` bigint(20) NOT NULL,
  `iLongitude` bigint(20) NOT NULL,
  `sName` varchar(200) NOT NULL,
  `iHits` bigint(20),
  `iCondensed` bigint(20),
  PRIMARY KEY (`iId`),
  KEY `iType` (`iType`),
  KEY `iLatitude` (`iLatitude`),
  KEY `iLongitude` (`iLongitude`),
  KEY `iCondensed` (`iCondensed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
$filename = "north-america-latest.csv";

$databasehost = "localhost"; 
$databasename = "clique2"; 
$databasetable = "tlocations"; 
$databaseusername="root"; 
$databasepassword = "Proverbs4:7"; 
$fieldseparator = "|"; 
$lineseparator = "\n";
$csvfile = "pois_north-america-latest.csv";
echo $flag;
if($flag){
	if(!file_exists($csvfile)) {
		die("File not found. Make sure you specified the correct path." . $csvfile);
	}

	try {
		$pdo = new PDO("mysql:host=$databasehost;dbname=$databasename", 
			$databaseusername, $databasepassword,
			array(
				PDO::MYSQL_ATTR_LOCAL_INFILE => true,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			)
		);
		echo "Created PDO connection";
	} catch (PDOException $e) {
		die("database connection failed: ".$e->getMessage());
	}

	$affectedRows = $pdo->exec("
		LOAD DATA LOCAL INFILE ".$pdo->quote($csvfile)." INTO TABLE `$databasetable ($columns)`
		  FIELDS TERMINATED BY ".$pdo->quote($fieldseparator)."
		  LINES TERMINATED BY ".$pdo->quote($lineseparator));

	echo "Loaded a total of $affectedRows records from this csv file.\n";
	$flag = false;
}
/**
if( $flag){

	if (($handle = fopen($filename, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, "|")) !== FALSE) {
        $num = count($data);
        echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
        for ($c=0; $c < $num; $c++) {
            echo $data[$c] . "<br />\n";
        }
    }
    fclose($handle);
}


}
*/
?>
