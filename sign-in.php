<?php
session_start();

include 'connect.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $gender = $_POST['gender'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Prepare and bind
        $sql = "INSERT INTO user (first_name, last_name, email, password, gender) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $firstName, $lastName, $email, $hashedPassword, $gender);

        if ($stmt->execute()) {
            echo "Signup successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
    
    // Redirect back to the signup form
    header("Location: dashboard.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<style>
    <style>
    .button {
            margin: auto;
            min-width: 90px;
            gap: 10px;
            position: relative;
            cursor: pointer;
            padding: 12px 17px;
            border: 0;
            border-radius: 7px;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.1);
            background: radial-gradient(
                ellipse at bottom,
                rgba(71, 81, 92, 1) 0%,
                rgba(11, 21, 30, 1) 45%
            );
            color: rgba(255, 255, 255, 0.66);
            transition: all 1s cubic-bezier(0.15, 0.83, 0.66, 1);
        }

        .button::before {
            content: "";
            width: 70%;
            height: 1px;
            position: absolute;
            bottom: 0;
            left: 15%;
            background: linear-gradient(
                90deg,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 1) 50%,
                rgba(255, 255, 255, 0) 100%
            );
            opacity: 0.2;
            transition: all 1s cubic-bezier(0.15, 0.83, 0.66, 1);
        }

        .button:hover {
            color: rgba(255, 255, 255, 1);
            transform: scale(1.1) translateY(-3px);
        }

        .button:hover::before {
            opacity: 1;
        }

        .form {
            margin: auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 350px;
            padding: 20px;
            border-radius: 20px;
            position: relative;
            background-color: #1a1a1a;
            color: #fff;
            border: 1px solid #333;
        }

        .title {
            font-size: 28px;
            font-weight: 600;
            letter-spacing: -1px;
            position: relative;
            display: flex;
            align-items: center;
            padding-left: 30px;
            color: #00bfff;
        }

        .title::before, .title::after {
            width: 18px;
            height: 18px;
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            border-radius: 50%;
            left: 0;
            background-color: #00bfff;
        }

        .title::after {
            animation: pulse 1s linear infinite;
        }

        .message, .signin {
            font-size: 14.5px;
            color: rgba(255, 255, 255, 0.7);
        }

        .signin {
            text-align: center;
        }

        .signin a:hover {
            text-decoration: underline royalblue;
        }

        .signin a {
            color: #00bfff;
        }

        .flex {
            display: flex;
            width: 100%;
            gap: 6px;
        }

        .form label {
            position: relative;
        }

        .form label .input {
            background-color: #333;
            color: #fff;
            width: 100%;
            padding: 20px 5px 5px 10px;
            outline: 0;
            border: 1px solid rgba(105, 105, 105, 0.397);
            border-radius: 10px;
        }

        .form label .input + span {
            color: rgba(255, 255, 255, 0.5);
            position: absolute;
            left: 10px;
            top: 0;
            font-size: 0.9em;
            cursor: text;
            transition: 0.3s ease;
        }

        .form label .input:placeholder-shown + span {
            top: 12.5px;
            font-size: 0.9em;
        }

        .form label .input:focus + span,
        .form label .input:valid + span {
            color: #00bfff;
            top: 0;
            font-size: 0.7em;
            font-weight: 600;
        }
        .form .input {
    width: 100%;
    padding: 0.5rem;
    margin-bottom: 1rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.form select.input {
    -webkit-appearance: none;  /* Remove default arrow for WebKit */
    -moz-appearance: none;  /* Remove default arrow for Firefox */
    appearance: none;  /* Remove default arrow */
    padding-right: 1.5rem;  /* Add space for custom arrow */
}

.form select.input::after {
    content: "\25BC";  /* Unicode character for down arrow */
    position: absolute;
    right: 1rem;
    pointer-events: none;
}


        .input {
            font-size: medium;
        }

        .submit {
            border: none;
            outline: none;
            padding: 10px;
            border-radius: 10px;
            color: #fff;
            font-size: 16px;
            transform: .3s ease;
            background-color: #00bfff;
        }

        .submit:hover {
            background-color: #00bfff96;
        }

        @keyframes pulse {
            from {
                transform: scale(0.9);
                opacity: 1;
            }
            to {
                transform: scale(1.8);
                opacity: 0;
            }
        }
</style>
</style>
<body>
    
<!-- Sign In Modal -->
<div class="modal fade" id="signInModal" tabindex="-1" aria-labelledby="signInModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
</div>
<div class="modal-body">
<center>
<form class="form" action="sign-in.php" method="POST" id="signInForm">
    <p class="title">Sign In</p>
    <p class="message">Login now and get access to your dashboard.</p>
    <label>
        <input class="input" type="email" name="email" required>
        <span>Email</span>
    </label>
    <label>
        <input class="input" type="password" name="password" required>
        <span>Password</span>
    </label>
    <button class="submit" type="submit">Login</button>
    <p class="signin">Don't have an account? <a href="signup.php" c>Sign up</a></p>
</form>
    </center>
</div>
</div>
</div>
</div>
</body>
</html>
