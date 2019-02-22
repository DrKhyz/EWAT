<?php
include "includes/config.php";
include "includes/header.php";


$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
if ($page <= 0) $page = 1;

$per_page = 10;

$startpoint = ($page * $per_page) - $per_page;

$statement = "territory, account 
			WHERE territory.owner_uid = account.uid 
			ORDER BY territory.name";

$results = mysqli_query($link,"SELECT territory.*,
			account.name as owner_name, account.uid
			FROM {$statement} 
			LIMIT {$startpoint} , {$per_page}");

if (mysqli_num_rows($results) != 0) {

    	echo  "<table class=\"tform\" ><tr $bcolor>
        <td $alignl>Territory Name</td>
    	<td width=50 $alignc>Level<hr>Radius</td>
    	<td width=200 $alignc>Time Informations<hr>Time remaning</td>
    	<td width=200 $alignc>Builders</td>
    	<td width=20 $alignc>On Map</td>
    	</tr>";

		while ($row = mysqli_fetch_object($results))
		{
		    $idt = $row->id;
			$steam64id = $row->uid;
			$territoryName = $row->name;
			$position_x = $row->position_x;
			$x = $row->position_x;
			$position_x = sprintf( '%05d', $position_x );
			$position_y = $row->position_y;
			$y = $row->position_y;
			$position_y = sprintf( '%05d', $position_y );
			$inGameCoords = substr($position_x, 0, 3).substr($position_y, 0, 3);
			$radius = $row->radius;
			$owner_uid = $row->owner_uid;
			$level = $row->level;
			
			$flag_stolen = $row->flag_stolen;
			$flag_stolen_by_uid = $row->flag_stolen_by_uid;
			$flag_stolen_at = $row->flag_stolen_at;
			
			$owner_name = $row->owner_name; 
			$moderators = $row->moderators;
			$moderators = expl($moderators);  
			$created_at = $row->created_at;
			$last_paid_at = $row->last_paid_at;  

			$next_paid = new DateTime($last_paid_at);
			$next_paid->add(new DateInterval('P'.$territoryLifeTime.'D'));
			$today = new DateTime();
			
			$dteDiff  = $next_paid->diff($today);
			
			$remain = $dteDiff->format("%d days %Hh %Im %Ss"); 
			
			$build_rights = $row->build_rights;
			$buildRights = expl($build_rights);
			$territoryBuilders = "";
			foreach ($buildRights as $builder)
			{
				if($builder <> "")
				{
				
					$result2 = mysqli_query($link, "SELECT name FROM account WHERE uid = '$builder'");
					$row2 = mysqli_fetch_object($result2);

					$BuilderName = $row2->name;
					$BuilderName = $BuilderName;

					if($builder == $owner_uid){
					    $territoryBuilders .= '<img src="images/owner.png" title="Owner" align="left" width="10" height="10"><a href="accounts.php?type=uid&value='.$builder.'">'.$BuilderName.'</a></img>';
					}
					elseif(in_array($builder, $moderators)){
					    $territoryBuilders .= '<img src="images/modo.png" title="Moderator" align="left" width="10" height="10"><a href="accounts.php?type=uid&value='.$builder.'">'.$BuilderName.'</a></img>';
					}
					else{
					    $territoryBuilders .= '<a href="accounts.php?type=uid&value='.$builder.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$BuilderName.'</a></img>';
					}
				}
			}    
			$territoryBuilders = rtrim($territoryBuilders);
			echo "<tr>
			<td $alignl $valignc>$territoryName</td>
			<td $alignc>$level<hr>$radius</td>
			<td $alignl $valignc><img src=\"images/ask.png\" title=\"Created.:".date_convert($created_at)."\" width=\"11\" height=\"11\"> Last paid : ".date_convert($last_paid_at)." <hr> $remain</td>
			<td $alignl>$territoryBuilders </td>
			<td $alignc><A href=\"javascript:popup('map.php?name=$usermap&x=$x&y=$y')\"><img width=\"20\" height=\"20\" src=\"images/mapico.png\"></A></td>
            <td><a href=\"territoryedit.php?action=edit&id=$idt\"><img src=\"images/edit.png\" title=\"Edit territory\" width=\"15\" height=\"15\" ></a><a href=\"playeredit.php?action=delete&id=$idt\"><img src=\"images/delete.png\" title=\"delete territory\" width=\"15\" height=\"15\"></a></td></tr>";
			
		}
		echo "</table></div></div>";
	
} else {
	echo "No records are found.";
}
 
echo pagination($statement,$per_page,$page,$url='?');

include "includes/footer.php";
	
?>