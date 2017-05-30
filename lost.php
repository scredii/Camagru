<?php
if ($_POST['submit'] == "OK" && $_POST['email'] != "")
{
    $errors = [];
    if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    {
		$errors['email'] = "Votre email n'est pas valide";
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
	}
    else
    {
        echo "Email non reconnu.\n";
        die();
    }
}
else
{
    echo "Mail non valide";
}
?>