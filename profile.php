<?php
	session_start();
	include('dbMgmt.php');
		
	if(isset($_SESSION['user'])){
		$isLogined = true;
		$loginedUser = $_SESSION['user'];
	} else {
		$isLogined= false;
	}

	if(isset($_POST['changepass'])){
			$db = new DbManager();
			$db->changePass($loginedUser,$_POST['adminName'],
			$_POST['currentPass'], $_POST['newPass']);
			echo "Done";
	}
	

?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="style/style.css">
<script type="text/javascript">

function validateForm() {
   var adminName = document.forms["myForm"]["adminName"].value;
   var curPass = document.forms["myForm"]["currentPass"].value;
   var newPass = document.forms["myForm"]["newPass"].value;
   var reNewPass = document.forms["myForm"]["reNewPass"].value;
   var msg="";
   if(adminName.trim().length==0){
		msg = "Admin name can't be empty.";   
   } else if(curPass.trim().length==0){
		msg = "Please provide current password.";   
   } else if(newPass.trim().length==0){
		msg = "New Password can't be empty.";   
   } else if(newPass != reNewPass){
		msg = "New pass and re-new password mismatch.";   
   }
   
   if(msg.length > 0){
   alert(msg);
   return false;
	}
    return true;
    
    //email validator.  
//    var atpos = x.indexOf("@");
//    var dotpos = x.lastIndexOf(".");
//    if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=x.length) {
//        alert("Not a valid e-mail address");
//       return false;
//    }
}

</script>

</head>

<body>
<h2>Profile page</h2>

<?php
if($isLogined){
		//show edit profile page
echo <<< CHANGE_PASS
	<div id="profileDiv">
		<form target="#" method="POST" name="myForm" onsubmit="return validateForm()">
		<table>
			<tr> 
				<td>Admin Name: </td>
				<td><input type="text" name="adminName" value="$loginedUser" > </td>			
			</tr>		
		
			<tr> 
				<td>Current Password: </td>
				<td><input type="password" name="currentPass"> </td>			
			<tr>
			
			<tr> 
				<td>New Password: </td>
				<td><input type="password" name="newPass"> </td>			
			<tr>
			
			<tr> 
				<td>New Password Again:</td>
				<td><input type="password" name="reNewPass"> </td>			
			<tr>
			
			<tr> 
				<td><input type="submit" name="changepass"> </td>			
			<tr>
		</table>
		</form>
		</div>
CHANGE_PASS;
		
} else {
	//show login page
	echo "<a href=\"admin.php\">Click here to login.</a>";
}
?>
</body>
</html>