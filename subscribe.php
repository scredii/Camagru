<html>
    <header>
            <a class="tit" href="http://localhost:8888/camagru/index.php"><img class="cama" src="pictures/site/cama_log.png" alt="camagru_logo"></a><br/><br/>
            <style type="text/css">@import url("./style.css");</style>
            <title>Camagru</title>
            <script type="text/javascript" src="alert.js"></script>
    </header>
    <body>
        <center>
            <div align="center" class="all_form">
	        	<form method="POST" action="#" onsubmit="return verifForm(this)"> 
                	<label for="email">E-mail: </label><input type="mail" id="email" name="email" onblur="verifMail(this)"/>
					<br/>
                	<br/> 
					<label for="username">Pseudo: </label><input type="text" id="username" name="username" onblur="verifPseudo(this)"/>
					<br>
					<br/>
					<label for="password">Password: </label><input onblur="verifPasswd(this)" type="password" id="password" name="password"/>
					<br>
					<br/>
					<label for="password_confirm">Confirmer password:</label><input onblur="verifPasswd(this)" type="password" name="password_confirm" id="password_confirm"/>
					<br>
					<br/>
					<div class="submit">
					<input type="submit" id="submit" name="submit" value="OK">
    	    	</form>
        	</div>
        </center>
        <div class="lost_account">
            <a id="create_account" href="http://localhost:8888/camagru/index.php">Retour</a>
        </div>
    </body>
	<?php include("footer.html"); ?>
</html>

<?php
session_start();
require("auth.php");
if ($_POST['submit'] == "OK" && $_POST['password'] != "" && $_POST['email'] != "" && $_POST['username'] != "" && $_POST['password_confirm'] != "")
{
		$errors = [];
		$actif = 0;
		$token = md5(microtime(TRUE)*100000);
		if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{3,15}$/', $_POST['password'])){
			$errors['password'] = "format(3/15 caracts, au moins 1 maj et 1 chiffre)";
			exit();
		}
		$pwd = hash('whirlpool', $_POST['password']);
		$email = $_POST['email'];
		$username = $_POST['username'];
		try
		{
			$db = new PDO('mysql:host=localhost;dbname=cama_base','root','root');
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (PDOException $e) 
    	{
        	echo 'Connection failed: ' . $e->getMessage();
    	}
		if(empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username']))
			$errors['username'] = "votre pseudo n'est pas valide (Alphanumérique)";
		if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
			$errors['email'] = "Votre email n'est pas valide";
		if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm'])
			$errors['password'] = "Vous devez rentrer un mot de passe valide";
		if(empty($errors))
		{
			$reponse_user = $db->query('SELECT username FROM users WHERE username = "' . $username . '" ');
			$reponse_mail = $db->query('SELECT email FROM users WHERE email = "' . $email . '" ');
			if ($login = $reponse_user->fetch())
			{
				echo $username." pseudo déja utilisé";
			}
			else if (($mail = $reponse_mail->fetch()))
			{
				echo "Vous etes deja enregistré";
				// LIEN mailPOUR RECUPERER SON MOT DE PASSE
			}
			else
			{
				$values = array($username, $email, $pwd, $token, $actif);
				$req = $db->prepare('INSERT INTO users (username, email, password, token, actif) VALUES (?, ?, ?, ?, ?)');
				if ($req->execute($values))
				{
					$subject = "Activer votre compte" ;
					$entete = "Camagru - Inscription" ;
					$message = 'Bienvenue sur Camagru,
					Pour activer votre compte, veuillez cliquer sur le lien ci dessous
					ou copier/coller dans votre navigateur internet.
					http://localhost:8888/camagru/validation.php?login='.urlencode($username).'&key='.urlencode($token).'
					
					---------------
					Ceci est un mail automatique, Merci de ne pas y répondre.';
					
					
					mail($email, $subject, $message, $entete) ;
					echo "Veuillez valider l'inscription avec le mail qui vient de vous etre envoyé";
				}
				else
					echo "une erreur est survenue lors de l'insertion";
			}
		}
		else
		{
			echo "<pre>";
			print_r($errors);
			echo "</pre>";
		}
}
else
	header("Location: subscribe.html")
?>