<?php
session_start();
require("auth.php");

// the real function is not working
function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct)
{ 
        $cut = imagecreatetruecolor($src_w, $src_h); 
        imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h); 
        imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h); 
        imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct); 
}

function add_filter($dest, $choice)
{
    if (!$choice)
        return ($dest);
    if ($choice == 1)
    {
        // $valeur= -50;
        // imagefilter($dest,IMG_FILTER_CONTRAST,$valeur);
        imagefilter($dest,IMG_FILTER_COLORIZE,0,-100,0);
        //   imagefilter($dest, IMG_FILTER_GAUSSIAN_BLUR);
        return ($dest);
    }
    else
        return ($dest);
}

// check PNG and real PNG
function check_format($src)
{
        $extension_upload = strtolower(substr(strrchr($src['upload_photo']['name'], '.'),1));
        if ($extension_upload != "png")
            exit("Extension incorrecte");
        list($witdh, $height) = getimagesize($src['upload_photo']['tmp_name']);
        $test = file_get_contents($src['upload_photo']['tmp_name']);
        if ($witdh == 0|| $height == 0)
            exit("Format non supporte ou erreur lors de l'upload de la photo");
}

// check file or webcam
function is_post_file($file)
{
    if (!empty($file['upload_photo']['tmp_name'] || !empty($file['upload_photo']['name'])))
        return (TRUE);
    else
        return (FALSE);
}

if ($_POST['filter'] == "snap")
{
    if ($_POST['filter2'])
        $choice = $_POST['filter2'];
    if (is_post_file($_FILES) == FALSE)
    {
        $src = $_POST['image'];
    }
    else
    {
        check_format($_FILES);
        $src = file_get_contents($_FILES['upload_photo']['tmp_name']);
        $src = 'data:image/png;base64,' . base64_encode($src);
    }
    $src = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $src));
    file_put_contents("pictures/users/tmp.png", $src);
    $src1 = imagecreatefrompng("pictures/site/filtres/motage2.png");
    $dest =  imagecreatefrompng("pictures/users/tmp.png");
    imagealphablending($src1, false);
    imagesavealpha ($src1, true);
    imagecopymerge_alpha($dest, $src1, imagesx($dest) / 2 - 50, imagesy($dest) / 2 - 60, 0, 0, imagesx($src1), imagesy($src1), 90);
    $dest = add_filter($dest, $choice);
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

if ($_POST['filter'] == "beer")
{
    if ($_POST['filter2'])
        $choice = $_POST['filter2'];
    if (is_post_file($_FILES) == FALSE)
    {
        $src = $_POST['image'];
    }
    else
    {
        check_format($_FILES);
        $src = file_get_contents($_FILES['upload_photo']['tmp_name']);
        $src = 'data:image/png;base64,' . base64_encode($src);
    }
    $src = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $src));
    file_put_contents("pictures/users/tmp.png", $src);
    $src1 = imagecreatefrompng("pictures/site/filtres/beer.png");
    $dest =  imagecreatefrompng("pictures/users/tmp.png");
    imagealphablending($src1, false);
    imagesavealpha ($src1, true);
    imagecopymerge_alpha($dest, $src1, imagesx($dest) / 2 - 50, imagesy($dest) / 2 - 60, 0, 0, imagesx($src1), imagesy($src1), 100);
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

if ($_POST['filter'] == "spliff")
{
    if ($_POST['filter2'])
        $choice = $_POST['filter2'];
    if (is_post_file($_FILES) == FALSE)
    {
        $src = $_POST['image'];
    }
    else
    {
        check_format($_FILES);
        $src = file_get_contents($_FILES['upload_photo']['tmp_name']);
        $src = 'data:image/png;base64,' . base64_encode($src);
    }
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
?>