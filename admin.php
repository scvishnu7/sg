<html>
<head>
<title>Suggestion Admin Panel</title>

<?php
	session_start();
	include('dbMgmt.php');
	$db = new dbManager();
		
	$isLogined=false;
	$loginedUser = "";
	if(isset($_POST['Login'])){
		//need to check the user form user db	
		if($db->checkUserCred($_POST['uname'],$_POST['pass'])){
					$_SESSION['user']= $_POST['uname'];	
					$isLogined = true;
		}	else {
			echo "Sorry Wrong uname or pass!!";
			$isLogined = false;		
		}
	}
		
	if(isset($_POST['logout'])){
		unset($_SESSION['user']);			
	}		
		
	if(isset($_SESSION['user'])){
		$isLogined = true;
		$loginedUser = $_SESSION['user'];
	} else {
		$isLogined= false;
	}
	
	if(isset($_POST['submit_issues'])){
		$issue_tag = $_POST['hashtag'];
		$issue_desc = $_POST['tagdesc'];
		
		$db->insertIssue($issue_tag, $issue_desc);	
		
	}
	
	if(isset($_GET['delsugid'])){
		$db->delSuggestion($_GET['delsugid']);
	}
	
	if(isset($_GET['delissid'])){
		$db->delIssues($_GET['delissid']);	
	}
	
	//$issues = array();
	$issues = $db->getIssues();
	$itags = $db->get_itags();
	$ptags = $db->get_ptags();
	
	$sel_itag="";
	$sel_ptag="";
		
	$sel_from = "";
	$sel_to="";
	$sel_word="";	

	$suggestions = array();
	if(isset($_POST['filtersug'])){
				
		$sel_itag = $_POST["filt_itag"];
		$sel_ptag = $_POST["filt_ptag"];
		$sel_from = $_POST["filt_from"];
		$sel_to = $_POST["filt_to"];
		$sel_word = $_POST["filt_word"];
		
		$suggestions = $db->filterSugestions($sel_itag, $sel_ptag,$sel_from, $sel_to,$sel_word);		
	} else {
		$suggestions = $db->getAllSuggestion();
	}
	
	
	//print_r($itags);
	echo "<br/>";
	//print_r($ptags);
	//ask for user credential for accessing this page.
	//allow user to change password.	
	
	//make able to delete suggestions.
?>
<link rel="stylesheet" type="text/css" href="style/style.css">

<script type="text/javascript">

function validateIssueForm() {
	var hashTag = document.forms["issueForm"]["hashtag"].value;
	var tagDesc = document.forms["issueForm"]["tagdesc"].value;
	var msg="";

	if(hashTag.trim().length == 0){
		alert("hashtag is required.");
		return false;
	} 
	
	if(hashTag == "hashtag"){
		if(!confirm("#hastag is placeholder. Do you want to use it anyway?")){
		return false;
		}	
	}
	if(tagDesc.trim().length == 0){
	if(!confirm("\"description\" is found to be empty. Do you want to use it anyway?")){
		return false;
		}
	}
	if(tagDesc == "description"){
		if(!confirm("\"description\" is placeholder. Do you want to use it anyway?")){
		return false;
		}	
	}
	return true;

}

</script>

</head>
<body>

<?php 
//give login screen.
if(!$isLogined){ 
echo <<< FORMINP
			<form target="#" method="POST">
				<table>				

				<tr><td>username :</td><td> <input type="text" name="uname"></td></tr>
				<tr><td>pass :</td><td><input type="password" name="pass"></td></tr>
				<tr><td><input type="submit" name="Login"></td></tr>
				
				</table>
			</form>		
FORMINP;
		exit();
	}	else {
	echo " Welcome Mr. ".$loginedUser;
echo <<< LOGOUT
	<form target="#" method="POST" style='display:inline;'>
	<input type="submit" name="logout" value="LOGOUT">
	<a href="profile.php">Advance Administration</a>	
		</form>
LOGOUT;
	}
?>

<h2>Issues</h2>
<div  id="issues">

<table id="issueTable">
<tr style="background-color:#00B8D4; font-size:20px">
	<td> #hashtag: description</td>
	<td> action</td>
</tr>
<?php
foreach( $issues as $iss) {
	
echo <<< ISSUE_ROW
			<tr>
			<td><b>#$iss->hashtag</b> : $iss->description</td>
			<td> <a href='admin.php?delissid=$iss->id' onclick="return confirm('Are you sure you wanna delete this issue?');">Delete</a></td>
			</tr>
ISSUE_ROW;
}
?>

<form action="#" method="POST" name="issueForm" onsubmit="return validateIssueForm()">
<tr style="background-color:#8BC34A; font-size:20px">
	<td>New Issue <input type="text" name="hashtag" value="hashtag" size="10"> <input type="text" name="tagdesc" value="description" size="40"> </td>
	<td><input type="submit" name="submit_issues"> </td>
</tr>
</form>
</table>

</div>

<h2>Suggestions</h2>
<p>
We need to add the sorting, grouping by the issues and the people tagged. Also the searching feature.<br/>
Thinking about deleting feature. But i think it would be better to put delete button somewhere in remote :D.
</p>

<div id="containerDiv">
<div id="sortOptions">
<form action="#" method="POST">
List suggestions On : 
<select name="filt_itag">
<option value=""></option>
<?php
foreach($itags as $itag){
	$isSel = $sel_itag==$itag?"selected":"";
	echo "<option value=\"".$itag."\"".$isSel."> #".$itag."</option>";
}
?>
</select>
tagged to :
<select name="filt_ptag">
<option value=""></option>
<?php
foreach($ptags as $ptag){
	$isSel = $sel_ptag==$ptag?"selected":"";
	echo "<option value=\"".$ptag."\"".$isSel."> @".$ptag."</option>";
}
?>
</select>
<!--
from:<input type="date" name="filt_from">
to:<input type="date" name="filt_to">
-->
containing word: <input type="text" name="filt_word">
<input type="submit" name="filtersug" value="Ok">
</form>
</div>

<div  id="suggestionDiv">
<table width="100%" >
	<tr style="background-color:#00B8D4; font-size:20px">
		<td>S.N.</td>
		<td>Date</td>
		<td>Suggestion</td>
		<td>Action</td>
	</tr>
<?php
$i=0;
foreach( $suggestions as $sug) {
	$i++;
	$cssClass = ((int)$i%2)==0?'oddRow':'evenRow';
echo <<< TABLE_ROW
		<tr class=$cssClass>
			<td> $i </td>
			<td> $sug->date</td>
			<td> $sug->body</td>
			<td> <a href='admin.php?delsugid=$sug->id' onclick="return confirm('Are you sure you wanna delete this suggestion?');">Delete</a></td>
		</tr>

TABLE_ROW;
}

?>

</table>

</div>
</div>
</body>

</html>

