<?php
/*
* Start Configuration
*/

//What is your last.fm username of which you would like to get the now playing results from?
$username = "";

//What if your specific last.fm api key?
$api_key = "";

/*
* End Configuration
*/

header("Content-Type: image/png"); 

$info = json_decode(file_get_contents("http://ws.audioscrobbler.com/2.0/?method=user.getrecenttracks&user=".$username."&api_key=".$api_key."&format=json"), true);



$img = @imagecreatefrompng("includes/images/NowPlaying - Background.png");

$text_colour = imagecolorallocate($img, 255, 0, 0); //http://colorpicker.com R(ed)/G(reeb)/B(lue)
$font = 'includes/fonts/KeepCalm.ttf'; 

imagettftext($img, 12, 0, 130, 30, $text_colour, $font, "Song/Track: ".$info['recenttracks']['track'][0]['name']);
imagettftext($img, 12, 0, 130, 50, $text_colour, $font, "Artist(s): ".$info['recenttracks']['track'][0]['artist']['#text']);
imagettftext($img, 12, 0, 130, 70, $text_colour, $font, "Album: ".$info['recenttracks']['track'][0]['album']['#text']);

if($info['recenttracks']['track'][0]['image'][1]['#text'])
{
	$albumC = $info['recenttracks']['track'][0]['image'][1]['#text'];
}
else
{
	$albumC = "includes/images/NoCover.png";
}

copy($albumC, 'includes/images/album.png');

imagepng($img, "includes/images/bg.png");

$dest = imagecreatefrompng('includes/images/bg.png');
$src = imagecreatefrompng('includes/images/album.png');

imagealphablending($dest, false);
imagesavealpha($dest, true);

imagecopymerge($dest, $src, 28, 18, 0, 0, 64, 64, 100);
imagepng($dest);

imagedestroy($dest);
imagedestroy($src);
imagedestroy($img);
?>