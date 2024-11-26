<?php
session_start();
include "connection.php";

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $users = $pdo->prepare("SELECT * FROM user_data WHERE username = :username AND password = :password");
    $users->execute(["username" => $username, "password" => $password]);
    $result = $users->fetch();

    if ($result) {

        $_SESSION['username'] = $result["username"];
        $_SESSION['user_image'] = $result['user_image']; 
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['role'] = $result['role'];

        if ($result["role"] === "admin") {
            header("Location: index.php");
        } else {
            header("Location: customer_feed.php?msg=welcome");
        }
        exit();
    } else {

        header("Location: login.php?error=invalid_credentials");
        exit();
    }
}
