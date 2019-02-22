<?php
include "includes/config.php";
include "includes/header.php";




if ((isset($_GET['action']) && isset($_GET['uid'])) || (isset($_POST['action']) && isset($_POST['uid'])))
{
    if(isset($_GET['action']) && isset($_GET['uid']))
	{
		$action = $_GET['action'];
		$uid = $_GET['uid'];	
	}
	else
	{
		$action = $_POST['action'];
		$uid = $_POST['uid'];	
	}
	

	
	if($action == 'delete')
	{
		$sql = "SELECT * FROM account WHERE uid = '$uid'";
		$result = mysqli_query($link, $sql);
		$row = mysqli_fetch_object($result);
		
		$steam64id = '<a href="http://steamcommunity.com/profiles/' . $uid . '" target=_blank>' . $uid . '</a>';
		$name = $row->name;
	
		
		echo '<div>
				<div>

					<h2>Confirm Character Delete:</h2>
				 
					<form method="post" action="playeredit.php" name="myform">
						
						<p style="width:100%;padding-top:5px;padding-bottom:5px;">
							<h2>'.$name.' ('.$steam64id.')</h2>
							<input type="hidden" name="uid" value="'.$uid.'">
							<input type="hidden" name="action" value="deleteconfirmed">
							<input type="hidden" name="submitok" value="true"><br><br>
							<input type="submit" value="Confirm Delete"><br><br><a href="playersearch.php?searchtype=uid&searchfield='.$uid.'">Cancel Delete</a>
						</p>
						</form>

					</div>
				</div>';	
		
	}
	elseif($action == 'deleteconfirmed')
	{
		$sql = "DELETE FROM player WHERE account_uid = '$uid '";
		//echo "<hr>$sql<hr>";
		$result = mysqli_query($link, $sql);
		$msg = "Player deleted";
		$url = "searchplayer.php?&type=uid&value=$uid";
		header("location:". $url);
		
	}	
	elseif($action == 'edit')
	{
		$sql = "SELECT * FROM account WHERE uid = '$uid'";
		$result = mysqli_query($link, $sql);
		$row = mysqli_fetch_object($result);
		
		$name = $row->name;
		$poptabs = $row->locker;
		$respect = $row->score;		
		
		echo '<div>
		      <div>

    			<center><h2>Player Edit:</h2>
    		 
    			<form method="post" action="playeredit.php" name="myform">
    				
    				<p>
    					<span>Lockers:</span>
    					<span>
    						<input class="edit"  type="text" name="poptabs" size=5 id="poptabs" value='.$poptabs.'></input>
    					</span>
    					<br/>
    					<br/>
    					<br/>
    					<span>Respect:</span>
    					<span>
    						<input class="edit" type="text" name="respect" size=5 id="respect" value='.$respect.'></input>
    					</span>
    					<input type="hidden" name="uid" value="'.$uid.'">
    					<input type="hidden" name="action" value="update">
    					<input type="hidden" name="submitok" value="true"><br/><br/>  
    					<input type="submit"><input type="reset">
    				</p></center>
    				</form>

			 </div>
			 </div>';		
	}
	elseif($action == 'update' && $_POST['submitok'] == 'true')
	{
		$uidToUpdate = $_POST['uid'];
		$newPoptabs = $_POST['poptabs'];
		$newRespect = $_POST['respect'];
		
		$sql = "UPDATE account SET locker = '$newPoptabs', score = '$newRespect' WHERE uid = '$uidToUpdate'";
		//echo "<hr>$sql<hr>";
		$result = mysqli_query($link, $sql);
		$msg = "Updated pop tab and respect levels";
		$url = "searchplayer.php?type=uid&value=$uid";
		header("location:". $url);
		
	}
	else
	{
		echo "<h1>ERROR</h1>";
	}

}
else
{
	echo "<h1>ERROR1</h1>";
	
}
include 'includes/footer.php';
?>
