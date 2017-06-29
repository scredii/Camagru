<?php 
$img = $_POST['canvas'];
print_r($_POST['canvas']);
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
file_put_contents('./pictures/photo_1.png', $data);
echo "Upload OK";
// $file = $upload_dir."image_name.png";
// $success = file_put_contents($file, $data);
// header('Location: '.$_POST['return_url']);
?>