<?php
include('database.php');
try {
    echo "Start -";
    $db = new PDO($DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbname = "`".str_replace("`","``",$dbname)."`";
    echo "Drop Database \n";
    $db->query("DROP DATABASE IF EXISTS $dbname");    
    $db->query("CREATE DATABASE IF NOT EXISTS $dbname");
    $db->query("use $dbname");
    echo "- Creating Tables \n";
    $create = "CREATE TABLE users (id INT(16) PRIMARY KEY NOT NULL AUTO_INCREMENT, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, actif int(16) NOT NULL);" ;
    $create2 = "CREATE TABLE picture (id INT(16) PRIMARY KEY NOT NULL AUTO_INCREMENT,`picture` LONGTEXT NOT NULL, username VARCHAR(255) NOT NULL);";
    $create3 = "CREATE TABLE comments (id INT(16) PRIMARY KEY NOT NULL AUTO_INCREMENT, id_picture INT(16), username VARCHAR(255) NOT NULL, comments TEXT,date_comm datetime);";
    $create4 = "CREATE TABLE likes (id INT(16) PRIMARY KEY NOT NULL AUTO_INCREMENT, id_picture INT(16), username VARCHAR(255) NOT NULL);";
    $db->exec($create);
    $db->exec($create2);
    $db->exec($create3);
    $db->exec($create4);
    echo " -- DB and Tables ok ";
}
catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
}
?>