<?php
include "includes/config.php";
include "includes/header.php";




if ((isset($_GET['action']) && isset($_GET['id'])) || (isset($_POST['action']) && isset($_POST['id'])))
{
    if(isset($_GET['action']) && isset($_GET['id']))
	{
		$action = $_GET['action'];
		$id = $_GET['id'];	
	}
	else
	{
		$action = $_POST['action'];
		$id = $_POST['id'];	
	}
	

	
	if($action == 'delete')
	{
		$sql = "SELECT * FROM territory WHERE id = '$id'";
		$result = mysqli_query($link, $sql);
		$row = mysqli_fetch_object($result);
		
		$territoryName = $row->name;
		$idt = $row->id;
	
		
		echo '<div>
				<div>

					<h2>Confirm Territory Delete:</h2>
				 
					<form method="post" action="territoryedit.php" name="myform">
						
						<p style="width:100%;padding-top:5px;padding-bottom:5px;">
							<h2>'.$territoryName.')</h2>
							<input type="hidden" name="id" value="'.$id.'">
							<input type="hidden" name="action" value="deleteconfirmed">
							<input type="hidden" name="submitok" value="true"><br><br>
							<input type="submit" value="Confirm Delete"><br><br><a href="territories.php">Cancel Delete</a>
						</p>
						</form>

					</div>
				</div>';	
		
	}
	elseif($action == 'deleteconfirmed')
	{
		$sql = "DELETE FROM territory WHERE id = '$id '";
		$result = mysqli_query($link, $sql);
		$msg = "Territory deleted";
		$url = "territory.php";
		header("location:". $url);
		
	}	
	elseif($action == 'edit')
	{

	    $sql = "SELECT * FROM territory WHERE id = '$id'";
	    $result = mysqli_query($link, $sql);
	    $row = mysqli_fetch_object($result);
		
	    $id = $row->id;
		$territoryName = $row->name;
		
		echo '<div>
		      <div>

    			<center><h2>Territory Edit:</h2>
    		 
    			<form method="post" action="territoryedit.php" name="myform">
    				
    				<p>
    					<span>Name:</span>
    					<span>
    						<input class="nedit" type="text" name="territoryName" id="territoryName" value="'.$territoryName.'"></input>
    					</span>
    					

    					<input type="hidden" name="id" value="'.$id.'">
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
	    $id = $_POST['id'];
		$territoryName = $_POST['territoryName'];
		
		$sql = "UPDATE territory SET name = '$territoryName' WHERE id = '$id'";
		$result = mysqli_query($link, $sql);
		$msg = "Territory updated";
		$url = "territories.php";
		header("location:". $url);
		
	}
	else
	{
		echo "<h1>ERROR</h1>";
	}

}
else
{
	echo "<h1>ERROR</h1>";
	
}
include 'includes/footer.php';
?>
