<?php
session_start();
require("auth.php");
if (auth::isLogged() == FALSE)
{
  header('Location: index.php');
  exit();
}
if ($_POST['submit'] == "OK")
{
	$id = $_POST['id_photo'];
	$username = $_SESSION['auth']['login'];
	$db = auth::connect_sql();
	$reponse_user = $db->query('SELECT picture FROM picture WHERE id = '.$id.'')->fetch();
	$sql = "DELETE FROM picture WHERE id = :id_picture AND username = :username";
	$stmt = $db->prepare($sql);
	$stmt->bindParam(':id_picture', $_POST['id_photo'], PDO::PARAM_INT);   
	$stmt->bindParam(':username', $_SESSION['auth']['login'], PDO::PARAM_INT);   
	if ($stmt->execute())
	{
		$url = str_replace('/camagru/', '', $_POST['url_actual']);
		unlink("pictures/users/".$reponse_user['picture']."");
		$sql = "DELETE FROM likes WHERE id_picture = :id_picture AND username = :username";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':id_picture', $_POST['id_photo'], PDO::PARAM_INT);   
		$stmt->bindParam(':username', $_SESSION['auth']['login'], PDO::PARAM_INT);   
		if ($stmt->execute())
		{
			$sql = "DELETE FROM comments WHERE id_picture = :id_picture";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':id_picture', $_POST['id_photo'], PDO::PARAM_INT);   
			if ($stmt->execute())
			{
				header("Location: $url");
			}
			else
				echo "ERROR";
		}
	}
	else
		echo "ERROR";
}
?>