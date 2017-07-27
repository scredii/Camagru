<?php
session_start();
require("auth.php");
if (auth::isLogged() == FALSE)
{
 	header('Location: galery.php');
	 exit();
    // echo "Veuillez vous connecter\n";
}
if ($_POST['comments'] != "" && $_POST['submit'] == "OK" && $_SESSION['auth'])
{
    //PROTEGER LES COMM RECUS CONTRE INJECTIONS
    //PROTEGER LES COMM RECUS CONTRE INJECTIONS
    //PROTEGER LES COMM RECUS CONTRE INJECTIONS
    try
    {
        $db = new PDO('mysql:host=localhost;dbname=cama_base','root','root');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) 
    {
        echo 'Connection failed: ' . $e->getMessage();
    }
    $id_picture = $_POST['id_photo'];
	$id_prop = $_POST['user_photo'];
    $username = $_POST['username'];
    $comment = $_POST['comments'];
    $date = date("Y-m-d H:i:s");
    $values = array($id_picture, $username, $comment, $date);
	$req = $db->prepare('INSERT INTO comments (id_picture, username, comments, date_comm) VALUES (?, ?, ?, ?)');
	if ($req->execute($values))
    {
		// Mettre le bon URL dans le MAIL 
		$reponse_mail = $db->query('SELECT email FROM users WHERE username = "' . $id_prop . '" ')->fetch();
        $url = str_replace('/camagru/', '', $_POST['url_actual']);
        $subject = "Vous avez recu un nouveau commentaire !" ;
        $entete = "Camagru - Nouveau commentaire" ;
        $message = 'Du nouveau sur Camagru,
        Vous avez recu un nouveau commentaire, cliquez sur le lien suivant pour le consulter:
        '. $_POST["url_actual"].'
        ---------------
        Ceci est un mail automatique, Merci de ne pas y répondre.';
        
        
        mail($reponse_mail[0], $subject, $message, $entete) ;
        header("Location: $url");
    }
    else
        echo "ERROR";
}
else
    {
        $url = str_replace('/camagru/', '', $_POST['url_actual']);
        header("Location: $url");
    }
?>