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

if ($type == 'waste'){
    $statement = "trader_recycle_log WHERE time_sold > NOW() - INTERVAL 4 DAY";
    $pagination = pagination($statement,$per_page,$page,$url='?type=waste&');
}else{
    $statement = "trader_log WHERE time_sold > NOW() - INTERVAL 4 DAY";
    $pagination = pagination($statement,$per_page,$page,$url='?type=trader&');
}

$results = mysqli_query($link,"SELECT * FROM {$statement} ORDER BY `time_sold` DESC LIMIT {$startpoint} , {$per_page}");

if (mysqli_num_rows($results) != 0) {
    
    echo  "<table class=\"tform\" ><tr $bcolor>
	<td $alignc $valignc>name</td>
	<td $alignc $valignc>Item Sold</td>
	<td $alignc $valignc>Money</td>
	<td $alignc $valignc>respect</td>";

    if ($type == 'waste'){
        echo"	<td $alignc $valignc>transaction ID</td>
            	<td $alignc $valignc>Vehicle</td>
            	<td $alignc $valignc>Vehicle Sold</td>";
    }
    
	echo "<td $alignc $valignc>Time</td>
	</tr>";
	
    while ($row = mysqli_fetch_object($results))
    {
        $id = $row->id;
        $playerid = $row->playerid;
        
        $result2 = mysqli_query($link,"SELECT name FROM account WHERE uid ='$playerid'");
        $row2 = mysqli_fetch_object($result2);
        $name = '<a href="accounts.php?type=uid&value=' . $playerid . '">' . $row2->name . '</a> ';
        
        $poptabs = $row->poptabs;
        $respect = $row->respect;
        
        if ($type == 'waste'){
            
            $transactionid = $row->transactionid;
            
            $vehicleclass = $row->vehicleclass;
            $soldvehicle = $row->soldvehicle;
        }
        $item_sold = $row->item_sold;
        
        $time_sold = $row->time_sold;
        
        echo "<tr>
			<td $alignl>$name</td>
            <td $alignr>".strvitems($item_sold)."</td>
            <td $alignr>$poptabs</td>
            <td $alignr>$respect</td>
            ";
        
        if ($type == 'waste'){
            
            echo "<td $alignl>$transactionid</td>
			      <td $alignl>".$vehicleclass."</td>
                  <td $alignr>$soldvehicle</td>";
        }
        
        echo "<td width=10% $alignr>".date_convert($time_sold)."</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No records are found.";
}
echo $pagination;

include "includes/footer.php";

?>