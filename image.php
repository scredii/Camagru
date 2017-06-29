<?php
header("Content-type: image/png");

// header('Location: webcam.php');
// echo $_POST['image'];
$dest = file_get_contents("pictures/site/montage1.png");
// echo $dest;
// $dest = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $dest));
// $dest     = imagecreatefrompng("pictures/site/montage1.png");
// readfile($dest);
// echo $dest;
$tok = md5(time());
$data = $_POST['image'];
$data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
imagecopymerge($data, $dest, 10, 10, 0, 0, 100, 47, 75);
file_put_contents("pictures/users/".$tok.".png", $data);
?>