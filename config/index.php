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
			$cfg->write_conf($confs,$_POST['adminName'],$_POST['adminPass']);
			$_POST['submit']='done';
	}	
	
	$config = new Conf();
	$dbname=$config->dbname;
	$dbuname=$config->dbuname;
	
	if($config->isConfigured){
		echo "Already configured. <br/>
		Please contact sysadmin.<br/>";
		exit();	
	}

?>

<script type="text/javascript">
function validateForm() {
   var dbName = document.forms["configForm"]["dbname"].value;
   var dbUname = document.forms["configForm"]["dbusername"].value;
   var dbPass = document.forms["configForm"]["dbpass"].value;
   var adminName = document.forms["configForm"]["adminName"].value;
   var adminPass = document.forms["configForm"]["adminPass"].value;
   var adminRePass = document.forms["configForm"]["adminRePass"].value;
   var msg="";
   if(dbName.trim().length==0 || dbUname.trim().length==0 || dbPass.trim().length==0){
		msg = "Database name, Database username and Database password are Essential and need to be correct.";   
   } else if(adminName.trim().length==0){
		msg = "Admin Name is required.";   
   } else if(adminPass.trim().length==0){
		msg = "Admin Pass is required.";   
   } else if(adminPass != adminRePass){
		msg = "admin password and conformation entry of password mismatched.";   
   }
   
   if(msg.length > 0){
   alert(msg);
   return false;
	}
    return true;
}
</script>
<link rel="stylesheet" type="text/css" href="../style/style.css">
</head>
<body>
<h2>Configure your sg page</h2>
Once you configure this, you will get no change to change database credentials from here.<br/></br>
<?php
echo <<< FORMBODY
	<div id="configDiv">
	<form action="#" method="POST" name="configForm" onsubmit="return validateForm()">
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
	<td>Admin uName:</td>
	<td><input type="text" name="adminName" ></td>
	</tr>
	
	<tr>
	<td>Admin Pass:</td>
	<td><input type="password" name="adminPass" value="*******"></td>
	</tr>
	<tr>
	<td>Admin Pass again:</td>
	<td><input type="password" name="adminRePass" value="*******"></td>
	</tr>	
	<tr>
	<td><input type="submit" name="submit" values="Save"/></td>

	</tr>
	</table>
	</form>
	</div>
FORMBODY;

?>
</body>
</html>