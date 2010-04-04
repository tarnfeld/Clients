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
				$length = 9;
				$strength = 2;
				$vowels = 'aeuy';
				$consonants = 'bdghjmnpqrstvz';
				if ($strength & 1) {
					$consonants .= 'BDGHJLMNPQRSTVWXZ';
				}
				if ($strength & 2) {
					$vowels .= "AEUY";
				}
				if ($strength & 4) {
					$consonants .= '23456789';
				}
				if ($strength & 8) {
					$consonants .= '@#$%';
				}
			 
				$password = '';
				$alt = time() % 2;
				for ($i = 0; $i < $length; $i++) {
					if ($alt == 1) {
						$password .= $consonants[(rand() % strlen($consonants))];
						$alt = 0;
					} else {
						$password .= $vowels[(rand() % strlen($vowels))];
						$alt = 1;
					}
				}
				$rawpwd = $password;
				$password = md5($password);
				$sql = "UPDATE `staff` SET `password`='$password' WHERE `email`='$_POST[email]'";
				mysql_query($sql,$mysql);
				$headers  = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
				$headers .= "From: $_CONFIG[company] <noreply@passwordreset.com>";

				$to = $_POST['email'];
				$subject = "Your new password";
				$body = "<p><b>$data[name]</b></p>
				<p>Your password has been reset, please login with the following password: <b>$rawpwd</b></p>
				<p>Thanks,<br>$_CONFIG[company]</p>";
				mail($to,$subject,$body,$headers);
				header("Location: login.php");
			}
			else
			{
				$_ERROR['text'] = 'Invalid Email';
				$_ERROR['email'] = 'class="error"';
			}	
		}
	}
	
	$_TAG['title'] = $_CONFIG['company'].' | Reset Password';
	$_TAG['file'] = 'login.php';
	include('includes/head.php');

?>
<div id="loginbox" class="reset">
	<h1><?=$_CONFIG['company']?></h1>
	<div class="content">
		<h2>Reset Password <span class="error"><?=$_ERROR['text']?></span></h2>
		<form method="post" action="forgot.php">
			<input <?=$_ERROR['email']?> placeholder="Email Address" value="<?=$_POST['email']?>" type="text" name="email" />
			<button type="submit">Reset</button>
		</form>
	</div>
</div>
<? include('includes/footer.php'); ?>