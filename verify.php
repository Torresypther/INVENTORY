<?php
include "connection.php";
session_start();

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check for username and password
    $users = $pdo->prepare("SELECT * FROM user_data WHERE username = :username AND password = :password");
    $users->execute(["username" => $username, "password" => $password]);
    $result = $users->fetch();

    if ($result) {
        // Check if the role is admin or customer
        if ($result["role"] === "admin" || $result["role"] === "customer") {
            $_SESSION['username'] = $result["username"];
            $_SESSION['password'] = $result["password"];
            $_SESSION['role'] = $result["role"];

            header("Location: index.php");
        } else {
            // Redirect if the role is invalid
            header("Location: customer_feed.php?msg=welcome");
        }
    } else {
        // Redirect if login fails
        header("Location: login.php?error=invalid_credentials");
    }
}
