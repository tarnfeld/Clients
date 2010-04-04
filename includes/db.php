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
	
	define("INSTALLED",FALSE);
	
	if(!INSTALLED && $_TAG['file']!='install.php')
	{
		header("Location: includes/install.php");
	}
	
	$mysql = mysql_connect('HOST','USER','PASSWORD');
	mysql_select_db('DBNAME',$mysql);

	$sql = mysql_query("SELECT * FROM `config`",$mysql) or die(mysql_error());
	while($data = mysql_fetch_assoc($sql))
	{
		$_CONFIG[$data['key']] = $data['value'];
	}

?>