<?php 
ob_start();
require_once('db_conn.php');  

if (isset($_POST['register'])) {
    $newconnection->userRegistration();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background-color: #e0f7fa;
    color: #333;
    padding: 20px;
}

.navbar {
    width: 100%;
    padding: 15px 20px;
    background: #4e54c8;
    color: #fff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
}

.nav-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
}

.nav-title {
    font-size: 1.5rem;
    font-weight: bold;
    letter-spacing: 1px;
}

.nav-link {
    text-decoration: none;
    font-size: 1rem;
    font-weight: bold;
    color: #fff;
    transition: opacity 0.3s ease, transform 0.2s ease;
}

.nav-link:hover {
    opacity: 0.7;
    transform: scale(1.05);
}

form {
    width: 100%;
    max-width: 800px;
    padding: 40px;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    margin-top: 90px;
    border: 1px solid #ddd;
    margin-top: 3rem;
}

form h2 {
    margin-bottom: 30px;
    font-size: 2.2rem;
    color: #4e54c8;
    text-align: center;
    font-weight: bold;
    letter-spacing: 1px;
}

.form-row {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.form-group {
    flex: 1;
    display: flex;
    flex-direction: column;
}

label {
    font-size: 1rem;
    color: #555;
    margin-bottom: 8px;
    font-weight: bold;
}

input, select {
    padding: 12px;
    font-size: 1rem;
    border: 1px solid #ddd;
    border-radius: 5px;
    outline: none;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

input:focus, select:focus {
    border-color: #4e54c8;
    box-shadow: 0 0 8px rgba(78, 84, 200, 0.2);
}

.submit-btn {
    width: 100%;
    padding: 15px;
    font-size: 1.1rem;
    color: #fff;
    background: linear-gradient(135deg, #4e54c8, #8f94fb);
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease, box-shadow 0.3s ease;
    font-weight: bold;
}

.submit-btn:hover {
    background: linear-gradient(135deg, #3c42a0, #6a71e5);
    box-shadow: 0 4px 10px rgba(78, 84, 200, 0.3);
}

.close {
    text-align: center;
    margin-top: 20px;
}

.back-btn {
    display: inline-block;
    padding: 12px 20px;
    font-size: 1rem;
    font-weight: bold;
    color: #fff;
    background: linear-gradient(135deg, #4e54c8, #8f94fb);
    text-decoration: none;
    border-radius: 5px;
    transition: background 0.3s ease, transform 0.2s ease;
    box-shadow: 0 4px 10px rgba(78, 84, 200, 0.3);
}

.back-btn:hover {
    background: linear-gradient(135deg, #3c42a0, #6a71e5);
    transform: scale(1.05);
    box-shadow: 0 6px 12px rgba(78, 84, 200, 0.4);
}

/* Styling for the file input */
input[type="file"] {
    padding: 12px;
    font-size: 1rem;
    border: 1px solid #ddd;
    border-radius: 5px;
    outline: none;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
    width: 100%;
    background-color: #f7f7f7;
}

input[type="file"]:focus {
    border-color: #4e54c8;
    box-shadow: 0 0 8px rgba(78, 84, 200, 0.2);
}

input[type="file"]::-webkit-file-upload-button {
    background: #4e54c8;
    color: white;
    padding: 8px 15px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    border: none;
    transition: background 0.3s ease, box-shadow 0.3s ease;
}

input[type="file"]::-webkit-file-upload-button:hover {
    background: #3c42a0;
    box-shadow: 0 4px 10px rgba(78, 84, 200, 0.3);
}

input[type="file"]::-webkit-file-upload-button:focus {
    outline: none;
    border: none;
}

input[type="file"]:disabled {
    background-color: #f0f0f0;
    cursor: not-allowed;
}

.form-row {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

.form-group {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.col-md-12 {
    margin-bottom: 20px;
}

    </style>
</head>
<body>

<nav class="navbar">
        <div class="nav-container">
            <span class="nav-title">Registration Form</span>
            <a href="login.php" class="nav-link">Back to Login</a>
        </div>
    </nav>

    <form action="" method="post" class="userinfo" enctype="multipart/form-data">
        <h2>User Registration</h2>

        <div class="form-row">
            <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" id="firstname" name="firstname" placeholder="Enter your first name" required>
            </div>
            <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" id="lastname" name="lastname" placeholder="Enter your last name" required>
            </div>
        </div>

        <!-- Row 2: Address -->
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" placeholder="Enter your address">
        </div>

        <!-- Row 3: Birthdate and Gender -->
        <div class="form-row">
            <div class="form-group">
                <label for="birthdate">Birthdate</label>
                <input type="date" id="birthdate" name="birthdate">
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select name="gender" id="gender">
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Prefer not to say">Prefer not to say</option>
                </select>
            </div>
        </div>

        <!-- Row 4: Username and Password -->
        <div class="form-row">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Choose a username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Choose a password" required>
            </div>
        </div>

        <div class="form-group">
            <label for="profile_image">Profile Image</label>
            <input type="file" id="profile_image" name="profile_image" accept="image/*">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="submit-btn" name="register">Register</button>
    </form>
    </body>
</html>
