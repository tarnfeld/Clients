<?php

	/*
	
		Copyright "Clients" 2010
		Made by Tom Arnfeld :)
		http://tarnfeldweb.com/
		twitter.com/tarnfeld
		
		If you have any feauture requests, pop along to tarnfeld@me.com :P
		Thanks!
	
	*/

	error_reporting(0);
	session_start();

	global $_ERROR;

	$_ERROR = array();
	$installed = false;
	
	if($_POST)
	{
		$num = 0;
		foreach($_POST as $key=>$value)
		{
			if(strlen(str_replace(" ","",$value))<=0 && $key!='db_pass')
			{
				$_ERROR[$key] = 'class="error"';
				$num ++;
			}
		}
		if($num>0)
		{
			$_ERROR['text'] = 'Please fill in all fields';
		}
		else
		{
			// Create Database
			$con = mysql_connect($_POST['db_server'],$_POST['db_user'],$_POST['db_pass']);
			if (!$con) {
			    $_ERROR['text'] = 'There was an error connecting to your database';
			}
			else
			{
				$db = mysql_select_db($_POST['db_name'],$con);
				if(!$db)
				{
					$_ERROR['text'] = 'Could not select database';
				}
				else
				{
					
					foreach($_POST as $key=>$value)
					{
						$_POST[$key] = mysql_real_escape_string($value,$con);
					}
				
					$sql = 'CREATE TABLE `clients` (
			   				  `id` int(11) NOT NULL AUTO_INCREMENT,
			   				  `clientname` varchar(255) DEFAULT NULL,
								  PRIMARY KEY (`id`)
			   				)';
			   		mysql_query($sql,$con) or die(mysql_error());
			   		$sql = 'CREATE TABLE `clocks` (
			   				  `id` int(11) NOT NULL AUTO_INCREMENT,
			   				  `projid` int(11) DEFAULT NULL,
			   				  `staffid` int(11) DEFAULT NULL,
			   				  `clientid` int(11) DEFAULT NULL,
			   				  `desc` longtext,
			   				  `hours` varchar(255) DEFAULT NULL,
			   				  `date` int(11) DEFAULT NULL,
			   				  PRIMARY KEY (`id`)
			   				)';
			   		mysql_query($sql,$con) or die(mysql_error());
			   		$sql = 'CREATE TABLE `config` (
			   				  `id` int(11) NOT NULL AUTO_INCREMENT,
			   				  `key` varchar(255) DEFAULT NULL,
			   				  `value` longtext,
			   				  PRIMARY KEY (`id`)
			   				);';
			   		mysql_query($sql,$con) or die(mysql_error());
			   		$sql = 'CREATE TABLE `projects` (
			   				  `id` int(11) NOT NULL AUTO_INCREMENT,
			   				  `clientid` int(11) DEFAULT NULL,
			   				  `projectname` varchar(255) DEFAULT NULL,
			   				  `projectdesc` longtext,
			   				  PRIMARY KEY (`id`)
			   				)';
			   		mysql_query($sql,$con) or die(mysql_error());
			   		$sql = 'CREATE TABLE `staff` (
			   				  `id` int(11) NOT NULL AUTO_INCREMENT,
			   				  `email` varchar(255) DEFAULT NULL,
			   				  `password` varchar(255) DEFAULT NULL,
			   				  `name` varchar(255) DEFAULT NULL,
			   				  `active` int(11) DEFAULT NULL,
			   				  `type` varchar(255) DEFAULT NULL,
			   				  PRIMARY KEY (`id`)
			   				)';
			   		mysql_query($sql,$con) or die(mysql_error());
			   		$sql = 'CREATE TABLE `temp_clocks` (
			   				  `id` int(11) DEFAULT NULL,
			   				  `projid` int(11) DEFAULT NULL,
			   				  `staffid` int(11) DEFAULT NULL,
			   				  `clientid` int(11) DEFAULT NULL,
			   				  `desc` longtext,
			   				  `timestamp` int(11) DEFAULT NULL
			   				)';
			   		mysql_query($sql,$con) or die(mysql_error());
			   		$sql = "INSERT INTO `config` VALUES('0','company','$_POST[company]')";
			   		mysql_query($sql,$con) or die(mysql_error());
			   		$sql = "INSERT INTO `config` VALUES('0','siteurl','$_POST[siteurl]')";
			   		mysql_query($sql,$con) or die(mysql_error());
			   		$sql = "INSERT INTO `config` VALUES('0','roundtype','up')";
			   		mysql_query($sql,$con) or die(mysql_error());
					$sql = "INSERT INTO `config` VALUES('0','roundnearest','1')";
			   		mysql_query($sql,$con) or die(mysql_error());
			   		$pass = md5($_POST['password']);
			   		$sql = "INSERT INTO `staff` VALUES('0','$_POST[email]','$pass','$_POST[name]','1','admin')";
			   		mysql_query($sql,$con) or die(mysql_error());
			   		
			   		
			   		$file = fopen("db.php","r");
					$data = fread($file, 500000);
					fclose($file);
					
					$data = str_replace('define("INSTALLED",FALSE);','define("INSTALLED",TRUE);',$data);
					$data = str_replace('HOST',$_POST['db_server'],$data);
					$data = str_replace('USER',$_POST['db_user'],$data);
					$data = str_replace('PASSWORD',$_POST['db_pass'],$data);
					$data = str_replace('DBNAME',$_POST['db_name'],$data);
					
					$file = fopen("db.php","w");
					fwrite($file, $data, 500000);
					fclose($file);
					
					header("Location: ../login.php");
				}
			}
		}
	}
	
	$_POST['siteurl'] = str_replace("/includes/install.php","","http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Install Clients</title>
		<link rel="stylesheet" href="css/style.css">
		<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="js/jquery.rotate.js"></script>
		<script type="text/javascript" src="js/content.js"></script>
	</head>
	<body>
	<div id="loginbox" class="install">
		<h1>Install Clients</h1>
		<div class="content">
			<? if($insatlled): ?>
				Installed
			<? else: ?>
			<p>Please make sure the file <b>includes/db.php</b> has <b>777</b> privileges.</p>
			<hr />
			<h2><span class="error"><?=$_ERROR['text']?></span></h2>
			<form method="post" action="install.php">
				<h2>Database Configuration</h2>
				<p>Please enter your MySQL database details.</p>
				<input <?=$_ERROR['db_server']?> placeholder="Server" value="<?=$_POST['db_server']?>" type="text" name="db_server" />
				<input <?=$_ERROR['db_user']?> placeholder="Username" value="<?=$_POST['db_user']?>" type="text" name="db_user" />
				<input <?=$_ERROR['db_pass']?> placeholder="Password" value="<?=$_POST['db_pass']?>" type="text" name="db_pass" />
				<input <?=$_ERROR['db_name']?> placeholder="Database Name" value="<?=$_POST['db_name']?>" type="text" name="db_name" />
				<h2>Clients Configuration</h2>
				<p>Please enter settings for the application.</p>
				<input <?=$_ERROR['company']?> placeholder="Company Name" value="<?=$_POST['company']?>" type="text" name="company" />
				<input <?=$_ERROR['siteurl']?> placeholder="Site URL" value="<?=$_POST['siteurl']?>" type="text" name="siteurl" />
				<h2>Create a member of staff</h2>
				<p>Please create your first member of staff.</p>
				<input <?=$_ERROR['name']?> placeholder="Name" value="<?=$_POST['name']?>" type="text" name="name" />
				<input <?=$_ERROR['email']?> placeholder="Email" value="<?=$_POST['email']?>" type="text" name="email" />
				<input <?=$_ERROR['password']?> placeholder="Password" value="<?=$_POST['password']?>" type="password" name="password" />
				<button type="submit">Install</button>
			</form>
			<? endif; ?>
		</div>
	</div>
<? include('footer.php'); ?>