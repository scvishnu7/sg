<html>
<head>
<title>Suggestion Admin Panel</title>

<?php
	include('dbMgmt.php');
	
	$db = new dbManager();
	$suggestions = array();
	$db->init_db();
	$suggestions = $db->getAllSuggestion();
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

table {
	width:100%;
	margin:auto;
}

table, th, td {
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
<table  >
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

