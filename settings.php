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
			$_ERROR['text'] = 'Please fill in all fields';
		}
		else
		{
			$sql = "UPDATE `config` SET `value`='$_POST[company]' WHERE `key`='company'";
			mysql_query($sql,$mysql);
			$sql = "UPDATE `config` SET `value`='$_POST[siteurl]' WHERE `key`='siteurl'";
			mysql_query($sql,$mysql);
			$sql = "UPDATE `config` SET `value`='$_POST[roundtype]' WHERE `key`='roundtype'";
			mysql_query($sql,$mysql);
			$sql = "UPDATE `config` SET `value`='$_POST[roundnearest]' WHERE `key`='roundnearest'";
			mysql_query($sql,$mysql);
			header("Location: settings.php");
		}
	}
	
	$_TAG['title'] = $_CONFIG['company']." | Edit Client";
	include('includes/head.php');

?>
<div id="wrap">
	<div id="header">
		<h1><a href="<?=$_CONFIG['siteurl']?>"><?=$_CONFIG['company']?> <span class="lighter">Logged in as <?=$_SESSION['user']['name']?></span></a></h1>
		<ul id="nav">
			<li>
				Settings
			</li>
			<li>
				<a href="logout.php">Logout</a>
			</li>
		</ul>
		<br style="clear:both" />
	</div>
	<div class="large">
		<h2>Configuration <span class="error"><?=$_ERROR['text']?></span></h2>
		<form method="post" action="settings.php">
			<input placeholder="Company Name" class="focusFirst <?=$_ERROR['company']?>"  value="<?=$_CONFIG['company']?>" type="text" name="company" />
			<br />
			<input placeholder="Site URL" class="focusFirst <?=$_ERROR['siteurl']?>"  value="<?=$_CONFIG['siteurl']?>" type="text" name="siteurl" />
			<span class="lighter">&nbsp;&nbsp;Make sure this is correct!</span>
			<br />
			<p>Round clock in's 
			<select name="roundtype">
				<option <? if($_CONFIG['roundtype']=='up'):?>selected="selected"<? endif; ?> value="up">Up</option>
				<option <? if($_CONFIG['roundtype']=='down'):?>selected="selected"<? endif; ?> value="down">Down</option>
			</select> to the nearest
			<select name="roundnearest">
				<option <? if($_CONFIG['roundnearest']=='1'):?>selected="selected"<? endif; ?> value="1">1 Hour</option>
				<option <? if($_CONFIG['roundnearest']=='.5'):?>selected="selected"<? endif; ?> value=".5">30 Mins</option>
				<option <? if($_CONFIG['roundnearest']=='.25'):?>selected="selected"<? endif; ?> value=".25">15 Mins</option>
			</select>
			</p>
			<p><span class="lighter">This is for the <b>Auto Clock In</b> feature to be implemented in the next few days.</span></p>
			<button type="submit">Update</button>
		</form>
		<?
			$sql = "SELECT * FROM `staff` ORDER BY `id` AND `active` DESC";
			$data = mysql_query($sql,$mysql);
			if(mysql_num_rows($data)>0):
		?>
		<br />
		<h2>Your Staff <a href="newstaff.php"><p id="addButton"></p></a><a href="#" id="showEdits"><p id="minusButton"></p></a></h2>
			<ul class="list clients">
				<? while($row = mysql_fetch_assoc($data)): ?>
					<? if($row['active']==0): ?>
					<li class="faded">
						<h2><?=$row['name']?> <span class="lighter"><?=$row['email']?></span></h2>
						<p class="actions extra">
							<a class="permDelete" href="clients/delete.php?type=staffperm&id=<?=$row['id']?>">Permanently Delete</a> | <a class="restoreStaff" href="clients/delete.php?type=staffrestore&id=<?=$row['id']?>">Restore</a>
						</p>
						<p class="actions normal">
							<a style="display:none;" href="editstaff.php?id=<?=$row['id']?>">Edit</a>
						</p>
						<a class="hiddendelete" style="display:none;" href="clients/delete.php?type=staff&id=<?=$row['id']?>">
							<p class="deleteButton deactivate"></p>
						</a>
					</li>
					<? else: ?>
					<li>
						<h2><?=$row['name']?> <span class="lighter"><?=$row['email']?></span></h2>
						<p class="hiddenactions" style="display:none">
							<a class="permDelete" href="clients/delete.php?type=staffperm&id=<?=$row['id']?>">Permanently Delete</a> | <a class="restoreStaff" href="clients/delete.php?type=staffrestore&id=<?=$row['id']?>">Restore</a>
						</p>
						<p class="actions normal">
							<a href="editstaff.php?id=<?=$row['id']?>">Edit</a>
						</p>
						<? if($row['id']!=$_SESSION['user']['id']): ?>
						<a class="deleteButtonA deactivate" href="clients/delete.php?type=staff&id=<?=$row['id']?>">
							<p class="deleteButton deactivate"></p>
						</a>
						<? endif; ?>
					</li>
					<? endif; ?>
				<? endwhile; ?>
			</ul>
		<? else: ?>
			<h2>Your Staff</h2>
			<br />
			<p class="error">This is very odd, you haven't added any staff, but yet you are logged in? Click <a href="clients/new.php">here</a> to add a member of staff.</p>
		<? endif; ?>
	</div>
</div>
<? include('includes/footer.php'); ?>