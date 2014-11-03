<html>
<head>
<title>Suggestion Box</title>
<?php
	include('postSuggestion.php');
	$suggestion = $_POST['suggestion'];
	if(strlen(trim($suggestion))>0){
		if(save_suggestion($suggestion)){
			echo " suggestion Saved ";
		}
	}
	
?>

<style type="text/css">
	body {
		width:600px;
		height:100%;
		padding:0px;
		margin:auto;
		background-color: gray;
	}
	
	#sgBox {
		margin:auto;
		padding:10px;
	}
	#container {
		//height:100%;
		//width:50%;
		//margin:auto;
		border-style: solid;
		border-width: medium;
		border-color: red;
		//border: 15px solid red;
		//border-top: 20px solid green;
		padding:5px;
	}
	#sgTextArea {
		width:560px;
		height:200px;
		margin:auto;
		padding:5px;
		position:relative;
		background-color:white;		
	}
	#postBtnDiv {
		width:40%;
		margin-left:auto;
		margin-right:auto;
	}
	#postButton {
		height:50px;
		width:100%;
		margin-left:auto;
		margin-right:auto;
		margin-top:10px;
		font-size:20;
	}
</style>
</head>

<body>
<div id="container">
	<h2 style="background-color:green;width:100%;text-align:center">Vishnu's Suggestion Box</h2>
	<p>You can suggest on following topics by including the corresponding has tag or on anything you want.<br/>
	You can also tag some people simple by prepending @ before their name.</p> 
	<p>
	Example: <i>"The <b>#kitchen</b> is badly managed while the cook<b> @ramesh</b> is a hard working man."</i>
	</p>
	<ul>
	<li>#hairstyle	: Do you like my hair style?</li>
	<li>#attitude	: What about my attitude?</li>
	</ul>
	<div id="sgBox">
		<form method="POST" action="#">
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

