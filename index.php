<?php

    include "includes/config.php";
    include "includes/header.php";


    $sql = "SELECT * FROM account";
    $result = mysqli_query($link, $sql);
    $AccountCount = mysqli_num_rows($result);


    $sql = "SELECT * FROM player";
    $result = mysqli_query($link, $sql);
    $LivePlayerCount = mysqli_num_rows($result);

    $sql = "SELECT SUM(locker) as TotalPoptabs, SUM(score) as TotalRespect, COUNT(player.account_uid) as Players FROM player,account WHERE account.uid = player.account_uid";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_object($result);    
    
    $ActivePlayerPoptabs = round($row->TotalPoptabs);
    $ActivePlayerRespect = round($row->TotalRespect);
    $PlayerCount = $row->Players;

    $AveragePlayerPoptabs = round($ActivePlayerPoptabs / $PlayerCount);
    $AveragePlayerRespect = round($ActivePlayerRespect / $PlayerCount);


    $sql = "SELECT * FROM territory";
    $result = mysqli_query($link, $sql);
    $TerritoryCount = mysqli_num_rows($result);

    $sql = "SELECT * FROM construction";
    $result = mysqli_query($link, $sql);
    $ConstructionCount = mysqli_num_rows($result);

    $sql = "SELECT * FROM container";
    $result = mysqli_query($link, $sql);
    $ContainerCount = mysqli_num_rows($result);

    $sql = "SELECT * FROM vehicle";
    $result = mysqli_query($link, $sql);
    $VehicleCount = mysqli_num_rows($result);

	echo "<center>
        <table class='tform' $bcolor border='1' >
        <tr><td width=50%>Accounts:</td><td width=50% align=right>$AccountCount</td></tr>
        <tr><td>Players:</td><td align=right>$LivePlayerCount</td></tr>
        <tr><td>Poptab Total:</td><td align=right>$ActivePlayerPoptabs</td></tr>
        <tr><td>Poptab Average:</td><td align=right>$AveragePlayerPoptabs</td></tr>
        <tr><td>Respect Total:</td><td align=right>$ActivePlayerRespect</td></tr>
        <tr><td>Respect Average:</td><td align=right>$AveragePlayerRespect</td></tr>
        <tr><td>Territories:</td><td align=right>$TerritoryCount</td></tr>
        <tr><td>Constructions:</td><td align=right>$ConstructionCount</td></tr>
        <tr><td>Containers:</td><td align=right>$ContainerCount</td></tr>
        <tr><td>Vehicles:</td><td align=right>$VehicleCount</td></tr>
        </table></center>";

    include "includes/footer.php";

?>