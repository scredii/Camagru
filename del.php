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
	$db = auth::connect_sql();
	$sql = "DELETE FROM picture WHERE id = :id_picture AND username = :username";
	$stmt = $db->prepare($sql);
	$stmt->bindParam(':id_picture', $_POST['id_photo'], PDO::PARAM_INT);   
	$stmt->bindParam(':username', $_SESSION['auth']['login'], PDO::PARAM_INT);   
	if ($stmt->execute())
	{
		$url = str_replace('/camagru/', '', $_POST['url_actual']);
        header("Location: $url");
	}
	else
		echo "ERROR";

}
?>