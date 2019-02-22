<?php
include "includes/config.php";
include "includes/header.php";

/*$sousmenu = '<ul id="menu-deroulant">
    			<li class="bouton_gauche"><a href="infistar.php">All Logs</a></li>
    			<li class="bouton_gauche"><a href="infistar.php?type=admin">Admin Logs</a></li>
                <li class="bouton_gauche"><a href="infistar.php?type=dupe">Dupe Logs</a></li>
                <li class="bouton_gauche"><a href="infistar.php?type=surveillance">Surveillance Logs</a></li>
                </ul> <br/>';

echo $sousmenu;*/


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

if ($type == 'admin'){
    $statement = "infistar_logs WHERE Time > NOW() - INTERVAL 4 DAY AND logname = 'ADMINLOG'";
    $pagination = pagination($statement,$per_page,$page,$url='?type=admin&');
}elseif($type == 'dupe'){
    $statement = "infistar_logs WHERE Time > NOW() - INTERVAL 4 DAY AND logname = 'DUPE'";
    $pagination = pagination($statement,$per_page,$page,$url='?type=dupe&');
}elseif($type == 'surveillance'){
    $statement = "infistar_logs WHERE Time > NOW() - INTERVAL 4 DAY AND logname = 'SURVEILLANCELOG'";
    $pagination = pagination($statement,$per_page,$page,$url='?type=surveillance&');
}else{
    $statement = "infistar_logs WHERE Time > NOW() - INTERVAL 4 DAY";
    $pagination = pagination($statement,$per_page,$page,$url='?');
}

$results = mysqli_query($link,"SELECT * FROM {$statement} ORDER BY `Time` DESC LIMIT {$startpoint} , {$per_page}");

if (mysqli_num_rows($results) != 0) { 
    echo  "<table class=\"tform\" ><tr $bcolor>
	<td $alignc $valignc>Logname</td>
	<td $alignc $valignc>Entry</td>
	<td $alignc $valignc>Time</td>
	</tr>";
    while ($row = mysqli_fetch_object($results))
    {
        $logname = $row->logname;
        $logentry = $row->logentry;
        $time = $row->time;
        echo "<tr>
			<td width=10% $alignl>$logname</td>
			<td width=80% $alignl>$logentry</td>
            <td width=10% $alignr>".date_convert($time)."</td>
            </tr>";
        
    }
    echo "</table>";
} else {
    echo "No records are found.";
}
echo $pagination;

include "includes/footer.php";

?>