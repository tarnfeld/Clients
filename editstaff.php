<?php

	/*
	
		Copyright "Clients" 2010
		Made by Tom Arnfeld :)
		http://tarnfeldweb.com/
		twitter.com/tarnfeld
		
		If you have any feauture requests, pop along to tarnfeld@me.com :P
		Thanks!
	
	*/

	include('includes/db.php');
	$_ERROR = array();
	
	if(!$_GET)
	{
		header("Location: index.php");
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
			$pass = md5($_POST['password']);
			$id = $_GET['id'];
			$sql = "UPDATE `staff` SET `email`='$_POST[email]', `password`='$pass', `name`='$_POST[name]', `type`='$_POST[role]' WHERE `id`='$id'";
			mysql_query($sql,$mysql) or die(mysql_error());
			header("Location: settings.php");
		}
	}
	
	$_TAG['title'] = $_CONFIG['company']." | Edit Staff";
	include('includes/head.php');
	
	$sql = "SELECT * FROM `staff` WHERE `id`='$_GET[id]'";
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
		<h2>Edit <span class="lighter"><?=$data['name']?></span> <span class="error"><?=$_ERROR['text']?></span></h2>
		<form method="post" action="editstaff.php?id=<?=$data['id']?>">
			<input class="focusFirst <?=$_ERROR['name']?>" placeholder="Name" value="<?=$data['name']?>" type="text" name="name" />
			<br />
			<input class="focusFirst <?=$_ERROR['email']?>" placeholder="Email Address" value="<?=$data['email']?>" type="text" name="email" />
			<br />
			<input class="focusFirst <?=$_ERROR['password']?>" placeholder="Password" value="<?=$data['email']?>" type="password" name="password" />
			<br />
			<select name="role">
				<option <? if($data['role']=='admin'):?>selected="selected"<? endif; ?> value="admin">Admin</option>
				<option <? if($data['role']=='general'):?>selected="selected"<? endif; ?> value="general">General</option>
			</select>
			<span class="lighter">This is for an upcoming feature, in the next few days.</span>
			<br /><br />
			<button type="submit">Update</button>
		</form>
	</div>
</div>
<? include('includes/footer.php'); ?>