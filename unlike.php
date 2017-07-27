<?php
session_start();
require("auth.php");
if (auth::isLogged() == FALSE)
{
	 header('Location: index.php');
	 exit();
}
if ($_POST['submit'] == "OK" && is_numeric($_POST['id_pic']))
{
	$user = $_SESSION['auth']['login'];
	$id_pic = $_POST['id_pic'];
	$url = str_replace('/camagru/', '', $_POST['url_actual']);	
	$db = auth::connect_sql();
	$sql = "DELETE FROM likes WHERE id_picture = :id_picture AND username = :username";
	$stmt = $db->prepare($sql);
	$stmt->bindParam(':id_picture', $id_pic, PDO::PARAM_INT);   
	$stmt->bindParam(':username', $user, PDO::PARAM_INT);   
	if ($stmt->execute())
	{
        header("Location: $url");
	}
	else
		echo "ERROR";
}
?>