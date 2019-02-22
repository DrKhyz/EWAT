<?php
include "includes/config.php";
include "includes/header.php";


$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
if ($page <= 0) $page = 1;

$per_page = 10; // Set how many records do you want to display per page.

$startpoint = ($page * $per_page) - $per_page;

$statement = "clan, account
			WHERE clan.leader_uid = account.uid
			ORDER BY clan.id";


$results = mysqli_query($link,"SELECT clan.name, clan.id, clan.leader_uid, clan.created_at, account.name as accname, account.clan_id, account.uid FROM {$statement} LIMIT {$startpoint} , {$per_page}");

if (mysqli_num_rows($results) != 0) {
    
    echo  "<table class=\"tform\" ><tr $bcolor>
	<td $alignc $valignc>Family Name</td>
	<td $alignc $valignc>Members</td>
	<td $alignc $valignc>last update</td>

	</tr>";
    
    
    
    
    while ($row = mysqli_fetch_object($results))
    {
        $id = $row->id;
        $name = $row->name;
        $leader_uid = $row->leader_uid;
        $created_at = $row->created_at;
        $accname = $row->accname;
        $clan_id = $row->clan_id;
        $uid = $row->uid;

        $sql2 = "SELECT name FROM account WHERE clan_id = '$clan_id'";
        $result2 = mysqli_query($link, $sql2);
        $clan_m = "";
        
        while ($row2 = mysqli_fetch_object($result2))
        {
            $namep = $row2->name;
            if($namep == $accname){
                $clan_m .= "<a href=\"accounts.php?type=uid&value=$uid\"><img src=\"images/owner.png\" title=\"Owner\" width=\"10\" height=\"10\">  $namep</a>";
            }else{
                $clan_m .= "<a href=\"accounts.php?type=uid&value=$uid\">  $namep</a>";
            }
        }
        
        echo "<tr>
			<td $alignc $valignc>$name</td>
            <td $alignc $valignc>$clan_m</td>
			<td $alignc $valignc>".date_convert($created_at)."</td>
            </tr>";
        
    }
    echo "</table>";
    
} else {
    echo "No records are found.";
}

// displaying paginaiton.
echo pagination($statement,$per_page,$page,$url='?');

include "includes/footer.php";

?>