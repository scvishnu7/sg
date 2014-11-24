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
	$result = mysql_query("INSERT INTO sg_body values(null,\"".$cur_date."\",\"".$suggestion."\")",$this->dbh);
	echo "Done. Thanks for Suggestion.<br/>";
}

public function checkUserCred($user, $pass){
	$query = "SELECT * from sg_user where username=\"".$user."\" && password=password(\"".$pass."\")";
	$res = mysql_query($query);
	if(mysql_num_rows($res)==1){
		return true;	
	}
	return false;

}

public function insertIssue($issue_tag, $issue_desc){
	$query = "insert into sg_issues values(null,\"".$issue_tag."\",\"".$issue_desc."\")";
	$result = mysql_query($query, $this->dbh);
	echo " Issue Added.<br/>";
}

public function getIssues(){
	$result = mysql_query("SELECT * from sg_issues",$this->dbh);
	$array = array();
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$issue = new Issue();
		$issue->hashtag = $row["hashtag"];
		$issue->description = $row["description"];
		$issue->id = $row["is_id"];
		$array[] = $issue;
	}
	return $array;
	}

	public function delIssues($iss_id){
	$result = mysql_query("DELETE FROM sg_issues WHERE is_id=".$iss_id,$this->dbh);
	echo "issue Deleted.<br/>";
	}

public function getAllSuggestion(){
	$result = mysql_query("SELECT * from sg_body");
	$array = array();
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$sug = new Suggestion();
		$sug->body = $row["suggestion"];
		$sug->date = $row["time"];
		$sug->id = $row["sg_id"];
		$array[] = $sug;
	}
	return $array;
	}
	
public function filterSugestions(){
	//give me the logic to filter the suggestion :D
	$result = mysql_query("SELECT * from sg_body ");
	$array = array();
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$sug = new Suggestion();
		$sug->body = $row["suggestion"];
		$sug->date = $row["time"];
		$sug->id = $row["sg_id"];
		if($row["sg_id"]==12){
			continue;		
		}
		$array[] = $sug;
	}
	return $array;
	}	
	
	public function delSuggestion($sug_id){
	$result = mysql_query("DELETE FROM sg_body WHERE sg_id=".$sug_id,$this->dbh);
	echo "Suggestion Deleted.<br/>";
	}
	
	public function changePass($currentUname, $uname, $currentPass, $newPass){
		if($this->checkUserCred($currentUname,$currentPass)){		
		$query = "UPDATE sg_user set username=\"".$uname."\" and password=password(\"".$newPass."\) where username=\"".$currentUname."\"";
		$res = mysql_query($query, $this->dbh);
		echo "Password Changed<br/>"; 	
	} else {
		echo "Sorry wrong password<br/>";	
	}
	}
}

?>
