<?php
header("Content-type: image/png"); //la ligne qui change tout !




if (isset($_GET['x']) && isset($_GET['y']) && isset($_GET['name']))
{
	$x = $_GET['x'];
	$y = $_GET['y'];
	$usermap = $_GET['name'];;
}
elseif(!isset($_GET['x']) || !isset($_GET['y']) || !isset($_GET['name']))
{
	echo "No value defined";
}

if( $usermap == "Tanoa"){
    $image = imagecreatefromjpeg("images/tanoa.jpg");
    
    $xx = ((635 * $x) / 15360); 
    $yy = ((640 * $y) / 15360);
    
    $color = "FF0000";
    $rouge = hexdec(substr($color,0,2));
    $vert = hexdec(substr($color,2,4));
    $bleu = hexdec(substr($color,4,6));
    $couleur = imagecolorallocate($image,$rouge,$vert,$bleu);
    
    imagefilledellipse($image,$xx,$yy,6,6,$couleur);
    imagepng($image);

}elseif( $usermap == "Esseker"){
    $image = imagecreatefromjpeg("images/tanoa.jpg");

    $xx = ((865 * $x) / 12300);
    $yy = ((867 * $y) / 12300);
    
    $color = "FF0000";
    $rouge = hexdec(substr($color,0,2));
    $vert = hexdec(substr($color,2,4));
    $bleu = hexdec(substr($color,4,6));
    $couleur = imagecolorallocate($image,$rouge,$vert,$bleu);
    
    imagefilledellipse($image,$xx,867-$yy,6,6,$couleur);
    imagepng($image);
  
    
}elseif( $usermap == ""){

    
    
}
?>
