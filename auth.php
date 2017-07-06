<?php

class auth
{
	static function islogged()
	{
		if (isset($_SESSION['auth']) && isset($_SESSION['auth']['login']) && isset($_SESSION['auth']['password']))
		{
			extract($_SESSION);
			$login = $_SESSION['auth']['login'];
			$pwd = $_SESSION['auth']['password'];
			try
			{
				$db = new PDO('mysql:host=localhost;dbname=cama_base','root','root');
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch (PDOException $e) 
			{
				echo 'Connection failed: ' . $e->getMessage();
			}
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

	function add_picture($picture)
{
	if (auth::islogged())
	{
		$username = $_SESSION['auth']['login'];
		try
		{
			$db = new PDO('mysql:host=localhost;dbname=cama_base','root','root');
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (PDOException $e) 
		{
			echo 'Connection failed: ' . $e->getMessage();
		}
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

	function see_picture()
	{
		try
		{
			$db = new PDO('mysql:host=localhost;dbname=cama_base','root','root');
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (PDOException $e) 
		{
			echo 'Connection failed: ' . $e->getMessage();
		}
		$picture = $db->query('SELECT * FROM picture');
		if (($test = $picture->fetch()))
		{
			$titi = $test;
		}
		return($titi);
	}

	function connect_sql()
	{
		try
		{
			$db = new PDO('mysql:host=localhost;dbname=cama_base','root','root');
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (PDOException $e) 
		{
			echo 'Connection failed: ' . $e->getMessage();
		}
	}
}

// function add_picture($picture)
// {
//     // if (auth::islogged())
//     // {
//         print_r($_SESSION);
//         $username = $_SESSION['auth']['login'];
//         try
//         {
//             $db = new PDO('mysql:host=localhost;dbname=cama_base','root','root');
//             $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         }
//         catch (PDOException $e) 
//         {
//             echo 'Connection failed: ' . $e->getMessage();
//         }
//         $values = array($picture, $username);
// 		$req = $db->prepare('INSERT INTO picture (picture, username) VALUES (?, ?)');
// 		if ($req->execute($values))
//             return (TRUE);
//         else
//             return (FALSE);
//     // }
//     // else
//     //     return (FALSE);
// }
?>