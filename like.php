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
	$already_like = $db->query("SELECT COUNT(*) FROM likes WHERE id_picture = $id_pic AND username = '".$user."'")->fetchColumn();
	if ($already_like == 0)
	{
		$values = array($id_pic, $user);
		$req = $db->prepare('INSERT INTO likes (id_picture, username) VALUES (?, ?)');
		if ($req->execute($values))
		{
			header("Location: $url");
		}
	}
	header("Location: $url");
}
?>