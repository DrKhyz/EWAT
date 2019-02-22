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
		$type = "";
		$value = "";
	}


	if ($type == 'name')
    {
        $value = strtolower($value);
        $sql = "SELECT * FROM account WHERE LOWER(account.name) LIKE '%$value%' ORDER BY name";
    }
    elseif ($type == 'uid')
    {
        $value = strtolower($value);
        $value = str_replace(' ', '', $value);
        $sql = "SELECT * FROM account WHERE LOWER(uid) LIKE '%$value%'";
    }
    else
    {
        $sql = "SELECT * FROM account ORDER BY 'last_disconnect_at'";
    }
	
	
	$result = mysqli_query($link, $sql);



    while ($row = mysqli_fetch_object($result))
    {
        $uid = $row->uid;
        
        $name = $row->name;
        
        echo "	<br/><h2>$name details</h2><hr>";
        
        
        if (isset($row->uid) && $row->uid <> '')
        {
            echo "<table class=\"tform\" >
					<tr $bcolor>
                            <td $alignc>name</td>
                            <td width=10% $alignc>Lockers</td>
                            <td width=10% $alignc>Money</td>
                            <td width=10% $alignc>Respect</td>
                            <td width=5% $alignc>Kills</td>
                            <td width=5% $alignc>Deaths</td>
                            <td width=5% $alignc>Nb.Con.</td>
							<td width=5% $alignc>On Map</td>
                            <td width=5% $alignc>logs</td>
                    </tr>";

            $steam64id = '<a href="http://steamcommunity.com/profiles/'.$uid.'" >'.$uid.'</a> ';
            $name = "<a href=\"accounts.php?type=uid&value=$uid\">".$row->name."</a>";
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
				$options = "<a href=\"playeredit.php?action=edit&uid=$uid\"><img src=\"images/edit.png\" title=\"edit pop tabs and respect\" width=\"15\" height=\"15\" ></a><a href=\"playeredit.php?action=delete&uid=$uid\"><img src=\"images/delete.png\" title=\"delete the character\" width=\"15\" height=\"15\"></a>";
				while ($row4 = mysqli_fetch_object($result4))
				{
					$position_x = $row4->position_x;
					$position_y = $row4->position_y;
					$money=$row4->money;
				}
				$onmap = "<A href=javascript:popup(\"map.php?name=$usermap&x=$position_x&y=$position_y\")><img width=\"15\" height=\"15\" src=\"images/mapico.png\"></A>";

			
			}
			else
			{
				$options = "<a href=\"playeredit.php?action=edit&uid=$uid\"><img src=\"images/edit.png\" title=\"edit pop tabs and respect\" width=\"15\" height=\"15\"></a>";
				$onmap = "Not alive";
				$money= "Not alive";
			}

            echo "<tr>
			<td $alignc>$name</td>
			<td $alignc>$poptabs</td>
			<td $alignc>$money</td>
			<td $alignc>$respect</td>
			<td $alignc>$kills</td>
			<td $alignc>$deaths</td>
			<td $alignc>$total_connections</td>
			<td $alignc>$onmap</td>
			<td $alignc><img src=\"images/ask.png\" title=\"first connect.:".date_convert($first_connect_at)."\nLast disconnect.:".date_convert($last_disconnect_at)."\nLast connect.:".date_convert($last_connect_at)."\" width=\"15\" height=\"15\"></td>
            <td width=5% $alignc>$options</td>
			</tr></table>";
            
            
            
            /***************************************************
             *
             *
             *              Display Char
             *
             *
             **************************************************/
            
            
            
            
            $sql6 = "SELECT * FROM player WHERE account_uid = '$uid'";
            $result6 = mysqli_query($link, $sql6);
            
            if (mysqli_num_rows($result6) > 0)
            {
                echo "<hr><div class=\"atable\"><table border=\"1\">";
            }
            else
            {
                echo "<h2>This accounts has no alive character</h2><hr>";
            }
            
            while ($row6 = mysqli_fetch_object($result6))
            {
                $damage = $row6->damage;
                $hunger = $row6->hunger;
                $thirst = $row6->thirst;
                $alcohol = $row6->alcohol;
                $temperature = $row6->temperature;
                $wetness = $row6->wetness;
                $oxygen_remaining = $row6->oxygen_remaining;
                $bleeding_remaining = $row6->bleeding_remaining;
                $hitpoints = $row6->hitpoints;
                $direction = $row6->direction;
                $position_x = $row6->position_x;
                $position_y = $row6->position_y;
                $position_z = $row6->position_z;
                $spawned_at = $row6->spawned_at;
                // $assigned_items = $row6->assigned_items;
                $assigned_items = $row6->assigned_items;
                $backpack = $row6->backpack;
                
                $backpack_items = $row6->backpack_items;
                $backpack_items = expl($backpack_items);
                
                $backpack_magazines = $row6->backpack_magazines;
                $backpack_magazines = expl($backpack_magazines);
                
                $backpack_weapons = $row6->backpack_weapons;
                $backpack_weapons = expl($backpack_weapons);
                
                $current_weapon = $row6->current_weapon;
                $goggles = $row6->goggles;
                $handgun_items = $row6->handgun_items;
                $handgun_weapon = $row6->handgun_weapon;
                $headgear = $row6->headgear;
                $binocular = $row6->binocular;
                $loaded_magazines = $row6->loaded_magazines;
                $primary_weapon = $row6->primary_weapon;
                $primary_weapon_items = $row6->primary_weapon_items;
                $secondary_weapon = $row6->secondary_weapon;
                $secondary_weapon_items = $row6->secondary_weapon_items;
                $uniform = $row6->uniform;
                
                $uniform_items = $row6->uniform_items;
                $uniform_items = expl($uniform_items);
                
                $uniform_magazines = $row6->uniform_magazines;
                $uniform_magazines = expl($uniform_magazines);
                
                $uniform_weapons = $row6->uniform_weapons;
                $uniform_weapons = expl($uniform_weapons);
                
                $vest = $row6->vest;
                
                $vest_items = $row6->vest_items;
                $vest_items = expl($vest_items);
                
                $vest_magazines = $row6->vest_magazines;
                $vest_magazines = expl($vest_magazines);
                
                $vest_weapons = $row6->vest_weapons;
                $vest_weapons = expl($vest_weapons);
                
                $last_updated_at = $row6->last_updated_at;
                
                echo "<tr>
				        <td $valignc $alignc>Damage<br/>".damage($damage)."</td>
				        <td $valignc $alignc>Bleed<br/>".bleed($bleeding_remaining)."</td>
				        <td $valignc $alignc rowspan=2>Hit points<br/>don't work</td>
				        <td $valignc $alignc rowspan=2>".grpstvr($assigned_items)."</td>
                      </tr>
                      <tr>
				        <td $valignc $alignc>Hunger<br/>".health($hunger)."</td>
				        <td $valignc $alignc>Temp<br/>".temp($temperature)."</td>
                      </tr>
                      <tr>
                        <td $valignc $alignc>Thirst<br/>".health($thirst)."</td>
				        <td $valignc $alignc>Oxygen<br/>".oxygene($oxygen_remaining)."</td>
				        <td $valignc $alignc><A href=\"javascript:popup('map.php?name=$usermap&x=$position_x&y=$position_y')\"><img width=\"15\" height=\"15\" src=\"images/mapico.png\"></A></td>
                        <td $valignc $alignc>".date_convert($last_updated_at)."</td>
                      </tr>
                    </table>
                </div>
                <div class=\"atable\">
                    <table>
                      <tr>
                        <td $valignc $alignc>".strvitems($primary_weapon)."</td>
				        <td $valignc $alignc>".grpstvr($primary_weapon_items)."</td>
                            <td $valignc $alignc>".strvitems($headgear)."</td>
                      </tr>
                      <tr>
                        <td $valignc $alignc>".strvitems($handgun_weapon)."</td>
                        <td $valignc $alignc>".grpstvr($secondary_weapon_items)."</td>
				            <td $valignc $alignc>".strvitems($binocular)."</td>
                      </tr>
                   </table>
                </div>
                <div class=\"atable\">
                    <table>
                      <tr>
                        <td $valignc $alignc>".strvitems($backpack)."</td>
                        <td $valignc $alignc>".strvitems($uniform)."</td>
                        <td $valignc $alignc>".strvitems($vest)."</td>
                      </tr>
                      <tr>
                        <td $valignc $alignc>".convexd($backpack_magazines)."</td>
                        <td $valignc $alignc>".convexd($uniform_magazines)."</td>
                        <td $valignc $alignc>".convexd($vest_magazines)."</td>
                      </tr>
                      <tr>
                        <td $valignc $alignc>".convexd($backpack_weapons)."</td>
                        <td $valignc $alignc>".convexd($uniform_weapons)."</td>
                        <td $valignc $alignc>".convexd($vest_weapons)."</td>
                      </tr>
                      <tr>
				        <td $valignc $alignc>".convexd($backpack_items)."</td>
				        <td $valignc $alignc>".convexd($uniform_items)."</td>
				        <td $valignc $alignc>".convexd($vest_items)."</td>
                      </tr>
                ";
            }
            echo "</table></div>";
            



            /***************************************************
             *
             *
             *              Display Associated Territories
             *
             *
             **************************************************/
            
            
            
            
            $sql3 = "SELECT territory.id, territory.owner_uid, territory.name, territory.position_x, territory.position_y, territory.radius, territory.level,
					account.name as owner_name, account.uid, territory.build_rights, territory.moderators, territory.created_at, territory.last_paid_at 

					FROM territory, account 
					WHERE (territory.owner_uid = account.uid OR territory.build_rights LIKE '%$uid%' OR territory.moderators LIKE '%$uid%')
					AND account.uid = '$uid'
					ORDER BY territory.name";
            $result3 = mysqli_query($link, $sql3);
            $TerritoryCount = mysqli_num_rows($result3);
            

            if (mysqli_num_rows($result3) > 0)
            {
                echo "<hr><h2>Territories ($TerritoryCount)</h2><hr>";
                echo "
				<table class=\"tform\">
				<tr $bcolor>
				<td $alignc>Territory Name</td>
				<td $alignc>Coords</td>
				<td $alignc>Radius</td>
				<td $alignc>Level</td>
				<td $alignc>Created_at</td>
				<td $alignc>Last_paid_at</td>
				<td $alignc>BuildRights</td>
				<td $alignc>On Map</td>
				</tr>";
            }
            else
            {
                echo "<hr><h2>This accounts has no territories</h2>";
            }

            
            while ($row3 = mysqli_fetch_object($result3))
            {
                $idt = $row3->id;
                $steam64id = $row3->uid;
                $territoryName = $row3->name;
                $position_x = $row3->position_x;
                $x = $row3->position_x;
                $position_x = sprintf('%05d', $position_x);
                $position_y = $row3->position_y;
                $y = $row3->position_y;
                $position_y = sprintf('%05d', $position_y);
                $inGameCoords = substr($position_x, 0, 3) . substr($position_y, 0, 3);
                $radius = $row3->radius;
                $level = $row3->level;
                $owner_name = $row3->owner_name;
                $owner_uid = $row3->owner_uid;
                $created_at = $row3->created_at;
                $last_paid_at = $row3->last_paid_at;
                
                $moderators = $row3->moderators;
                $moderators = expl($moderators);

                $build_rights = $row3->build_rights;
                $build_rights = expl($build_rights);
                
                $territoryBuilders = "";
                
                
                foreach ($build_rights as $builder)
                {
                    if ($builder <> "")
                    {
                        $sql4 = "SELECT name FROM account WHERE uid = '$builder'";
                        //echo "<hr>$sql4<hr>";
                        $result4 = mysqli_query($link, $sql4);
                        $row4 = mysqli_fetch_object($result4);
                        $BuilderName = $row4->name;
                        if($builder == $owner_uid){
                            $territoryBuilders .= '<img src="images/owner.png" title="Owner" align="left" width="10" height="10"><a href="accounts.php?type=uid&value='.$builder.'">'.$BuilderName.'</a></img>';
                        }
                        elseif(in_array($builder, $moderators)){
                            $territoryBuilders .= '<img src="images/modo.png" title="Moderator" align="left" width="10" height="10"><a href="accounts.php?type=uid&value='.$builder.'">'.$BuilderName.'</a></img>';
                        }
                        else{
                            $territoryBuilders .= '<a href="accounts.php?type=uid&value='.$builder.'">'.$BuilderName.'</a></img>';
                        }
                    }
                }
                
                $territoryBuilders = rtrim($territoryBuilders);
                
                echo "	<tr>
						<td $alignc>$territoryName</td>
						<td $alignc>$inGameCoords</td>
						<td $alignc>$radius</td>
						<td $alignc>$level</td>
						<td $alignc>".date_convert($created_at)."</td>
						<td $alignc>".date_convert($last_paid_at)."</td>
						<td $alignl>$territoryBuilders</td>
						<td $alignc><A href=javascript:popup(\"map.php?name=$usermap&x=$x&y=$y\")><img width=\"20\" height=\"20\" src=\"images/mapico.png\"></A></td>
                        <td><a href=\"territoryedit.php?action=edit&id=$idt\"><img src=\"images/edit.png\" title=\"Edit territory\" width=\"15\" height=\"15\" ></a><a href=\"playeredit.php?action=delete&id=$idt\"><img src=\"images/delete.png\" title=\"delete territory\" width=\"15\" height=\"15\"></a></td></tr>
						</tr>";
            }
            echo "</table>";
            
     
            
            /***************************************************
             * 
             * 
             *              Display Containers
             * 
             * 
             **************************************************/
            
            
        
            $sql2 = "SELECT * FROM container WHERE account_uid = '$uid'";
            $result2 = mysqli_query($link, $sql2);
            $ContainersCount = mysqli_num_rows($result2);

            if (mysqli_num_rows($result2) > 0)
            {
                echo "<hr><h2>Containers ($ContainersCount)</h2><hr>";

                while ($row2 = mysqli_fetch_object($result2))
                {
                    $vehicle = $row2->class;
                    $position_x = $row2->position_x;
                    $x = sprintf('%05d', $position_x);
                    $position_y = $row2->position_y;
                    $y = sprintf('%05d', $position_y);
                    $inGameCoords = substr($position_x, 0, 3) . substr($position_y, 0, 3);
                    $pin_code = $row2->pin_code;
                    $money = $row2->money;
                    $is_locked = $row2->is_locked;
                    $spawned_at = $row2->spawned_at;
                    $last_updated_at = $row2->last_updated_at;
                    
                    if ($is_locked == 0){
                        $is_locked = "<img src=\"images/unlocked.png\" width=\"15\" height=\"15\" title=\"Unlocked\n$pin_code\"></img>";
                    }else{
                        $is_locked = "<img src=\"images/locked.png\" width=\"13\" height=\"15\" title=\"Locked\n$pin_code\"></img>";
                    }
                    
                    $cargo_items = $row2->cargo_items;
                    $cargo_items = expl($cargo_items);
                   
                    $cargo_container = $row2->cargo_container;
                    $cargo_container = expl($cargo_container);
                    
                    $cargo_magazines = $row2->cargo_magazines;
                    $cargo_magazines = expl($cargo_magazines);
                    
                    $contents = "Items: <br/>".convex($cargo_items)."<hr>";
                    $contents .= "Magazines: <br/>".convex($cargo_magazines)."<hr>";
                    $contents .= "Weapons: <br/>".convex($cargo_container)."<hr>";
                    
                    echo "

                    <div class=\"atable\">
                        <table class=\"table\" border=\"1\">
                            <tr>
                                <td width=\"150px\" rowspan=3 colspan=1valign=top $alignl>".strvitems($vehicle)."</td>
                                <td width=\"40px\" $valignc $alignc><img src=\"images/ask.png\" title=\"Last Acces.:".date_convert($last_updated_at)."\nBought.:".date_convert($spawned_at)."\" width=\"20\" height=\"20\"></td>
                                <td width=\"120px\" rowspan=3 colspan=1 valign=top $alignl>$contents Money : $money</td>
                          </tr>
                          <tr>
                             <td $valignc $alignc><A href=javascript:popup(\"map.php?name=$usermap&x=$x&y=$y\")><img width=\"20\" height=\"20\" src=\"images/mapico.png\"></A>
                          </tr>
                          <tr>
                             <td $valignc $alignc>$is_locked</td>
                          </tr>
                        </table>
                    </div>";
    
    
                }
            }
            else
            {
                echo "<h2>This accounts has no containers</h2>";
            }
            echo "</table></div>";



            /***************************************************
             *
             *
             *              Display Vehicles
             *
             *
             **************************************************/
            
            
            
            
            
            $sql2 = "SELECT * FROM vehicle WHERE account_uid = '$uid'";
            $result2 = mysqli_query($link, $sql2);
            $VehiclesCount = mysqli_num_rows($result2);

            if (mysqli_num_rows($result2) > 0)
            {
                echo "<hr><h2>Vehicles ($VehiclesCount)</h2><hr>";

                while ($row2 = mysqli_fetch_object($result2))
                {
                    $vehicle = $row2->class;
                    $position_x = $row2->position_x;
                    $x = $row2->position_x;
                    $position_x = sprintf('%05d', $position_x);
                    $position_y = $row2->position_y;
                    $y = $row2->position_y;
                    $position_y = sprintf('%05d', $position_y);
                    $inGameCoords = substr($position_x, 0, 3) . substr($position_y, 0, 3);
                    $pin_code = $row2->pin_code;
                    $is_locked = $row2->is_locked;
                    $money = $row2->money;
                    $spawned_at = $row2->spawned_at;
                    if (!isset($row2->last_updated_at))
                    {
                        $last_updated = "n/a";
                    }
                    else
                    {
                        $last_updated = $row2->last_updated_at;
                    }
                    
                    if ($is_locked == 0){
                        $is_locked = "<img src=\"images/unlocked.png\" width=\"15\" height=\"15\" title=\"Unlocked\n$pin_code\"></img>";
                    }else{
                        $is_locked = "<img src=\"images/locked.png\" width=\"13\" height=\"15\" title=\"Locked\n$pin_code\"></img>";
                    }
    
                    
                    $cargo_items = $row2->cargo_items;
                    $cargo_items = expl($cargo_items);
                    
                    $cargo_container = $row2->cargo_container;
                    $cargo_container = expl($cargo_container);
                    
                    $cargo_magazines = $row2->cargo_magazines;
                    $cargo_magazines = expl($cargo_magazines);
         
                    
                    $contents = "Items: <br/>".convex($cargo_items)."<br/><hr>";
                    $contents .= "Magazines: <br/>".convex($cargo_magazines)."<br/><hr>";
                    $contents .= "Weapons: <br/>".convex($cargo_container)."<br/><hr>";
                    
                    echo "<div class=\"atable\">
                            <table class=\"table\" border=\"1\">
                                <tr >
                                    <td width=\"150px\" rowspan=3 colspan=1valign=top $alignl >".strvitems($vehicle)."</td>
                                    <td width=\"40px\" $valignc $alignc>$is_locked</td>
                                    <td width=\"120px\" rowspan=3 colspan=1 valign=top $alignl>$contents  Money : $money</td>
                                </tr>
                                <tr>
                                    <td $valignc $alignc><A href=javascript:popup(\"map.php?name=$usermap&x=$x&y=$y\")><img width=\"20\" height=\"20\" src=\"images/mapico.png\"></A>
                                    </td>
                                </tr>
                                <tr>
                                    <td $valignc $alignc><img src=\"images/ask.png\" title=\"Last Upd.:".date_convert($last_updated)."\nBought.:".date_convert($spawned_at)."\" width=\"20\" height=\"20\">
                                    </td>
                                </tr>
                                </table>
                            </div>";
                    
       
                }
       
	
            }
            else
            {
                echo "<h2>This accounts has no vehicles</h2><hr>";
            }
	
        }
       
       
	}

	include "includes/footer.php";
	
	?>