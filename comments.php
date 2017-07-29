<?php
session_start();
require("auth.php");
if (auth::isLogged() == FALSE)
{
 	header('Location: galery.php');
	 exit();
}
if ($_POST['comments'] != "" && $_POST['submit'] == "OK" && $_SESSION['auth'])
{
    $db = auth::connect_sql();
    $id_picture = $_POST['id_photo'];
	$id_prop = $_POST['user_photo'];
    $username = $_POST['username'];
    $comment = $_POST['comments'];
    $date = date("Y-m-d H:i:s");
    $values = array($id_picture, $username, $comment, $date);
	$req = $db->prepare('INSERT INTO comments (id_picture, username, comments, date_comm) VALUES (?, ?, ?, ?)');
	if ($req->execute($values))
    {
		$reponse_mail = $db->query('SELECT email FROM users WHERE username = "' . $id_prop . '" ')->fetch();
        $url = str_replace('/camagru/', '', $_POST['url_actual']);
        $subject = "Vous avez recu un nouveau commentaire !" ;
        $entete = "Camagru - Nouveau commentaire" ;
        $message = 'Du nouveau sur Camagru,
        Vous avez recu un nouveau commentaire, cliquez sur le lien suivant pour le consulter:
        http://localhost:8080'.$_POST["url_actual"].'
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