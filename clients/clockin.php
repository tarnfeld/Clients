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
			$_ERROR['text'] = 'Please enter some hours';
		}
		else
		{
			$project = $_GET['project'];
			$staffid = $_SESSION['user']['id'];
			$sql = "SELECT * FROM `projects` WHERE `id`='$project'";
			$res = mysql_fetch_assoc(mysql_query($sql,$mysql));
			$clientid = $res['clientid'];
			$date = time();
			$sql = "INSERT INTO `clocks` VALUES('0','$project','$staffid','$clientid','$_POST[desc]','$_POST[hours]','$date')";
			mysql_query($sql,$mysql) or die(mysql_error());
			header("Location: project.php?id=$project");
		}
	}
	
	$sql = "SELECT * FROM `projects` WHERE `id`='$_GET[project]'";
	$data = mysql_fetch_assoc(mysql_query($sql));
	
	$_TAG['title'] = $_CONFIG['company']." | Clock into ".$data['projectname'];
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
		<h2>Clock in <span class="lighter"><?=$data['projectname']?></span> <span class="error"><?=$_ERROR['text']?></span></h2>
		<p>Please enter the hours worked on this project.</p>
		<form method="post" action="clockin.php?project=<?=$_GET['project']?>">
			<input class="<?=$_ERROR['hours']?>" placeholder="Hours Worked" value="<?=$_POST['hours']?>" type="text" name="hours" />
			<br />
			<input class="<?=$_ERROR['desc']?>" placeholder="Quick Description" value="<?=$_POST['desc']?>" type="text" name="desc" />
			<br />
			<button type="submit">Clock In</button>
		</form>
	</div>
</div>
<? include('includes/footer.php'); ?>