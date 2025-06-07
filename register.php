<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check_sql = "SELECT * FROM users WHERE email = '$email'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "<div class='error-message'>
                <p>Error: Email already exists.</p>
                <a href='login.php'><button class='login-btn'>Go to Login</button></a>
              </div>";
    } else {
        // Insert new user
        $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', 'user')";
        if ($conn->query($sql) === TRUE) {
            echo "Registration successful. <a href='login.php'>Login</a>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            background-image: url('background.jpg'); /* Ensure image exists */
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            color: white;
            text-align: center;
        }
        .form-container {
            margin: 100px auto;
            width: 300px;
            padding: 20px;
            background: rgba(0, 0, 0, 0.6);
            border-radius: 10px;
        }
        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
        }
        button {
            background: green;
            color: white;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .error-message {
            background: rgba(255, 0, 0, 0.7);
            padding: 10px;
            border-radius: 5px;
            margin: 10px auto;
            width: 300px;
            color: white;
        }
        .login-btn {
            background: blue;
            color: white;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Register</h2>
    <form method='POST'>
        <input type='text' name='name' placeholder="Name" required><br>
        <input type='email' name='email' placeholder="Email" required><br>
        <input type='password' name='password' placeholder="Password" required><br>
        <button type='submit'>Register</button>
    </form>
</div>

</body>
</html>
