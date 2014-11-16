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
	

	$suggestions = array();
	$suggestions = $db->getAllSuggestion();
	
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

#suggestionDiv table th td {
   border: 1px solid black;
   border-collapse: collapse;
   
}

td {
	padding-left:10px;
	padding-right:10px;
	padding-top:5px;
}

</style>

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

<h1>Suggestions Receved</h1>
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
		</tr>

TABLE_ROW;
}

?>

</table>

</div>

</div>

</body>
</html>

