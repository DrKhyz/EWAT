<?php
include "includes/config.php";
include "includes/header.php";

$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
if ($page <= 0) $page = 1;

$per_page = 20; // Set how many records do you want to display per page.

$startpoint = ($page * $per_page) - $per_page;

$statement = "`account_log` ORDER BY `connected` DESC"; // Change `records` according to your table name.

$results = mysqli_query($link,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");


if (mysqli_num_rows($results) != 0) {

	echo "<div><table class=\"tform\" cellspacing=1 >";

	echo "<tr $bcolor>
	<td width=150 $alignl>UID</td>
	<td width=150 $alignl>New Name</td>
	<td width=150 $alignl>Old Name</td>
	<td width=150 $alignl>Locker</td>
	<td width=50 $alignl>Score</td>
	<td width=200 $alignl>Switch Nickname at</td></tr>";

	while ($row = mysqli_fetch_object($results))
	{
		$uid = $row->uid;
		$name = '<a href="accounts.php?type=uid&value=' . $uid . '">' . $row->name . '</a> ';
        $old_name = '<a href="accounts.php?type=uid&value=' . $uid . '">' . $row->old_name . '</a> ';
        $money = $row->locker;
        $score = $row->score;
        $connected = $row->connected;

        echo "<tr>
        <td $alignl>$uid</td>
        <td $alignl>$name</td>
        <td $alignl>$old_name</td>
        <td $alignl>$money</td>
        <td $alignl>$score</td>
        <td $alignl>".date_convert($connected)."</td></tr>";
	}
	echo "</table></div>";
	} else {
		echo "<div><center><br/><br/><br/><br/><br/><br/>No records are found.</center><br/><br/></div>";
	}
	
	
echo pagination($statement,$per_page,$page,$url='?');

include "includes/footer.php";
?>