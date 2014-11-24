<html>
<head>
<title>Suggestion Box</title>
<link rel="stylesheet" type="text/css" href="style/homeStyle.css">
<?php

	include('dbMgmt.php');
	
	$db = new DbManager();

	$issues = array();
	$issues = $db->getIssues();
			
	$suggestion = $_POST['suggestion'];
	if(strlen(trim($suggestion))>0){
		$db->writeToDb($suggestion);
	}
?>
<script type="text/javascript">

function validateSug(){
	var sug = document.forms["sgForm"]["suggestion"].value;
	if(sug.trim().length==0){
		alert("Empty suggestion will convey nothing at all :D.");
		return false;	
	} else if(sug.trim().length >= 200){
		if(!confirm("Longer suggestion are normally boring. Do you want to suggest anyway?")){
			return false;		
		}	
	} 
	return true;
	}

</script>
</head>

<body>
<div id="container">
	<h2 style="background-color:green;width:100%;text-align:center">Lts2gthr's Suggestion Box</h2>
	<p>You can suggest on following topics by including the corresponding has tag or on anything you want.<br/>
	You can also tag some people simple by prepending @ before their name.</p> 
	
<div  id="issuesDiv">
<ul>
<?php
foreach( $issues as $iss) {
echo <<< ISSUE_ROW
			<li><b>#$iss->hashtag</b> : $iss->description</li>
ISSUE_ROW;
}
?>	
</ul>

</div>	
	<p>
	Example: <i>"The <b>#kitchen</b> is badly managed while the cook<b> @ramesh</b> is a hard working man."</i>
	</p>
	<div id="sgBox">
		<form method="POST" action="#" name="sgForm" onsubmit="return validateSug()">
		<textarea name="suggestion" id="sgTextArea">
		</textarea><br/>
		<div id="postBtnDiv">
		<input type="submit" name="submit" value="Ok, Suggest" id="postButton" />
		</div>
		</form>
	</div>	
	<!-- You can also tag some people here by writing their name after @ -->	
</div>
</body>
</html>

