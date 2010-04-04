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
			$sql = "SELECT * FROM `staff` WHERE email='$_POST[email]' AND `active`='1'";
			$result = mysql_query($sql,$mysql);
			$num = mysql_num_rows($result);
			if($num>0)
			{
				$data = mysql_fetch_assoc($result);
				$_SESSION['user']['loggedin'] = true;
				$_SESSION['user']['id'] = $data['id'];
				$_SESSION['user']['name'] = $data['name'];
				header("Location: index.php");
			}
			else
			{
				$_ERROR['text'] = 'Invalid Credentials';
				$_ERROR['email'] = 'class="error"';
				$_ERROR['password'] = 'class="error"';
			}	
		}
	}
	
	$_TAG['title'] = $_CONFIG['company'].' | Login';
	$_TAG['file'] = 'login.php';
	include('includes/head.php');

?>
<div id="loginbox">
	<h1><?=$_CONFIG['company']?></h1>
	<div class="content">
		<h2>Login <span class="error"><?=$_ERROR['text']?></span></h2>
		<form method="post" action="login.php">
			<input <?=$_ERROR['email']?> placeholder="Email" value="<?=$_POST['email']?>" type="text" name="email" />
			<input <?=$_ERROR['password']?> placeholder="Password" value="<?=$_POST['password']?>" type="password" name="password" />
			<button type="submit">Login</button>
			<a href="forgot.php"><button style="float:right;" type="button">Forgot</button></a>
		</form>
	</div>
</div>
<? include('includes/footer.php'); ?>