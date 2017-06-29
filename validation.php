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
    $log_tmp = $_GET['login'];
    $key_tmp = $_GET['key'];
    $req = $db->prepare("SELECT token,actif FROM users WHERE username like :login ");
    if($req->execute(array(':login' => $log_tmp)) && $row = $req->fetch())
    {
        $key_db = $row['token'];	// Récupération de la clé
        $actif = $row['actif']; // $actif contiendra alors 0 ou 1
    }
    if($actif == '1') // Si le compte est déjà actif on prévient
    {
        echo "Votre compte est déjà actif !";
    }
    else // Si ce n'est pas le cas on passe aux comparaisons
    {
        if($key_tmp == $key_db) // On compare nos deux clés	
        {
          // Si elles correspondent on active le compte !	
          echo "Votre compte a bien été activé !";
 
          // La requête qui va passer notre champ actif de 0 à 1
          $req = $db->prepare("UPDATE users SET actif = 1 WHERE username like :username ");
          $req->bindParam(':username', $log_tmp);
          $req->execute();
       }
     else // Si les deux clés sont différentes on provoque une erreur...
       {
          echo "Erreur ! Votre compte ne peut être activé...";
       }
  }
?>