<?php

    include "includes/config.php";
    include "includes/header.php";
        
    if (isset($_GET['type']))
    {
    	$type = $_GET['type'];
    }
    elseif(!isset($_GET['type']))
    {
    	$type = "";
    }
    
    $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
    if ($page <= 0) $page = 1;
    $per_page = 15; // Set how many records do you want to display per page.
    
    $startpoint = ($page * $per_page) - $per_page;
    
if ($type == 'toptabs'){
    
    $statement =  "account WHERE `last_connect_at` > NOW() - INTERVAL 21 DAY ORDER BY `locker` DESC";
    $pagination =  pagination($statement,$per_page,$page,$url='?type=toptabs&');
}
elseif ($type == 'toprespect')
{
    $statement =  "account WHERE `last_connect_at` > NOW() - INTERVAL 21 DAY ORDER BY `score` DESC";
    $pagination =  pagination($statement,$per_page,$page,$url='?type=toprespect&');
}
else
{
    $statement =  "account WHERE last_connect_at > NOW() - INTERVAL 21 DAY ORDER BY `last_connect_at` DESC";
    $pagination =  pagination($statement,$per_page,$page,$url='?type=alive&');
}

$result = mysqli_query($link,"SELECT * FROM {$statement} limit {$startpoint} , {$per_page}");

echo "<div><table class=\"tform\" cellspacing=1 >";

echo "<tr $bcolor>
	<td $alignc>Name</td>
	<td width=100 $alignc>Score</td>
	<td width=100 $alignc>Lockers</td>
	<td width=20 $alignc>kills</td>
	<td width=20 $alignc>deaths</td>
	<td width=20 $alignc>k/d ratio</td>
	<td width=110 $alignc>Info.</td></tr>";



while ($row = mysqli_fetch_object($result))
{
   
    $steam64id = $row->uid;
    $name = '<a href="accounts.php?type=uid&value=' . $steam64id . '">' . $row->name . '</a> ';
    $score = $row->score;
    $money = $row->locker;
    $kills = $row->kills;
    $deaths = $row->deaths;
    $first_connected = $row->first_connect_at;
    $last_connected = $row->last_connect_at;
    if ($kills != 0 && $deaths != 0)
    {
        $kdratio = number_format($kills / $deaths, 2);
    }
    else
    {
        $kdratio = 'n/a';
    }
    
    $total_connections = $row->total_connections;
    
    echo "<tr>
        <td $alignl>$name</td>
        <td $alignr>$score</td>
        <td $alignr>$money</td>
        <td $alignc>$kills</td>
        <td $alignc>$deaths</td>
        <td $alignc>$kdratio</td>
    	<td $alignc><img src=\"images/ask.png\" title=\"First Connect.: ".date_convert($first_connected)."\nLast Connect.: ".date_convert($last_connected)."\nNb Connect.: $total_connections\" width=\"15\" height=\"15\"></td>";

}

echo "</table></div>";

echo $pagination;

include "includes/footer.php";


?>