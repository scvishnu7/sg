<?php
class Conf{
	public static $conf_host="localhost";
	public static $conf_fname="config.dat";
	public static $key_dbname="database_name";
	public static $key_dbuname="database_username";
	public static $key_dbpass="database_password";
	
	var $dbname;
	var $dbuname;
	var $dbpass;
	
	function __construct(){
		$confs= array();
		$confs = $this->read_conf();
		$this->dbname=$confs->{Conf::$key_dbname};
		$this->dbuname = $confs->{Conf::$key_dbuname};
		$this->dbpass = $confs->{Conf::$key_dbpass};

	}
	
	public function read_conf(){
		$confs = array();
		$file_content = file_get_contents("http://sg.localhost/config/".Conf::$conf_fname);
		$confs = json_decode($file_content);

		return $confs;
	}
	
	public function write_conf($confs){
		$str = json_encode($confs);
		file_put_contents(Conf::$conf_fname, $str);
	}

		//Create tables
public function createTables(){
		
	$dbh = mysql_connect(Conf::$conf_host, $this->dbuname, $this->dbpass)or die("cannot connect"); //Store data connection specifier in object
    mysql_select_db($this->dbname)or die("cannot select DB");
    
	$qDrop_sg_table="drop table if exists sg_body";
	$qMake_sg_table="create table sg_body(id int primary key auto_increment, time varchar(30),suggestion blob)";	
	$qInsTestData="insert into sg_body values(null,\"abc\",\"suggestion1\")";
	
	$qMake_userTable="create table sg_user(username varchar(20) primary key, password varchar(100))";
	$qMake_defaultAdmin="insert into sg_user values(\"admin\",password(\"sgadmin\"))";
//you can change it later from the admin console

	//create issues table
	
	//create personTagged table
	
	mysql_query($qDrop_sg_table, $dbh);
	mysql_query($qMake_sg_table, $dbh);
	mysql_query($qInsTestData, $dbh);
	
	mysql_query($qMake_userTable);
	mysql_query($qMake_defaultAdmin);
		
	echo "Done";
}	
}
?>