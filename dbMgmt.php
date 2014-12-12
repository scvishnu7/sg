<?php
include('dataModels.php');
include('config/conf.php');

class DbManager {
	var $host;
	var $orgname;
	var $username;
	var $password;
	var $database;
	public $dbh;

	var $sug_table="sg_body";

function __construct(){

		$config = new Conf();
		
		$this->host=$config->conf_host;
		$this->username=$config->dbuname;
		$this->password=$config->dbpass;
		$this->database=$config->dbname;
		$this->orgname=$config->orgname;
		
	$this->dbh = mysql_connect($this->host, $this->username, $this->password)or die("cannot connect"); //Store data connection specifier in object
    mysql_select_db($this->database)or die("cannot select DB");

	}

public function writeToDb($suggestion){
	$cur_date = date("Y-m-d h:i:sa");
	$result = mysql_query("INSERT INTO sg_body values(null,\"".$cur_date."\",\"".$suggestion."\")",$this->dbh);
	
	//strip out the hastags and people tagged and insert into respective table.	
	$itags = array();
	$ptags = array();
	foreach( explode(" ", $suggestion) as $word){
		if($word[0]=="#"){
			$itags[] = substr($word, 1);		
		} else if($word[0]=="@"){
			$ptags[] = substr($word, 1);
		}
	}
	$query1 = "INSERT INTO sg_itags values";
	$itagsLen = count($itags);
	for($i=0;$i<$itagsLen;$i++){
		$delime =  $i==$itagsLen-1?";":",";
		$query1 = $query1."(\"".$itags[$i]."\",\"".$cur_date."\")".$delime;
	}
	$res1 = mysql_query($query1, $this->dbh);
	
	
	$query2 = "INSERT INTO sg_ptags values";
	$ptagsLen = count($ptags);
	for($i=0;$i<$ptagsLen;$i++){
		//(tag,date),
		$delime =  $i==$ptagsLen-1?";":",";
		$query2 = $query2."(\"".$ptags[$i]."\",\"".$cur_date."\")".$delime;
	}
	$res2 = mysql_query($query2, $this->dbh);	
	
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

public function get_itags(){
	$result = mysql_query("SELECT * from sg_itags",$this->dbh);
	$array = array();
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		
		$array[] = $row["itag"];
	}
	return $array;
	}
	
	public function get_ptags(){
	$result = mysql_query("SELECT * from sg_ptags",$this->dbh);
	$array = array();
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$array[] = $row["ptag"];
	}
	return $array;
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
	
public function filterSugestions($itag, $ptag,$from, $to,$word){
	//give me the logic to filter the suggestion :D

	
	$query = "SELECT * from sg_body ";
	$conditions = array();
	if(strlen($itag)>0){
		$conditions[] = "suggestion LIKE \"%$itag%\"";
	}
	if( strlen($ptag)>0 ){
		$conditions[] = "suggestion LIKE \"%$ptag%\"";
	}
	
if( strlen($from)>0 ){
		$conditions[] = "time LIKE \"%$ptag%\"";
	}
	
	if( strlen($to)>0 ){
		$conditions[] = "time LIKE \"%$ptag%\"";
	}
	
	if( strlen($word)>0 ){
		$conditions[] = "suggestion LIKE \"%$word%\"";
	}
	//$from 
	//$to 
	//$word 
	$len = count($conditions);
	if($len>0){
			$query = $query." where ".$conditions[0];

	}
	for($i=1;$i<$len;$i++){
		$query = $query." and ".$conditions[$i];	
	}	
	
	//echo $query;
	//echo "<br/>";
	//print_r($conditions);
	
	$result = mysql_query($query.$cond);
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
