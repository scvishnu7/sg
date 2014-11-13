<html>
<head>
<?php
	include('conf.php');
	//fetch all var and initialize fields accordingly

	
	
	if(isset($_POST['submit'])){
		$confs= array();
		$confs[Conf::$key_dbname]=$_POST['dbname'];
		$confs[Conf::$key_dbuname]=$_POST['dbusername'];
		$confs[Conf::$key_dbpass]=$_POST['dbpass'];
			$cfg = new Conf();
			$cfg->write_conf($confs);
			$_POST['submit']='done';
	}	
	
	$config = new Conf();
	$dbname=$config->dbname;
	$dbuname=$config->dbuname;

	
	if(isset($_POST['createTable'])){
			echo "trying";
			$config = new Conf();
			$config->createTables();	
	}
?>

</head>
<body>
<?php
echo <<< FORMBODY

	<form action="#" method="POST">
	<table>
	<tr>
	<td>DB Name:</td>
	<td><input type="text" name="dbname" value="$dbname" ><br/></td>
	</tr>
	
	<tr>
	<td>DB Username:</td>
	<td> <input type="text" name="dbusername" value="$dbuname" ><br/>	</td>
	</tr>
	
	<tr>
	<td>DB Password:</td>
	<td> <input type="password" name="dbpass" value="*******"><br/></td></tr>
	
	<tr>
	<td><input type="submit" name="submit" values="Save"/></td>
	<td><input type="submit" name="createTable" value="Create Tables"/></td>
	</tr>
	</table>
	</form>
FORMBODY;

?>
</body>
</html>