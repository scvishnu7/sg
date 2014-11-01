<?php
class DbManager {
	var $host;
	var $username;
	var $password;
	var $database;
	public $dbh;

public function init_db(){
		$this->host="localhost";
		$this->username="root";
		$this->password="root";
		$this->database="sg";

	$this->dbh = mysql_connect($this->host, $this->username, $this->password)or die("cannot connect"); //Store data connection specifier in object
    mysql_select_db($this->database)or die("cannot select DB");
	}

public function writeToDb($suggestion){
	$cur_date = date("Y-m-d h:i:sa");
	echo "<br/> ".$cur_date." <br/>";
//	$result = mysql_query("INSERT INTO sg_body values(12,\"".$cur_date."\",\"".$suggestion."\")",$dbh);
	$result = mysql_query("INSERT INTO sg_body values(null,\"".$cur_date."\",\"".$suggestion."\")",$this->dbh);

}

}

?>
