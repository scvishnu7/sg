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
public function createTables($adminName,$adminPass){
		
	$dbh = mysql_connect(Conf::$conf_host, $this->dbuname, $this->dbpass)or die("cannot connect"); //Store data connection specifier in object
    mysql_select_db($this->dbname)or die("cannot select DB");
    
	$qDrop_sg_table="drop table if exists sg_body";
	$qMake_sg_table="create table sg_body(sg_id int primary key auto_increment, time varchar(30),suggestion blob) ENGINE=INNODB";	
	$qInsTestData="insert into sg_body values(null,\"abc\",\"suggestion1\")";
	
	$qDrop_userTable="drop table if exists sg_user";
	$qMake_userTable="create table sg_user(username varchar(20) not null primary key, password varchar(100)) ENGINE=INNODB";
	$qMake_admin="insert into sg_user values(\"".$adminName."\",password(\"".$adminPass."\"))";
//you can change it later from the admin console

	$dDrop_issuesTable ="drop table if exists sg_issues";
	$qMake_issuesTable="CREATE TABLE sg_issues (is_id int auto_increment not null primary key, hashtag varchar(100), description blob) ENGINE=INNODB";
	
	//every new tag will go here with itagId	
	$dDrop_itagTable = "drop table if exists sg_itags";
	$qMake_itagTable = "create table sg_itags (itag_id int auto_increment not null primary key, hashtag varchar(100),created_date varchar(30)) ENGINE=INNODB";
	
		
	//every new person will go here with ptagId
	$dDrop_ptagTable = "drop table if exists sg_ptags";
	$qMake_ptagTable = "create table sg_ptags (ptag_id int auto_increment not null primary key, tname varchar(100),created_date varchar(30)) ENGINE=INNODB";
		
	//relation of itag and sg_body	
	/*
	create table sg_itag_sg(id int auto_increment not null primary key,itag_id int(11),sg_id int(11), foreign key (itag_id) references sg_itags(id), foreign key (sg_id)  references sg_sgbody(id)) ENGINE=INNODB;
	*/
	$dDrop_itag_sgTable = "drop table if exists sg_itag_body";
	$qMake_itag_sgTable = "	create table sg_itag_body(isg_id int auto_increment not null primary key,itag_id int,sg_id int, foreign key (itag_id) references sg_itags(itag_id), foreign key (sg_id)  references sg_body(sg_id)) ENGINE=INNODB";
	
	//relation of ptag and sg_body
	$dDrop_ptag_sgTable = "drop table if exists sg_ptag_body";
	$qMake_ptag_sgTable = "	create table sg_ptag_body(psg_id int auto_increment not null primary key,ptag_id int,sg_id int, foreign key (ptag_id) references sg_ptags(ptag_id), foreign key (sg_id)  references sg_body(sg_id)) ENGINE=INNODB";
	
	
	mysql_query($qDrop_sg_table, $dbh);
	mysql_query($qMake_sg_table, $dbh);
	mysql_query($qInsTestData, $dbh);
	
	mysql_query($qDrop_userTable);
	mysql_query($qMake_userTable);
	mysql_query($qMake_admin);
	
	mysql_query($dDrop_issuesTable);
	mysql_query($qMake_issuesTable);
	
	mysql_query($dDrop_itagTable);
	mysql_query($qMake_itagTable);
	
	
	mysql_query($dDrop_ptagTable);
	mysql_query($qMake_ptagTable);
	
	mysql_query($dDrop_itag_sgTable);
	mysql_query($qMake_itag_sgTable);
	
	
	mysql_query($dDrop_ptag_sgTable);
	mysql_query($qMake_ptag_sgTable);
		
	echo "Done";
}	
}
?>