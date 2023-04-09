<?php
$host = 'localhost';
$port = 3307;
$dbname = 'database';
$username = 'root';
$password = '';

$dsn = "mysql:host=$host;port=$port;dbname=$dbname";

try {
    $povezava = new PDO($dsn, $username, $password);
    $povezava->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'dela :)';
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

//phpinfo();

/* USTVARJANJE NOVE POVEZAVE NA PODATKOVNO BAZO
$povezava = new PDO('mysql:host='.$db_hostname.';dbname='.$db_database.';charset=utf8mb4', $db_username = 'root', $db_password);

//echo "povezava uspela";*/
