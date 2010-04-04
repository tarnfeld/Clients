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
			if(strlen(str_replace(" ","",$value))<=0 && $key!='desc')
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
			$client = $_GET['client'];
			$sql = "INSERT INTO `projects` VALUES('0','$client','$_POST[name]','$_POST[desc]')";
			mysql_query($sql,$mysql) or die(mysql_error());
			header("Location: projects.php?id=$client");
		}
	}
	
	$_TAG['title'] = $_CONFIG['company']." | New Project";
	include('../includes/head.php');
	
	$sql = "SELECT * FROM `clients` WHERE `id`='$_GET[client]'";
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
		<h2>New Project <span class="lighter"><?=$data['clientname']?></span> <span class="error"><?=$_ERROR['text']?></span></h2>
		<p>Please give your project a name.</p>
		<form method="post" action="newproject.php?client=<?=$_GET['client']?>">
			<input class="<?=$_ERROR['name']?>" placeholder="Project Name" value="<?=$_POST['name']?>" type="text" name="name" />
			<br />
			<input class="<?=$_ERROR['desc']?>" placeholder="Quick Description" value="<?=$_POST['desc']?>" type="text" name="desc" />
			<br />
			<button type="submit">Save</button>
		</form>
	</div>
</div>
<? include('includes/footer.php'); ?>