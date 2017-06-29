<?php
//certif ssl
session_start();
if ($_POST['submit'] == 'OK' && $_POST['login'] != "" && $_POST['passwd'] !=  "")
{
    $errors = [];
    $login = $_POST['login'];
    $pwd = hash('whirlpool', $_POST['passwd']);
    if(empty($_POST['login']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['login']))
    {
        $errors['username'] = "votre pseudo n'est pas valide (Alphanumérique)";
        exit();
    }
    try
    {
        $db = new PDO('mysql:host=localhost;dbname=cama_base','root','root');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) 
    {
        echo 'Connection failed: ' . $e->getMessage();
    }
    if(empty($errors))
    {
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
        if ($req_pwd[0] != $pwd || $req_log[0] != $login)
        {
            header("Location: index.php");
            exit();
        }
        if ($req_actif[0] == 0)
        {
            echo "Merci d'activer votre compte avant de pouvoir vous connecter";
            echo "<br><a href='http://localhost:8888/camagru/index.php/'>Retourner au menu principal</a>";
            exit();
        }
        else
        {
            $_SESSION['auth'] = array('login' => $login, 'password' => $pwd);
            header("Location: webcam.php");
            exit();
        }
        
    }
}
else
    header("Location: index.php");
?>