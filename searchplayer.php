<?php
include "includes/config.php";
include "includes/header.php";

	
	if (isset($_GET['type']) && isset($_GET['value']))
    {
        $type = $_GET['type'];
        $value = $_GET['value'];
    }	
	elseif (isset($_POST['type']) && isset($_POST['value']))
    {
        $type = $_GET['type'];
        $value = $_GET['value'];
    }
	elseif(!isset($_GET['type']) || !isset($_GET['value']))
	{
		echo "No value defined";
		$type = "";
		$value = "";
	}



	$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
	if ($page <= 0) $page = 1;
	 
	$per_page = 10;
	 
	$startpoint = ($page * $per_page) - $per_page;

	$statement = "account WHERE $type LIKE '%$value%' ORDER BY last_connect_at DESC";
	$results = mysqli_query($link,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");

    echo "<hr><h2>Results for : $type = $value</h2><hr>";

        
	 echo "<table class=\"tform\" >
			<tr $bcolor>
                <td width=150 $alignl>steam id</td>
                <td width=250 $alignl>name</td>
                <td width=75 $alignl>pop&nbsp;tabs</td>
                <td width=75 $alignl>Respect</td>
                <td width=75 $alignl>Kills</td>
                <td width=75 $alignl>Deaths</td>
                <td width=120 $alignl>First&nbsp;Connected</td>
                <td width=120 $alignl>Last&nbsp;Connected</td>
                <td width=120 $alignl>Last&nbsp;Disconnect</td>
                <td width=120 $alignl>Connections</td>
				<td width=85 $alignl>On Map</td>		
            </tr>";

    while ($row = mysqli_fetch_object($results))
    {
        if (isset($row->uid) && $row->uid <> '')
        {

            // Display Account
            $uid = $row->uid;
            $steam64id = '<a href="http://steamcommunity.com/profiles/' . $uid . '" >' . $uid . '</a> ';
            // $name = $row->name;
            // $name = '<a href="playersearch.php?server='.$Server.'&type='.$type.'&value='.$value	.'">'.$row->name.'</a>';
            $name = '<a href="accounts.php?type=uid&value=' . $uid . '">' . $row->name . '</a> ';
            $poptabs = $row->locker;
            $respect = $row->score;
            $kills = $row->kills;
            $deaths = $row->deaths;
            $first_connect_at = $row->first_connect_at;
            $last_connect_at = $row->last_connect_at;

            if (isset($row->last_disconnect_at))
            {
                $last_disconnect_at = $row->last_disconnect_at;
            }
            else
            {
                $last_disconnect_at = '0000-00-00 00:00:00';
            }

            $total_connections = $row->total_connections;
			
			$sql4 = "SELECT * FROM player WHERE account_uid = '$uid'";
			$result4 = mysqli_query($link, $sql4);

			if (mysqli_num_rows($result4) > 0)
            {
			     while ($row4 = mysqli_fetch_object($result4))
			     {
				        $position_x = $row4->position_x;
				        $position_y = $row4->position_y;
			     }
				$onmap = "<a href=javascript:popup(\"map.php?name=$usermap&x=$position_x&y=$position_y\")><img width=\"15\" height=\"15\" src=\"images/mapico.png\"></a>";
				$options = "<a href=\"playeredit.php?action=edit&uid=$uid\"><img src=\"images/edit.png\" title=\"edit pop tabs and respect\" width=\"15\" height=\"15\"></img></a> <a href=\"playeredit.php?action=delete&uid=$uid\"><img src=\"images/delete.png\" title=\"delete the character\" width=\"15\" height=\"15\"></img></a>";
			
			}
			else
			{
				$options = "<a href=\"playeredit.php?action=edit&uid=$uid\"><img src=\"images/edit.png\" title=\"edit pop tabs and respect\" width=\"15\" height=\"15\"></img></a>";
				$onmap = "No player alive";
			}

            echo "<tr>
        			<td $alignl>$steam64id</td>
        			<td $alignl>$name</td>
        			<td $alignl>$poptabs</td>
        			<td $alignl>$respect</td>
        			<td $alignl>$kills</td>
        			<td $alignl>$deaths</td>
        			<td $alignl>".date_convert($first_connect_at)."</td>
        			<td $alignl>".date_convert($last_connect_at)."</td>
        			<td $alignl>".date_convert($last_disconnect_at)."</td>
        			<td $alignl>$total_connections</td>
        			<td $alignl>$onmap</td>			
                    <td $alignl>$options</td>
			     </tr>";
            }
     
	
	}
	echo "</table>";
		   
	echo pagination($statement,$per_page,$page,$url='?type='.$type.'&value='.$value.'&');
	

	include "includes/footer.php";

	?>