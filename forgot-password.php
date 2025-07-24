<?php
session_start();
include 'db.php';
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Fetch user by email
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        // Generate reset token and expiry (expiry in UTC)
        $resetToken = bin2hex(random_bytes(32));
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour', time())); // Expiry in UTC (adjust if necessary)

        // Update user with reset token and expiry
        $sql = "UPDATE users SET reset_token = :reset_token, reset_token_expiry = :expiry WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'reset_token' => $resetToken,
            'expiry' => $expiry, // Stored in UTC
            'email' => $email
        ]);

        // Create reset link
        $resetLink = "http://localhost/M/reset-password.php?token=$resetToken";

        // Setup PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = '20227193@s.ubaguio.edu'; 
            $mail->Password = 'zovu umll hprs cisc';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('your_email@gmail.com', 'Your App Name');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Reset Your Password';
            $mail->Body = "Click <a href=\"$resetLink\">here</a> to reset your password. This link will expire in 1 hour.";

            $mail->send();
            $success = "A reset link has been sent to your email.";
        } catch (Exception $e) {
            $error = "Error sending email: {$mail->ErrorInfo}";
        }
    } else {
        $error = "Email not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            position: relative;
            font-family: 'Arial', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-wrap: wrap;
            align-content: center;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("../M/skul.GIF") no-repeat center center fixed;
            background-size: cover;
            filter: blur(8px);
            z-index: 0;
        }

        .bg-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .login-container {
            position: relative;
            background-color: #000;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            border-radius: 20px;
            box-shadow: 0 30px 35px rgba(0, 0, 0, 0.5);
            z-index: 1;
            overflow: hidden;
            transition: transform 0.3s ease;
            transform: translateY(-10px);
        }

        .login-container:hover {
            transform: translateY(-15px);
        }

        .login-container img {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            border-radius: 50%;
        }

        .login-container h2 {
            font-size: 2.5em;
            font-weight: bold;
            margin-bottom: 1em;
            color: #fff;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);
        }

        .login-container input {
            width: 100%;
            padding: 15px;
            margin: 10px 0;
            font-size: 1em;
            border: 2px solid #ff2b2b;
            border-radius: 50px;
            outline: none;
            background-color: rgba(255, 255, 255, 0.9);
            transition: border-color 0.3s ease;
        }

        .login-container input:focus {
            border-color: #ff2d55;
        }

        .login-container button {
            width: 100%;
            padding: 15px;
            font-size: 1em;
            font-weight: bold;
            border: none;
            border-radius: 50px;
            background-color: #ff2d55;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .login-container button:hover {
            background-color: #ff4b4b;
            transform: scale(1.05);
        }

        .forgot-password-link {
            color: #fff;
            margin-top: 15px;
            text-decoration: none;
            font-size: 1em;
            position: relative;
            display: inline-block;
            padding-bottom: 5px;
            transition: all 0.3s ease;
        }

        .forgot-password-link::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            background-color: #ff2d55;
            left: 0;
            bottom: 0;
            transform: scaleX(0);
            transform-origin: bottom right;
            transition: transform 0.3s ease;
        }

        .forgot-password-link:hover {
            color: #ff2d55;
        }

        .forgot-password-link:hover::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }
        
        .error-message {
            color: #ff4b2b;
            font-size: 0.9em;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="bg-overlay"></div>
    <div class="login-container">
        <img src="../M/ub.JPG" alt="UB Logo">
        <h2>Forgot Password</h2>
        <?php if ($error): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit">Send Reset Link</button>
        </form>
        <p><a href="login.php" class="forgot-password-link">Back to Login</a></p>
    </div>
</body>
</html>






