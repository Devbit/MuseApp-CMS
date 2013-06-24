<?php
function resize_image($FileName,$SaveFile, $MaxWidth = null, $MaxHeight) {

    $extension = GetFileExtension($FileName);

    switch(strtolower($extension)) {
        case "gif":
            $objImage = imagecreatefromgif($FileName);
            break;
        case "png":
            $objImage = imagecreatefrompng($FileName);
            break;
        default:
            $objImage = imagecreatefromjpeg($FileName);
            break;
    }

    list($oldwidth, $oldheight, $type, $attr) = getimagesize($FileName);
	$width = $oldwidth;
	$height = $oldheight;
	if (($MaxWidth == null) && isset($MaxHeight)) {
		$ratio = $MaxHeight / $oldheight;
		$TargetHeight = $MaxHeight;
		
		$TargetWidth = $oldwidth * $ratio;
	}


    $DestImage = imagecreatetruecolor($TargetWidth, $TargetHeight);

    // handle transparancy    
    if ( ($type == IMAGETYPE_GIF) || ($type == IMAGETYPE_PNG) ) {
        $trnprt_indx = imagecolortransparent($objImage);
        // If we have a specific transparent color
        if ($trnprt_indx >= 0) {
            // Get the original image's transparent color's RGB values
            $trnprt_color  = imagecolorsforindex($objImage, $trnprt_indx);
            // Allocate the same color in the new image resource
            $trnprt_indx    = imagecolorallocate($DestImage, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);

            // Completely fill the background of the new image with allocated color.
            imagefill($DestImage, 0, 0, $trnprt_indx);

            // Set the background color for new image to transparent
            imagecolortransparent($DestImage, $trnprt_indx);
        } elseif ($type == IMAGETYPE_PNG) {

            // Turn off transparency blending (temporarily)
            imagealphablending($DestImage, false);

            // Create a new transparent color for image
            $color = imagecolorallocatealpha($DestImage, 0, 0, 0, 127);

            // Completely fill the background of the new image with allocated color.
            imagefill($DestImage, 0, 0, $color);

            // Restore transparency blending
            imagesavealpha($DestImage, true);
        }
    }



    imagecopyresampled($DestImage, $objImage, 0, 0, 0, 0, $TargetWidth, $TargetHeight, $width, $height);
    switch(strtolower($extension)) {
        case "gif":
            imagegif($DestImage, $SaveFile);
            break;
        case "png":
            imagepng($DestImage, $SaveFile,0);
            break;
        default:
            imagejpeg($DestImage,$SaveFile,70);
            break;
    }

}
function GetFileExtension($inFileName) {
    return substr($inFileName, strrpos($inFileName, '.') + 1);
}
$uploadpath = '../appimages/';      // directory to store the uploaded files
$max_size = 5000;          // maximum file size, in KiloBytes
$alwidth = 5000;            // maximum allowed width, in pixels
$alheight = 5000;           // maximum allowed height, in pixels
$allowtype = array('gif', 'jpg', 'jpeg', 'png');        // allowed extensions
if(isset($_FILES['fileup']) && strlen($_FILES['fileup']['name']) > 1) {
	
  $sepext = explode('.', strtolower($_FILES['fileup']['name']));
  $type = end($sepext);       // gets extension
  list($width, $height) = getimagesize($_FILES['fileup']['tmp_name']);     // gets image width and height
	$err = '';  
  // Checks if the file has allowed type, size, width and height (for images)
  if(!in_array($type, $allowtype)){$errors[] = 'Het bestand: <b>'. $_FILES['fileup']['name']. '</b> heeft niet de juiste extensie.';$err =1;}
  if($_FILES['fileup']['size'] > $max_size*1000) {$errors[] = 'De maximale bestandsgrote is : '. $max_size. ' KB.';$err =1;}
  if(isset($width) && isset($height) && ($width >= $alwidth || $height >= $alheight)) {$errors[] = 'De maximale breedte x hoogte moet: '. $alwidth. ' x '. $alheight . ' zijn.';$err =1;}

  // If no errors, upload the image, else, output the errors
  if($err == '') {
	// Generate random string
	$s = explode(".",$_FILES['fileup']['name']);
	$name = strip_tags($s[0]);
	$name = str_replace(' ', '', $name);
	global $newurl;
	$newurl = $uploadpath.$name.'.'.$type;
	$num = 0;
	do{
		if ($num == 0)
		$newurl = $uploadpath.$name.'.'.$type;
		else
		$newurl = $uploadpath.$name.$num.'.'.$type;
		$num++;
	}
	while(file_exists($newurl));
	if(move_uploaded_file($_FILES['fileup']['tmp_name'], $newurl)) {
		  if (function_exists('database')){database($newurl);}
		}
    else {$errors[] = 'Uploaden niet gelukt.';$err =1;}
	resize_image($newurl,"../appthumbs/".basename($name.'.'.$type),null,405);
  }
}
?>