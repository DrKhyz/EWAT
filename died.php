<?php
include "includes/config.php";
include "includes/header.php";

$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
if ($page <= 0) $page = 1;
 
$per_page = 12;
 
$startpoint = ($page * $per_page) - $per_page;

$statement = "`player_history` ORDER BY `died_at` DESC";

$results = mysqli_query($link,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");

if (mysqli_num_rows($results) != 0) {

    echo "<div><table class=\"tform\" cellspacing=1 >";
    echo "<tr $bcolor>
	<td $alignl>Name</td>
	<td width=60 $alignl>Died At</td>
	<td width=50 $alignl>On map</td></tr>";

    while ($row = mysqli_fetch_object($results))
    {
       
        $id = $row->id;
		$victimuid = $row->account_uid;
        $victim = '<a href="accounts.php?type=uid&value=' . $victimuid . '">' . $row->name . '</a> ';
        $x = $row->position_x;
        $y = $row->position_y;
        $diedat = $row->died_at;

        echo "<tr>
        <td $alignl>$victim</td>
        <td $alignl>".date_convert($diedat)."</td>
        <td $alignl><A href=javascript:popup(\"map.php?name=$usermap&x=$x&y=$y\")><img width=\"15\" height=\"15\" src=\"images/mapico.png\"></A></td>
		</tr>";
    }
    echo "</table></div>";

} else {
	echo "No records are found.";
}

echo pagination($statement,$per_page,$page,$url='?');

include "includes/footer.php";

?>