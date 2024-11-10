<?php 
    require_once('db_conn.php');  
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
            background-color: #eaf0f6;
            color: #333;
        }

        form {
            width: 85vw;
            max-width: 900px;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        form h2 {
            margin-bottom: 15px;
            font-size: 1.5rem;
            color: #007bff;
            text-align: center;
        }

        /* Row and input group styling */
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
        }
        .form-group {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Label and input styling */
        label {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 5px;
        }
        input, select {
            width: 100%;
            padding: 12px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s ease;
        }
        input:focus, select:focus {
            border-color: #007bff;
            box-shadow: 0 0 4px rgba(0, 123, 255, 0.2);
        }

        /* Button styling */
        .submit-btn {
            margin-top: 20px;
            padding: 12px;
            font-size: 1rem;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
            width: 100%;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
<?php
    $newconnection->userRegistration();
?>

  <form action="" method="post" class="userinfo">
        <h2>User Registration</h2>
        <!-- Row 1: First Name and Last Name -->
        <div class="form-row">
            <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" id="firstname" name="firstname" placeholder="First Name" required>
            </div>
            <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" id="lastname" name="lastname" placeholder="Last Name" required>
            </div>
        </div>

        <!-- Row 2: Address -->
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" placeholder="Address">
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
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
        </div>
        <!-- Submit Button -->
        <button type="submit" class="submit-btn" name="register">Register</button>

    </form>
    <div class="close">
            <a href="login.php">BAck to login</a>
        </div>
</body>
</html>
