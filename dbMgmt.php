<?php
include('dataModels.php');
include('config/conf.php');

class DbManager {
	var $host;
	var $username;
	var $password;
	var $database;
	public $dbh;

	var $sug_table="sg_body";

function __construct(){
	
		$config = new Conf();
		
		$this->host="localhost";
		$this->username=$config->dbuname;
		$this->password=$config->dbpass;
		$this->database=$config->dbname;
		
	$this->dbh = mysql_connect($this->host, $this->username, $this->password)or die("cannot connect"); //Store data connection specifier in object
    mysql_select_db($this->database)or die("cannot select DB");

	}

public function writeToDb($suggestion){
	$cur_date = date("Y-m-d h:i:sa");
	echo "<br/> ".$cur_date." <br/>";
//	$result = mysql_query("INSERT INTO sg_body values(12,\"".$cur_date."\",\"".$suggestion."\")",$dbh);
	$result = mysql_query("INSERT INTO sg_body values(null,\"".$cur_date."\",\"".$suggestion."\")",$this->dbh);

}

public function checkUserCred($user, $pass){
	$query = "SELECT * from sg_user where username=\"".$user."\" && password=password(\"".$pass."\")";
	$res = mysql_query($query);
	if(mysql_num_rows($res)==1){
		return true;	
	}
	return false;

}

public function getAllSuggestion(){
	$result = mysql_query("SELECT * from sg_body");
	$array = array();
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$sug = new Suggestion();
		$sug->body = $row["suggestion"];
		$sug->date = $row["time"];
		$sug->id = $row["id"];
		$array[] = $sug;
	}
	return $array;
	}
	
	public function delSuggestion($sug_id){
			
	}
}

?>
