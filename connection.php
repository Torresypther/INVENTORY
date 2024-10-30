<?php

$host = "localhost";
$dbname = "sales_inventory";
$username = "root";
$password = "";

try{
    $pdo = new PDO("mysql:host=$host;dbname=$dbname",$username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $th){
    die("NO no conik" .$th->getMessage());
}