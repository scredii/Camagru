<!DOCTYPE html>
<html>
    <head>
            <meta charset="utf-8"/>
            <style type="text/css">@import url("./style.css");</style>
            <script type="text/javascript" src="alert.js"></script>
    </head>    
    <header>
<?php
include('header1.php');
?>
    </header>
<?php
    require("auth.php");

    $db = auth::connect_sql();
    $key_tmp = $_GET['key'];
    $mail_tmp = $_GET['email'];
    $req = $db->prepare("SELECT token,email FROM users WHERE email like :email ");
    if($req->execute(array(':email' => $mail_tmp)) && $row = $req->fetch())
    {
        $tok = $row['token'];
        $rmail = $row['email'];
    }
    if($tok == $key_tmp && $mail_tmp ==  $rmail)
    {
        echo "		<div class='grandform'>
			<div align='center' class='all_form'>
				<div class='account-form'>
                <h2>Nouveau mot de passe</h2>
        <form method='POST' action='new_pass.php?key='.urlencode($tok).'> 
            <input type='text' id='username' name='login' placeholder='Login'/>
            <br>
            <input id='password' type='password' name='password' placeholder='Password'/>
            <br>
            <input id='password' type='password' name='confirm_password' placeholder='Confirm password'/>
            <br>
            <input type='hidden' name='token' value='$tok' />
    	    <input type='submit' name='submit' id='submit' value='OK'>
        </form>";
        if ($_POST['submit'] == 'OK' && $_POST['password'] == $_POST['confirm_password'])
        {   
            $tok = $_POST['token'];
            $log = $_POST['login'];
            if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{3,15}$/', $_POST['password']))
            {
			    echo "format(3/15 caracts, au moins 1 maj et 1 chiffre)";
			    exit();
		    }
            $pwd = hash('whirlpool', $_POST['password']);
            $reponse_user = $db->query('SELECT username FROM users WHERE username = "' . $log . '" ');
            $reponse_tok = $db->query('SELECT token FROM users WHERE username = "' . $log . '" ');
            if ($tmp = $reponse_user->fetch())
			{
				$username = $tmp;
			}
            if ($tmp2 = $reponse_tok->fetch())
			{
				$user_tok = $tmp2;
			}
            if ($tok != $user_tok[0] || $username[0] != $log)
            {
                echo "Error";
                die();
            }
            $values = array(
		    'username' => $log,
		    'password' => $pwd,
            'token' => $tok
		        );
            $req = $db->prepare('UPDATE users SET `password` = :password WHERE `username` = :username AND `token` = :token');
			if ($req->execute($values))
			{
                echo "Mot de passe modifié avec succés";
                exit();
            }
            else
                echo "Impossible de modifier le mot de passe";
        }
    }
    else
        echo "Error\n";
?>