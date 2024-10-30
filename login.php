<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="verify.php" method="post">
        <label for="username">Username This:</label>
        <input type="text" name="username">
        <br>
        <label for="password">Password This:</label>
        <input type="text" name="password">
        <br>
        <button type="submit" name="submit">Login Madapaka</button>
    </form>
</body>
</html>