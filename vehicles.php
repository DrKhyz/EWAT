<?php
include "includes/config.php";
include "includes/header.php";


if (isset($_GET['type']))
{
	$type = $_GET['type'];
}
else
{
	$type = "";
}

if (isset($_GET['suid']))
{
	$suid = $_GET['suid'];
}else{
	$suid = 'UID';
}


	
	$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
	if ($page <= 0) $page = 1;
	 
	$per_page = 12;
	 
	$startpoint = ($page * $per_page) - $per_page;
	
	if (isset($_GET['suid']))
	{
		$statement = "`vehicle` WHERE id = $suid ORDER BY `last_updated_at` DESC";
	}else{
		$statement = "`vehicle` ORDER BY `last_updated_at` DESC";
	};


	$results = mysqli_query($link,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");

	$align = 'align=left style="padding:8px;font-size:14px;" ';

	if (mysqli_num_rows($results) != 0) {

		echo "<table  class=\"tform\" cellspacing=1 width=100%><tr $bcolor>
						<td width=18% $alignc>Type of Vehicle</td>
						<td width=15% $alignc>Owner</td>
						<td width=1% $alignl>Lock</td>
						<td width=5% $alignc>Fuel</td>
						<td width=5% $alignc>Damage</td>
						<td width=10% $alignc>Items</td>
						<td width=15% $alignc>Magazines</td>
						<td width=15% $alignc>Cargo</td>
						<td width=5% $alignc>Ammo</td>
						<td width=3% $alignc>Logs</td>
						<td width=3% $alignc>Map</td>
						</tr>";

		while ($row = mysqli_fetch_object($results))
		{

			$class = $row->class;
			$spawned_at = $row->spawned_at;
			$account_uid = $row->account_uid;
			$is_locked = $row->is_locked;
			$fuel = $row->fuel;
			$damage = $row->damage;
			$position_x = $row->position_x;
			$position_y = $row->position_y;
			$position_z = $row->position_z;		
			
			$cargo_items = $row->cargo_items;	
			$cargo_items = expl($cargo_items);

			$cargo_container = $row->cargo_container;		
			$cargo_container = expl($cargo_container);

			$cargo_magazines = $row->cargo_magazines;
			$cargo_magazines = expl($cargo_magazines);
			
			$last_updated_at = $row->last_updated_at;
			$pin_code = $row->pin_code;
			$ammo = $row->ammo;
			$ammo = expl($ammo);
			
			$vehicle_texture = $row->vehicle_texture;
			
			if ($is_locked == 0){
				$is_locked = "<img src=\"images/unlocked.png\" width=\"15\" height=\"15\" title=\"Unlocked\n$pin_code\"></img>";
			}else{
			    $is_locked = "<img src=\"images/locked.png\" width=\"13\" height=\"15\" title=\"Locked\n$pin_code\"></img>";
			}

			$sql2 = "SELECT name FROM account WHERE uid ='$account_uid'";
			$result2 = mysqli_query($link, $sql2);
			$row2 = mysqli_fetch_object($result2);
			
			$name = '<a href="accounts.php?type=uid&value=' . $account_uid . '">' . $row2->name . '</a> ';
			
			echo "<tr>
				<td $alignl>".strvitems($class)."</td>
				<td $alignl>$name</td>
				<td $alignc>$is_locked</td>
				<td $alignc>".fuel($fuel)."</td>
				<td $alignc>".damage($damage)."</td>
				<td $alignc>".convex($cargo_items)."</td>
				<td $alignc>".convex($cargo_magazines)."</td>
				<td $alignc>".convex($cargo_container)."</td>
				<td $alignc>".convex($ammo)."</td>
    			<td $alignc><img src=\"images/ask.png\" title=\"Last update.:".date_convert($last_updated_at)."\nCreation.:".date_convert($spawned_at)."\" width=\"15\" height=\"15\"></td>
				<td $alignc><A href=\"javascript:popup('map.php?name=$usermap&x=$position_x&y=$position_y')\"><img width=\"15\" height=\"15\" src=\"images/mapico.png\"></A></td>
				</tr>";
		}
		
		echo "</table>";

	} else {
	echo "No records are found.";
	}

	
	if (isset($_GET['suid']))
	{
		echo pagination($statement,$per_page,$page,$url='?suid='.$suid.'&type=alive&');
	}else{
		echo pagination($statement,$per_page,$page,$url='?type=alive&');
	};



include "includes/footer.php";
?>