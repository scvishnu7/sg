<?php
	include('dbMgmt.php');
	function save_suggestion($suggText){

	$db = new DbManager();
	$db->init_db();
	$db->writeToDb($suggText);
	return true;
	}

?>
