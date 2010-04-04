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
	
	$sql = "SELECT * FROM `clients` WHERE `id`='$_GET[id]'";
	$rawdata = mysql_query($sql);
	$data = mysql_fetch_assoc($rawdata);
	
	$_TAG['title'] = $_CONFIG['company']." | ".$data['clientname']."'s Projects";
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
			$sql = "SELECT * FROM `projects` WHERE `clientid`='$data[id]' ORDER BY `id` ASC";
			$projdata = mysql_query($sql,$mysql);
			if(mysql_num_rows($projdata)>0):
		?>
		<h2>Projects <span class="lighter"><?=$data['clientname']?></span> <a href="newproject.php?client=<?=$data['id']?>"><p id="addButton"></p></a><a href="#" id="showEdits"><p id="minusButton"></p></a></h2>
			<ul class="list projects">
				<? while($row = mysql_fetch_assoc($projdata)): ?>
					<li>
						<h2><a href="project.php?id=<?=$row['id']?>"><?=$row['projectname']?></a> <span class="lighter"><?=$row['projectdesc']?></span></h2>
						<div class="hours">
							<?
								$sql = "SELECT * FROM `clocks` WHERE `projid`='$row[id]'";
								$num = 0;
								$results = mysql_query($sql,$mysql);
								while($hours = mysql_fetch_assoc($results))
								{
									$num = $num + $hours['hours'];
								}
								echo($num);
							?>
							&nbsp;Hours
						</div>
						<a class="deleteButtonA" href="delete.php?type=project&id=<?=$row['id']?>&client=<?=$data['id']?>">
							<p class="deleteButton"></p>
						</a>
					</li>
				<? endwhile; ?>
			</ul>
			<p id="noneLeft" style="display:none;">You havn't added any projects, click <a href="newproject.php?client=<?=$data['id']?>">here</a> to add one.</p>
		<? else: ?>
			<h2>Projects <span class="lighter"><?=$data['clientname']?></span></h2>
			<p class="error">You havn't added any projects, click <a href="newproject.php?client=<?=$data['id']?>">here</a> to add one.</p>
		<? endif; ?>
	</div>
</div>
<? include('includes/footer.php'); ?>