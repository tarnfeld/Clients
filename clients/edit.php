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
	
	if($_POST)
	{
		$num = 0;
		foreach($_POST as $key=>$value)
		{
			if(strlen(str_replace(" ","",$value))<=0)
			{
				$_ERROR[$key] = 'error';
				$num ++;
			}
		}
		if($num>0)
		{
			$_ERROR['text'] = 'Please enter new name';
		}
		else
		{
			$sql = "UPDATE `clients` SET `clientname`='$_POST[name]' WHERE `id`='$_GET[id]'";
			mysql_query($sql,$mysql);
			header("Location: ../index.php");
		}
	}
	
	$_TAG['title'] = $_CONFIG['company']." | Edit Client";
	include('../includes/head.php');
	
	$sql = "SELECT * FROM `clients` WHERE `id`='$_GET[id]'";
	$data = mysql_fetch_assoc(mysql_query($sql));

?>
<div id="wrap">
	<div id="header">
		<h1><a href="<?=$_CONFIG['siteurl']?>"><?=$_CONFIG['company']?> <span class="lighter">Logged in as <?=$_SESSION['user']['name']?></span></a></h1>
		<ul id="nav">
			<li>
				<a href="../settings.php">Settings</a>
			</li>
			<li>
				<a href="../logout.php">Logout</a>
			</li>
		</ul>
		<br style="clear:both" />
	</div>
	<div class="large">
		<h2>Edit <span class="lighter"><?=$data['clientname']?></span> <span class="error"><?=$_ERROR['text']?></span></h2>
		<form method="post" action="edit.php?id=<?=$_GET['id']?>">
			<input class="focusFirst <?=$_ERROR['name']?>" value="<?=$data['clientname']?>" type="text" name="name" />
			<br />
			<button type="submit">Update</button>
		</form>
	</div>
</div>
<? include('includes/footer.php'); ?>