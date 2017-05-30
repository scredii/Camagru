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
    $create = "CREATE TABLE users (id INT(16) PRIMARY KEY NOT NULL AUTO_INCREMENT, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, actif int(16) NOT NULL);" ;
    // $dbh->query("CREATE TABLE pictures (_id INT(16) PRIMARY KEY NOT NULL AUTO_INCREMENT, owner VARCHAR(255) NOT NULL, base64 LONGBLOB NOT NULL, likes TEXT NOT NULL, comments TEXT NOT NULL, created_at datetime NOT NULL DEFAULT NOW())");
    $db->exec($create);
    echo " -- DB and Tables ok";
    } 
    catch (PDOException $e)
    {
        echo 'Connection failed: ' . $e->getMessage();
    }
?>