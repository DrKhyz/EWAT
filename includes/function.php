<?php 

function pagination($query,$per_page=10,$page=1,$url='?'){   
    global $link; 
    $query = "SELECT COUNT(*) as `num` FROM {$query}";
    $row = mysqli_fetch_array(mysqli_query($link,$query));
    $total = $row['num'];
    $adjacents = "2"; 
      
    $prevlabel = "< Prev";
    $nextlabel = "Next >";
    $lastlabel = "Last >>";
      
    $page = ($page == 0 ? 1 : $page);  
    $start = ($page - 1) * $per_page;                               
      
    $prev = $page - 1;                          
    $next = $page + 1;
      
    $lastpage = ceil($total/$per_page);
      
    $lpm1 = $lastpage - 1; // //last page minus 1
      
    $pagination = "";
    if($lastpage > 1){   
        $pagination .= "<ul class='pagination'>";
        $pagination .= "<li class='page_info'>Page {$page} of {$lastpage}</li>";
              
            if ($page > 1) $pagination.= "<li><a href='{$url}page={$prev}'>{$prevlabel}</a></li>";
              
        if ($lastpage < 7 + ($adjacents * 2)){   
            for ($counter = 1; $counter <= $lastpage; $counter++){
                if ($counter == $page)
                    $pagination.= "<li><a class='current'>{$counter}</a></li>";
                else
                    $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";                    
            }
          
        } elseif($lastpage > 5 + ($adjacents * 2)){
              
            if($page < 1 + ($adjacents * 2)) {
                  
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='dot'>...</li>";
                $pagination.= "<li><a href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}page={$lastpage}'>{$lastpage}</a></li>";  
                      
            } elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                  
                $pagination.= "<li><a href='{$url}page=1'>1</a></li>";
                $pagination.= "<li><a href='{$url}page=2'>2</a></li>";
                $pagination.= "<li class='dot'>...</li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='dot'>..</li>";
                $pagination.= "<li><a href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}page={$lastpage}'>{$lastpage}</a></li>";      
                  
            } else {
                  
                $pagination.= "<li><a href='{$url}page=1'>1</a></li>";
                $pagination.= "<li><a href='{$url}page=2'>2</a></li>";
                $pagination.= "<li class='dot'>..</li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li><a class='current'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";                    
                }
            }
        }
          
        

        
            if ($page < $counter - 1) {
                $pagination.= "<li><a href='{$url}page={$next}'>{$nextlabel}</a></li>";
                $pagination.= "<li><a href='{$url}page=$lastpage'>{$lastlabel}</a></li>";
            }
          
        
        $pagination.= "</ul>";    

    }
      
    return $pagination;
}

function onmap($x,$y){  

header("Content-type: image/png"); //la ligne qui change tout !

/* on créé l'image en vraies couleurs avec une largeur de 50 pixels et une hauteur de 100 pixels */
$image = imagecreatefromjpeg("images/map.jpg");

$x = $x/10;
$y = $y/10;

$xx = ((1020 * $x) / 1230);
$yy = ((1020 * $y) / 1230) - 15;

$color = "FF0000";
$rouge = hexdec(substr($color,0,2)); //conversion du canal rouge
$vert = hexdec(substr($color,2,4)); //conversion du canal vert
$bleu = hexdec(substr($color,4,6)); //conversion du canal bleu
$couleur = imagecolorallocate($image,$rouge,$vert,$bleu);

/* on créé la couleur et on l'attribue à une variable pour ne pas la perdre */
imagefilledellipse($image,$xx,1024-$yy,10,10,$couleur); //on créé un cercle
return imagepng($image); //renvoie une image sous format png
// imagedestroy($image); //détruit l'image, libérant ainsi de la mémoire


}

function strvitems($values){

   $debug = 0; 
   
   if($debug == 0){
    $values = str_replace('[', "", $values);
    $values = str_replace(']', "", $values);
    $values = str_replace('"', "", $values);
    $values = str_replace('Exile_', "", $values);
    $values = str_replace('Item_', "", $values);
    $values = str_replace('Item', "", $values);
    $values = str_replace('Magazine_', "", $values);
    $values = str_replace('optic_', "", $values);
    $values = str_replace('HelmetO_', "", $values);
    $values = str_replace('LMG_', "", $values);
    $values = str_replace('Weapon_', "", $values);
    $values = str_replace('RUS_', "", $values);
    $values = str_replace('muzzle_snds_', "silencer_", $values);
    $values = str_replace('muzzle_snds38_', "silencer_", $values);
    $values = str_replace('_oli', "_olive", $values);
    $values = str_replace('_ghex', "_Green_Hex", $values);
    $values = str_replace('grn', "_Green", $values);
    $values = str_replace('_blk', "_black", $values);
    $values = str_replace('_dgtl', "_digital", $values);
    $values = str_replace('khk', "_khk", $values);
    $values = str_replace('tna', "_tna", $values);
    $values = str_replace('NV', "Night_Vision_", $values);
    $values = str_replace('O_', "", $values);
    $values = str_replace('H_', "", $values);
    $values = str_replace('CUP_', "", $values);
    $values = str_replace('V_', "", $values);
    $values = str_replace('TI_', "", $values);
    $values = str_replace('B_', "", $values);
    $values = str_replace('C_', "", $values);
    $values = str_replace('U_', "", $values);
    $values = str_replace('T_', "", $values);
    $values = str_replace('I_', "", $values);
    $values = str_replace('_I', "", $values);
    $values = str_replace('_OPFOR', "", $values);
    $values = str_replace('_F', "", $values);
    $values = str_replace('Container_', "", $values);
    $values = str_replace('Land_', "", $values);
    $values = str_replace('_large', "", $values);
    $values = str_replace('_closed', "", $values);
    $values = str_replace('Car_', "", $values);
    $values = str_replace('Plane_', "", $values);
    $values = str_replace('Chopper_', "", $values);
    $values = str_replace('Bike_', "", $values);
    $values = str_replace('Boat_', "", $values);
    $values = str_replace('acc_', "", $values);
    $values = str_replace('hgun_', "", $values);
    $values = str_replace('EBM_', "", $values);
    $values = str_replace('_kit', "", $values);
    $values = str_replace('arifle_', "", $values);
    
    $values = str_replace('_', " ", $values);
   }
    return $values;
	
}

function hitpoints($array){
	return $array;
}

function damage($value){
    $value = round($value * 100);
    if($value < 30){
        $value = "<p style=\"color:#008000\">$value%</p>";
    }elseif($value > 31 && $value < 60 ){
        $value = "<p style=\"color:#E08000\">$value%</p>";
    }else{
        $value = "<p style=\"color:#FF0000\">$value%</p>";
    }
    return $value;
}

function bleed($value){
    if($value >= 1){
        $value = "<p style=\"color:#FF000\">$value</p>";
    }else{
        $value = "<p style=\"color:#008000\">$value</p>";
    }
    return $value;
}

function oxygene($value){
    if($value < 1){
        $value = "<p style=\"color:#FF000\">$value</p>";
    }else{
        $value = "<p style=\"color:#008000\">$value</p>";
    }
    return $value;
}

function fuel($value){
    $value = round($value * 100);
    if($value < 30){
        $value = "<p style=\"color:#FF0000\">$value%</p>";
    }elseif($value > 31 && $value < 60 ){
        $value = "<p style=\"color:#E08000\">$value%</p>";
    }else{
        $value = "<p style=\"color:#008000\">$value%</p>";
    }
    return $value;
}

function health($value){
    $value = round($value);
    if($value < 30){
        $value = "<p style=\"color:#FF0000\">$value%</p>";
    }elseif($value > 31 && $value < 60 ){
        $value = "<p style=\"color:#E08000\">$value%</p>";
    }else{
        $value = "<p style=\"color:#008000\">$value%</p>";
    }
    return $value;
}

function temp($value){
    $value = round($value, 1, PHP_ROUND_HALF_DOWN);
	if($value < 37){
	    $value = "<p style=\"color:#FF000\">$value</p>";
	}else{
	    $value = "<p style=\"color:#008000\">$value</p>";
	}
	return $value;
}

function expl($values){
    
    $values = explode(",", $values);
    return strvitems($values);

}

function grpstvr($values){
    
    $values = str_replace(',', "<br/>", $values);
    $values = $values."<br/>";
    return strvitems($values);
    
}


function convex($values){

    $values_f ="";
    $nombre = "";
    $occurence = "";
    
    foreach ($values as $value)
    {
        if(isset($nombre[$value])){
            $nombre[$value]++;
        }
        else{
            $nombre[$value]=1;
        }
    }
    
    foreach ($nombre as $occurence => $nombres)
    {
        if(is_numeric($nombres) AND !empty($occurence) AND !is_numeric($occurence)){
            $values_f .= $nombres ." x ".strvitems($occurence)."<br/>";
        }
        
    }
    
    if (!empty($values_f)){
        return "<a href=\"javascript:;\" onClick=\"this.nextSibling.style.display=((this.nextSibling.style.display=='none')?'':'none');\">Cargo</a><span style=\"display: none;\">$values_f</span>";
    }else{
        return "<br/>";
    }
    
}



function convexd($values){
    
    $values_f ="";
    $nombre = "";
    $occurence = "";
    
    foreach ($values as $value)
    {
        if(isset($nombre[$value])){
            $nombre[$value]++;
        }
        else{
            $nombre[$value]=1;
        }
    }
    
    foreach ($nombre as $occurence => $nombres)
    {
        if(is_numeric($nombres) AND !empty($occurence) AND !is_numeric($occurence)){
            $values_f .= $nombres ." x ".$occurence."<br/>";
        }
        
    }
    
    if (!empty($values_f)){
        return "$values_f";
    }else{
        return "<br/>";
    }
    
}



function date_convert($date){
$formatter = new IntlDateFormatter('en_EN',IntlDateFormatter::MEDIUM,
    IntlDateFormatter::SHORT,
    'Europe/Paris',
    IntlDateFormatter::TRADITIONAL,
    'EEE d MMM HH:mm:ss');
$date =new DateTime($date);
$output = $formatter->format($date);
return $output;
}

// align td / tr

$alignl = 'align=left style="padding:8px;font-size:11px";';
$alignr = 'align=right style="padding:8px;font-size:11px";';
$alignc = 'align=center style="padding:8px;font-size:11px";';

$valignc = 'valign=center';

$bcolor = "style='background-color:black;'";

?>