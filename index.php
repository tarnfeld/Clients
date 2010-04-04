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
	
	$_TAG['title'] = $_CONFIG['company']." | Clients";
	include('includes/head.php');
	$_ERROR = array();

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
		<?
			$sql = "SELECT * FROM `clients` ORDER BY `id` ASC";
			$data = mysql_query($sql,$mysql);
			if(mysql_num_rows($data)>0):
		?>
		<h2>Your Clients <a href="clients/new.php"><p id="addButton"></p></a><a href="#" id="showEdits"><p id="minusButton"></p></a></h2>
			<ul class="list clients">
				<? while($row = mysql_fetch_assoc($data)): ?>
					<li>
						<h2><a href="clients/projects.php?id=<?=$row['id']?>"><?=$row['clientname']?></a></h2>
						<p class="actions">
							<a href="clients/edit.php?id=<?=$row['id']?>">Edit</a>
						</p>
						<a class="deleteButtonA" href="clients/delete.php?type=client&id=<?=$row['id']?>">
							<p class="deleteButton"></p>
						</a>
					</li>
				<? endwhile; ?>
			</ul>
			<p id="noneLeft" style="display:none;">You havn't added any clients, click <a href="clients/new.php">here</a> to add one.</p>
		<? else: ?>
			<h2>Your Clients</h2>
			<p class="error">You havn't added any clients, click <a href="clients/new.php">here</a> to add one.</p>
		<? endif; ?>
	</div>
</div>
<? include('includes/footer.php'); ?>