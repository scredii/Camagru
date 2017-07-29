<?php
    require("auth.php");
    header("Refresh:1; url=index.php");
    $db = auth::connect_sql();
    $log_tmp = $_GET['login'];
    $key_tmp = $_GET['key'];
    $req = $db->prepare("SELECT token,actif FROM users WHERE username like :login ");
    if($req->execute(array(':login' => $log_tmp)) && $row = $req->fetch())
    {
        $key_db = $row['token'];
        $actif = $row['actif'];
    }
    if($actif == '1')
    {
        echo "Votre compte est déjà actif !";
    }
    else
    {
        if($key_tmp == $key_db)
        {
          echo "Votre compte a bien été activé !";
          $req = $db->prepare("UPDATE users SET actif = 1 WHERE username like :username ");
          $req->bindParam(':username', $log_tmp);
          $req->execute();
       }
     else
       {
          echo "Erreur ! Votre compte ne peut être activé...";
       }
  }
?>