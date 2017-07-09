<!DOCTYPE html>
<html>
    <head>
            <meta charset="utf-8"/>
            <style type="text/css">@import url("./style.css");</style>
            <script type="text/javascript" src="alert.js"></script>
    </head>    
    <header>
<?php
include('header.html');
?>
    </header>
    <body>
            <div class="grandform">
				        <div align="center" class="all_form">
							            <div class="account-form">
                                            <h2>Retrouver mon mot de passe</h2>
	        <form method="POST" action="#" onsubmit="return verifForm(this)">  
	            <input type="mail" id="email" name="email" onblur="verifMail(this)" placeholder="E-mail du compte perdu"/>
                <br>
                <br>
    		    <input type="submit" id="submit" name="submit" value="OK">
	        </form>
        </div>
        </div>
        </div>
    </body>
    <?php include("footer.html"); ?>
</html>

<?php
if ($_POST['submit'] == "OK" && $_POST['email'] != "")
{
    if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    {
		echo "Votre email n'est pas valide";
        echo "<br><br><a href='index.php'>Retourner au menu principal</a>";        
        die();
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
    $email2 = $_POST['email'];
    $reponse_mail = $db->query('SELECT email FROM users WHERE email = "' . $email2 . '" ');
    $token_tmp = $db->query('SELECT token FROM users WHERE email = "' . $email2 . '" ');
    // echo $token_tmp;
    if (($test = $token_tmp->fetch()))
	{
        $titi = $test;
    }
    if (($mail = $reponse_mail->fetch()))
	{
        $subject = "Reinitialiser mon mot de passe";
        $entete = "Camagru - Mot de passe oubliée";
        $message = 'Bienvenue sur Camagru,
        Pour reinitialiser votre mot de passe, veuillez cliquer sur le lien ci dessous
        ou copier/coller dans votre navigateur internet.
        http://localhost:8888/camagru/new_pass.php?key='.urlencode($titi[0]).'&email='.urlencode($email2).'
        
        ---------------
        Ceci est un mail automatique, Merci de ne pas y répondre.';
        
        
        mail($email2, $subject, $message, $entete) ;
	    echo "Un mail de reinitialisation vient de vous etre envoyé";
        echo "<br><br><a href='index.php'>Retourner au menu principal</a>";
	}
    else
    {
        echo "Email non reconnu.\n";
        echo "<br><br><a href='index.php'>Retourner au menu principal</a>";        
        die();
    }
}
// else
// {
//     header("Location: lost.html");
// }
?>