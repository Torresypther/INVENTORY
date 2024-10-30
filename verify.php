<?php
 include "connection.php";
 session_start();

if(isset($_POST['submit'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $users = $pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
    $users->execute(["username" => $username, "password" => $password]);
    $result = $users->fetch();

    if($result){
        $_SESSION['username'] = $result["username"];
        $_SESSION['password'] = $result["password"];

        header("Location: index.php");
    }else{
        header("Location: login.php");
    }
} 