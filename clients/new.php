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
			$_ERROR['text'] = 'Please enter a name';
		}
		else
		{
			$sql = "INSERT INTO `clients` VALUES('0','$_POST[name]')";
			mysql_query($sql,$mysql);
			header("Location: ../index.php");
		}
	}
	
	$_TAG['title'] = $_CONFIG['company']." | New Client";
	include('../includes/head.php');

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
		<h2>New Client <span class="error"><?=$_ERROR['text']?></span></h2>
		<p>Please give your client a name.</p>
		<form method="post" action="new.php">
			<input class="focusFirst <?=$_ERROR['name']?>" placeholder="Client Name" value="<?=$_POST['name']?>" type="text" name="name" />
			<br />
			<button type="submit">Save</button>
		</form>
	</div>
</div>
<? include('includes/footer.php'); ?>