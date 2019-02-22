<?php include "includes/function.php";?>

<head>

<title>[EWAT] Extended WebAdmin Tool and Logs Viewer For ExileMod By DrKhyz</title><link rel="stylesheet" media="screen" type="text/css" title="index" href="css/form.css" />

<script type="text/javascript" src="includes/chargement.js" charset="utf-8"></script>
<script type="text/javascript">debut = timeStamp();</script>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>

<SCRIPT language="javascript">
function popup(page) {
  window.open(page);
}
</SCRIPT>
</head>

<html>

<body>

<center>
<ul id="menu">
	<li><a href="./">Index</a>
	</li>
	<li><a href="#">Lists</a>
		<ul>
			<li><a href="listplayers.php">Accounts</a>
			    <ul>
			    	<li><a href="listplayers.php?type=toptabs">Top Money</a></li>
    				<li><a href="listplayers.php?type=toprespect">Top Respect</a></li>
    			</ul>
				<li><a href="vehicles.php">Vehicles</a></li>
				<li><a href="territories.php">Territories</a></li>
				<li><a href="clan.php">Families</a></li>
				<li><a href="died.php">Who die</a></li>
			</li>
		</ul>
	</li>
	<li><a href="#">Logs</a>
		<ul>
			<li><a href="logs.php">Trader</a>
			    <ul>
    				<li><a href="logs.php?type=trader">Single</a></li>
    				<li><a href="logs.php?type=waste">Waste</a></li>
    			</ul>
    		</li>
			<li><a href="infistar.php">Infistar</a>
				<ul>
					<li><a href="infistar.php">All</a></li>
    				<li><a href="infistar.php?type=admin">Admin</a></li>
    				<li><a href="infistar.php?type=dupe">Dupe</a></li>
    				<li><a href="infistar.php?type=surveillance">Surveillance</a></li>
    			</ul>
    		</li>
    		<li><a href="acc.php">Accounts</a>
    		</li>
		</ul>
	</li>
	<li class=""> 
		<form action="searchplayer.php" method="get">
				<input class="search" type="text" name="value" value="" placeholder="Search..">
				<input type="hidden" name="type" value="name">
		</form>
	</li>
</ul>


<div id="container">

<br/>
