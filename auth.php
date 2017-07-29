<?php
require_once('config/database.php');

class auth
{
	static function islogged()
	{
		if (isset($_SESSION['auth']) && isset($_SESSION['auth']['login']) && isset($_SESSION['auth']['password']))
		{
			extract($_SESSION);
			$db = auth::connect_sql();
			$login = $_SESSION['auth']['login'];
			$pwd = $_SESSION['auth']['password'];
			$reponse_user = $db->query('SELECT username FROM users WHERE username = "' . $login . '" ');
			$reponse_pwd = $db->query('SELECT password FROM users WHERE username = "' . $login . '" ');
			$reponse_actif = $db->query('SELECT actif FROM users WHERE username = "' . $login . '" ');
			if ($log = $reponse_user->fetch())
			{
				$req_log = $log;
			}
			if (($pass = $reponse_pwd->fetch()))
			{
				$req_pwd = $pass;
			}
			if (($act = $reponse_actif->fetch()))
			{
				$req_actif = $act;
			}
			if ($req_pwd[0] != $pwd || $req_log[0] != $login || $req_actif[0] == 0)
			{
				return (FALSE);
			}
			else
			{
				return(TRUE);
			}
		}
		else
			return (FALSE);
	}

	function connect_sql()
	{
		global $DB_DSN, $DB_PASSWORD, $DB_USER;
		try
		{
			$db = new PDO($DB_DSN , $DB_USER, $DB_PASSWORD);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return ($db);
		}
		catch (PDOException $e) 
		{
			echo 'Connection failed: ' . $e->getMessage();
		}
	}

	function add_picture($picture)
{
	if (auth::islogged())
	{	
		$db = auth::connect_sql();
		$username = $_SESSION['auth']['login'];
		$name = md5($_SESSION['auth']['login'].microtime());
		$name .= ".png";
		file_put_contents("pictures/users/$name",$picture);
		$values = array($name, $username);
		$req = $db->prepare('INSERT INTO picture (picture, username) VALUES (?, ?)');
		if ($req->execute($values))
		{
			return (TRUE);
		}
		else
			return (FALSE);
	}
	else
		return (FALSE);
}

	function is_like($donnees)
	{
		$db = auth::connect_sql();
		$stmt = $db->prepare("SELECT * FROM likes WHERE id_picture = :id_picture AND username = :username");
		$stmt->bindParam(':id_picture', $donnees['id'], PDO::PARAM_INT);
		$stmt->bindParam(':username', $_SESSION['auth']['login'], PDO::PARAM_INT);
		if ($stmt->execute())
		{
			while ($row = $stmt->fetch()) 
			{
				return (TRUE);
			}
			return (FALSE);
		}
		else
			return (FALSE);
	}

	function count_like($donnees)
	{
		$db = auth::connect_sql();
		$id = $donnees['id'];
		$nbr_like =  $db->query("SELECT COUNT(*) FROM likes WHERE id_picture = $id")->fetchColumn();
		return ($nbr_like);
	}
}
?>