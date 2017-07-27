<?php
include('database.php');
try {
    echo "Start -";
    // create and connect to db
    $db = new PDO("mysql:host=localhost", $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbname = "`".str_replace("`","``",$dbname)."`";
    $db->query("CREATE DATABASE IF NOT EXISTS $dbname");
    $db->query("use $dbname");
	// drop tables if exist
    // echo "- Dropping Tables -";
	// $db->query("DROP TABLE users");
	// here create tables (with correct columns)
    echo "- Creating Tables \n";
    $create = "CREATE TABLE IF NOT EXISTS users (id INT(16) PRIMARY KEY NOT NULL AUTO_INCREMENT, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, actif int(16) NOT NULL);" ;
    $create2 = "CREATE TABLE IF NOT EXISTS picture (id INT(16) PRIMARY KEY NOT NULL AUTO_INCREMENT,`picture` LONGTEXT NOT NULL, username VARCHAR(255) NOT NULL);";
    $create3 = "CREATE TABLE IF NOT EXISTS comments (id INT(16) PRIMARY KEY NOT NULL AUTO_INCREMENT, id_picture INT(16), username VARCHAR(255) NOT NULL, comments TEXT,date_comm datetime);";
    $create4 = "CREATE TABLE IF NOT EXISTS likes (id INT(16) PRIMARY KEY NOT NULL AUTO_INCREMENT, id_picture INT(16), username VARCHAR(255) NOT NULL);";
    $db->exec($create);
    $db->exec($create2);
    $db->exec($create3);
    $db->exec($create4);
    echo " -- DB and Tables ok ";
    if (!file_exists("../pictures"))
    {
        mkdir("../pictures");
        echo "Path created.\n";
    }
    } 
    catch (PDOException $e)
    {
        echo 'Connection failed: ' . $e->getMessage();
    }
?>