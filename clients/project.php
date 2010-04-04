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
	
	if(!$_GET)
	{
		header("Location: ../index.php");
	}
	
	$sql = "SELECT * FROM `projects` WHERE `id`='$_GET[id]'";
	$rawdata = mysql_query($sql);
	$data = mysql_fetch_assoc($rawdata);
	
	$_TAG['title'] = $_CONFIG['company']." | ".$data['projectname']." Details";
	include('../includes/head.php');
	$_ERROR = array();

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
		<?
			$sql = "SELECT * FROM `clocks` WHERE `projid`='$data[id]' ORDER BY `hours` ASC";
			$projdata = mysql_query($sql,$mysql);
			if(mysql_num_rows($projdata)>0):
		?>
		<h2><?=$data['projectname']?> <a href="clockin.php?project=<?=$data['id']?>"><p id="addButton"></p></a><a href="#" id="showEdits"><p id="minusButton"></p></a></h2>
			<p><?=$data['projectdesc']?></p>
			<ul class="list projects">
				<? while($row = mysql_fetch_assoc($projdata)): ?>
					<li>
						<h2><a><?=date("D jS F, Y",$row['date'])?></a> <span class="lighter"><?=$row['desc']?></span></h2>
						<div class="hours"><?=$row['hours']?>&nbsp;Hours
						</div>
						<a class="deleteButtonA" href="delete.php?type=clockin&id=<?=$row['id']?>">
							<p class="deleteButton"></p>
						</a>
					</li>
				<? endwhile; ?>
			</ul>
			<p id="noneLeft" style="display:none;">Nobody has clocked into this project yet. You can clock in <a href="clockin.php?project=<?=$_GET['id']?>">here</a>.</p>
		<? else: ?>
			<h2><?=$data['projectname']?></h2>
			<p><?=$data['projectdesc']?></p>
			<p class="error">Nobody has clocked into this project yet. You can clock in <a href="clockin.php?project=<?=$_GET['id']?>">here</a>.</p>
		<? endif; ?>
	</div>
</div>
<? include('includes/footer.php'); ?>