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

	if(!$_SESSION['user']['loggedin'] && $_TAG['file']!='login.php')
	{
		header("Location: $_CONFIG[siteurl]/login.php");
	}
	elseif($_SESSION['user']['loggedin'] && $_TAG['file']=='login.php')
	{
		header("Location: index.php");
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<title><?=$_TAG['title']?></title>
		<link rel="stylesheet" href="<?=$_CONFIG['siteurl']?>/includes/css/style.css">
		<script type="text/javascript" src="<?=$_CONFIG['siteurl']?>/includes/js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="<?=$_CONFIG['siteurl']?>/includes/js/jquery.rotate.js"></script>
		<script type="text/javascript" src="<?=$_CONFIG['siteurl']?>/includes/js/content.js"></script>
	</head>
	<body>