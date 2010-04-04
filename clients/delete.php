<?php

	/*
	
		Copyright "Clients" 2010
		Made by Tom Arnfeld :)
		http://tarnfeldweb.com/
		twitter.com/tarnfeld
		
		If you have any feauture requests, pop along to tarnfeld@me.com :P
		Thanks!
	
	*/

	include('../includes/db.php');
	$_ERROR = array();
	
	if(!$_GET)
	{
		header("Location: ../index.php");
	}
	else
	{
		if($_GET['type']=='client')
		{
			$id = $_GET['id'];
			$sql = "DELETE FROM `clients` WHERE `id`='$id'";
			mysql_query($sql,$mysql);
			$sql = "DELETE FROM `projects` WHERE `clientid`='$id'";
			mysql_query($sql,$mysql);
			$sql = "DELETE FROM `clocks` WHERE `clientid`='$id'";
			mysql_query($sql,$mysql);
		}
		elseif($_GET['type']=='project')
		{
			$id = $_GET['id'];
			$client = $_GET['client'];
			$sql = "DELETE FROM `projects` WHERE `id`='$id'";
			mysql_query($sql,$mysql);
			$sql = "DELETE FROM `clocks` WHERE `clientid`='$client'";
			mysql_query($sql,$mysql);
		}
		elseif($_GET['type']=='clockin')
		{
			$id = $_GET['id'];
			$sql = "SELECT * FROM `clocks` WHERE `id`='$id'";
			$data = mysql_fetch_assoc(mysql_query($sql,$mysql));
			$sql = "DELETE FROM `clocks` WHERE `id`='$id'";
			mysql_query($sql,$mysql);
			$proj = $data['projid'];
		}
		elseif($_GET['type']=='staff')
		{
			$id = $_GET['id'];
			$sql = "UPDATE `staff` SET `active`='0' WHERE `id`='$id'";
			mysql_query($sql,$mysql);
		}
		elseif($_GET['type']=='staffperm')
		{
			$id = $_GET['id'];
			$sql = "DELETE FROM `staff` WHERE `id`='$id'";
			mysql_query($sql,$mysql);
			$sql = "DELETE FROM `clocks` WHERE `staffid`='$id'";
			mysql_query($sql,$mysql);
			$sql = "DELETE FROM `temp_clocks` WHERE `id`='$id'";
			mysql_query($sql,$mysql);
		}
		elseif($_GET['type']=='staffrestore')
		{
			$id = $_GET['id'];
			$sql = "UPDATE `staff` SET `active`='1' WHERE `id`='$id'";
			mysql_query($sql,$mysql);
		}
	}

?>