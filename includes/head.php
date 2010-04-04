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
	
	$pos = strpos($_SERVER['HTTP_USER_AGENT'],"Gecko");
	if($pos)
	{
		$csshacks = '
					<style>
						#wrap ul.list li {
							background: -moz-linear-gradient(top, #f2f2f2, #e2e2e2)!important;
						}
					</style>
					';
	}
	
	$pos = strpos($_SERVER['HTTP_USER_AGENT'],"Webkit");
	if(!$pos)
	{
		$csshacks = ' <script type="text/javascript" src="'.$_CONFIG['siteurl'].'/includes/js/placeholder.js"></script> ';
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
		<?=$csshacks?>
	</head>
	<body>