<?php

class auth
{
    static function islogged()
    {
        if (isset($_SESSION['auth']) && isset($_SESSION['auth']['login']) && isset($_SESSION['auth']['password']))
        {
            extract($_SESSION);
            $login = $_SESSION['auth']['login'];
            $pwd = $_SESSION['auth']['password'];
            try
            {
                $db = new PDO('mysql:host=localhost;dbname=cama_base','root','root');
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch (PDOException $e) 
            {
                echo 'Connection failed: ' . $e->getMessage();
            }
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
            if ($req_pwd[0] != $pwd || $req_log[0] != $login || $req_actif[0] == 0)
            {
                return (FALSE);
            }
            else
            {
                return(TRUE);
            }
        }
        else
            return (FALSE);
    }
}

?>