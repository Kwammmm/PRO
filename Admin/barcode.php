<?php

$width = 200;
$height = 50;


$image = imagecreatetruecolor($width, $height);


$background = imagecolorallocate($image, 255, 255, 255);
imagefill($image, 0, 0, $background);


$color = imagecolorallocate($image, 0, 0, 0);


$text = "123456789";


imagestring($image, 5, 50, 20, $text, $color);


header("Content-type: image/png");
imagepng($image);


imagedestroy($image);
?>
