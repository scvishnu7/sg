<?php
	include('dbMgmt.php');
	
	function save_suggestion($suggText){
		$db = new DbManager();
		$db->writeToDb($suggText);
		return true;
	}

?>
