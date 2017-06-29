<?php
    // header('Refresh: 3;URL=http://localhost:8888/camagru/index.php');
    try
    {
        $db = new PDO('mysql:host=localhost;dbname=cama_base','root','root');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) 
    {
        echo 'Connection failed: ' . $e->getMessage();
    }
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
        echo "
        <form method='POST' action='new_pass.php?key='.urlencode($tok).'> 
            pseudo: <input type='text' name='login'/>
            <br>
            Nouveau mot de passe: <input type='password' name='password'/>
            <br>
            Confirmez le mot de passe: <input type='password' name='confirm_password'/>
            <br>
            <input type='hidden' name='token' value='$tok' />
    	    <input type='submit' name='submit' value='OK'>
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
            try
		    {
			    $db = new PDO('mysql:host=localhost;dbname=cama_base','root','root');
			    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    }
            catch (PDOException $e) 
    	    {
        	    echo 'Connection failed: ' . $e->getMessage();
    	    }
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
        echo "probleme";
?>