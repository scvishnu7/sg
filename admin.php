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

	$suggestions = array();
	$suggestions = $db->getAllSuggestion();
	
	$issues = array();
	$issues = $db->getIssues();
	
	//ask for user credential for accessing this page.
	//allow user to change password.	
	
	//make able to delete suggestions.
?>

<style type="text/css">

.oddRow {
		background-color: gray;
	}

.evenRow {
	background-color: white;
}
#containerDiv {
	padding-left:20px;
	padding-right:20px;
	padding-top:10px;
	padding-bottom:10px;
	background-color:gray;
	width:60%;
	margin:auto;
	align:center;
}
#suggestionDiv {
	padding-left:20px;
	padding-right:20px;
	padding-top:10px;
	padding-bottom:10px;
	background-color:pink;
	width:90%;
	margin:auto;
	align:center;
}

#suggestionDiv table {
	width:100%;
	margin:auto;
}

#suggestionDiv table, #suggestionDiv th, #suggestionDiv td {
   border: 1px solid black;
   border-collapse: collapse;
   
}

#issueTable {
	width:600px;
	margin-left: 150px;
}

#issueTable, #issueTable th, #issueTable td {
   border: 1px solid black;
   border-collapse: collapse;
}

td {
	padding-left:10px;
	padding-right:10px;
	padding-top:5px;
}

</style>

<script type="text/javascript">
function clickedOn(name) {
	alert("Hello World "+name);
		
		
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
	<input type="submit" name="chgpasswd" value="Change Password" onClick="alert('working on');">
	</form>
LOGOUT;
	}
?>

<h2>Issues</h2>
<div  id="issues">

<form action="#" method="POST">
<table id="issueTable">
<tr>
	<td> #hashtag: description</td>
	<td> action</td>
</tr>
<?php
foreach( $issues as $iss) {
	
echo <<< ISSUE_ROW
			<tr>
			<td><b>#$iss->hashtag</b> : $iss->description</td>
			<td> <a href='admin.php?delissid=$iss->id'>Delete</a></td>
			</tr>
ISSUE_ROW;
}
?>

<tr>
	<td><input type="text" name="hashtag" value="#hashtag"> <input type="text" name="tagdesc" value="description"> </td>
	<td><input type="submit" name="submit_issues"> </td>
</tr>
	
</table>
</form>
</div>

<h2>Suggestions</h2>
<p>
We need to add the sorting, grouping by the issues and the people tagged. Also the searching feature.<br/>
Thinking about deleting feature. But i think it would be better to put delete button somewhere in remote :D.
</p>

<div id="containerDiv">
<div id="sortOptions">
<form action="#" method="POST">
List suggestions On : <input type="text" name="issues">
tagged to :<input type="text" name="personTagged">
in period :<input type="text" name="period">
containing word: <input type="text" name="searchKeyword">
<input type="submit" name="list" value="Ok">
</form>
</div>
<hr/>

<div  id="suggestionDiv">
<table >
	<tr>
		<td>ID</td>
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
			<td> $sug->id </td>
			<td> $sug->date</td>
			<td> $sug->body</td>
			<td> <a href='admin.php?delsugid=$sug->id'>Delete</a></td>
		</tr>

TABLE_ROW;
}

?>

</table>

</div>
</div>
</body>

</html>

