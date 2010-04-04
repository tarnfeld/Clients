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
			$_ERROR['text'] = 'Please fill in all staff details';
		}
		else
		{
			$pass = md5($_POST['password']);
			$sql = "INSERT INTO `staff` VALUES('0','$_POST[email]','$pass','$_POST[name]','1','$_POST[role]')";
			mysql_query($sql,$mysql);
			header("Location: settings.php");
		}
	}
	
	$_TAG['title'] = $_CONFIG['company']." | New Staff";
	include('includes/head.php');

?>
<div id="wrap">
	<div id="header">
		<h1><a href="<?=$_CONFIG['siteurl']?>"><?=$_CONFIG['company']?> <span class="lighter">Logged in as <?=$_SESSION['user']['name']?></span></a></h1>
		<ul id="nav">
			<li>
				<a href="settings.php">Settings</a>
			</li>
			<li>
				<a href="logout.php">Logout</a>
			</li>
		</ul>
		<br style="clear:both" />
	</div>
	<div class="large">
		<h2>New Staff <span class="error"><?=$_ERROR['text']?></span></h2>
		<p>Please fill in these details for the staff member.</p>
		<form method="post" action="newstaff.php">
			<input class="focusFirst <?=$_ERROR['name']?>" placeholder="Name" value="<?=$_POST['name']?>" type="text" name="name" />
			<br />
			<input class="focusFirst <?=$_ERROR['email']?>" placeholder="Email Address" value="<?=$_POST['email']?>" type="text" name="email" />
			<span class="lighter">&nbsp;&nbsp;This is their login too</span>
			<br />
			<input class="focusFirst <?=$_ERROR['password']?>" placeholder="Password" value="<?=$_POST['email']?>" type="password" name="password" />
			<br />
			<select name="role">
				<option <? if($_POST['role']=='admin'):?>selected="selected"<? endif; ?> value="admin">Admin</option>
				<option <? if($_POST['role']=='general'):?>selected="selected"<? endif; ?> value="general">General</option>
			</select>
			<span class="lighter">This is for an upcoming feature, in the next few days.</span>
			<br /><br />
			<button type="submit">Save</button>
		</form>
	</div>
</div>
<? include('includes/footer.php'); ?>