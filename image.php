<?php
session_start();
require("auth.php");
// header("Location: webcam.php");
// print_r($_POST);
function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct)
{ 
        $cut = imagecreatetruecolor($src_w, $src_h); 
        imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h); 
        imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h); 
        imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct); 
}

if ($_POST['filter'] == "snap")
{
    $src = $_POST['image'];
    $src = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $src));
    file_put_contents("pictures/users/tmp.png", $src);
    $src1 = imagecreatefrompng("pictures/site/filtres/motage2.png");
    $dest =  imagecreatefrompng("pictures/users/tmp.png");
    imagealphablending($src1, false);
    imagesavealpha ($src1, true);
    imagecopymerge_alpha($dest, $src1, imagesx($dest) / 2 - 50, imagesy($dest) / 2 - 60, 0, 0, imagesx($src1), imagesy($src1), 90);
    header("Content-type: image/png");
    imagepng($dest);
    imagedestroy($dest);
    imagedestroy($src1);
    // supprimer l'image temporaire
}

if ($_POST['filter'] == "beer")
{
    $src = $_POST['image'];
    $src = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $src));
    file_put_contents("pictures/users/tmp.png", $src);
    $src1 = imagecreatefrompng("pictures/site/filtres/beer.png");
    $dest =  imagecreatefrompng("pictures/users/tmp.png");
    imagealphablending($src1, false);
    imagesavealpha ($src1, true);
    imagecopymerge_alpha($dest, $src1, imagesx($dest) / 2 - 50, imagesy($dest) / 2 - 60, 0, 0, imagesx($src1), imagesy($src1), 100);
    header("Content-type: image/png");
    imagepng($dest);
    imagedestroy($dest);
    imagedestroy($src1);
    // supprimer l'image temporaire
}

if ($_POST['filter'] == "spliff")
{
    $src = $_POST['image'];
    $src = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $src));
    file_put_contents("pictures/users/tmp.png", $src);
    $src1 = imagecreatefrompng("pictures/site/filtres/blunt.png");
    $dest =  imagecreatefrompng("pictures/users/tmp.png");
    imagealphablending($src1, false);
    imagesavealpha ($src1, true);
    imagecopymerge_alpha($dest, $src1, imagesx($dest) / 2 + 15, imagesy($dest) / 2, 0, 0, imagesx($src1), imagesy($src1), 100);
    ob_start();
    imagepng($dest);
    $image_data = ob_get_contents();
    ob_end_clean();
    $image_data = 'data:image/png;base64,' . base64_encode($image_data);
    if (auth::add_picture($image_data) == TRUE)
    {
        unlink("pictures/users/tmp.png");
        header("Location: webcam.php");
    }
    else
    {
        echo "Error\n";
        unlink("pictures/users/tmp.png");
    }
    imagedestroy($dest);
    imagedestroy($src1);
}


//faire la lecture
    // $src = $_POST['image'];
    // print_r($src);
    // $src = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $src));
    // file_put_contents("pictures/users/tmp.png", $src);
    // $src1 = imagecreatefrompng("pictures/site/filtres/blunt.png");
    // $dest =  imagecreatefrompng("pictures/users/tmp.png");
    // imagealphablending($src1, false);
    // imagesavealpha ($src1, true);
    // $md5 = md5(time());
    // imagecopymerge_alpha($dest, $src1, imagesx($dest) / 2 + 15, imagesy($dest) / 2, 0, 0, imagesx($src1), imagesy($src1), 100);
    // header("Content-type: image/png");
    // imagepng($dest);
    // imagedestroy($dest);
    // imagedestroy($src1);















?>