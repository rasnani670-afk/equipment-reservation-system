<?php
session_start();
include 'db.php';

$error = '';
$success = '';
$token = $_GET['token'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword === $confirmPassword) {
        if (strlen($newPassword) < 8) {
            $error = "Password must be at least 8 characters long.";
        } elseif (!preg_match('/[A-Z]/', $newPassword)) {
            $error = "Password must contain at least one uppercase letter.";
        } elseif (!preg_match('/[a-z]/', $newPassword)) {
            $error = "Password must contain at least one lowercase letter.";
        } elseif (!preg_match('/[0-9]/', $newPassword)) {
            $error = "Password must contain at least one number.";
        } elseif (!preg_match('/[\W_]/', $newPassword)) {
            $error = "Password must contain at least one special character.";
        }

        if (!$error) {
            // Fetch token and expiry from the database
            $sql = "SELECT reset_token, reset_token_expiry FROM users WHERE reset_token = :token";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['token' => $token]);
            $user = $stmt->fetch();

            // Debug output
            error_log("Token from form: $token");
            error_log("Token from DB: " . $user['reset_token']);
            error_log("Expiry from DB: " . $user['reset_token_expiry']);
            error_log("Current time: " . date('Y-m-d H:i:s'));

            if ($user) {
                // Compare expiry time to current time
                $expiry = new DateTime($user['reset_token_expiry'], new DateTimeZone('UTC')); // Assuming database stores in UTC
                $now = new DateTime('now', new DateTimeZone('UTC')); // Current time in UTC

                // Debug expiry check
                error_log("Expiry time: " . $expiry->format('Y-m-d H:i:s'));
                error_log("Current time: " . $now->format('Y-m-d H:i:s'));

                if ($now > $expiry) {
                    $error = "Invalid or expired token."; // Expiry check failed
                } else {
                    // Hash new password and update
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $sql = "UPDATE users SET password = :password, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = :token";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        'password' => $hashedPassword,
                        'token' => $token
                    ]);
                    $success = "Your password has been reset. You will be redirected to the login page shortly.";
                    
                    // Redirect to the login page after successful reset
                    header("Location: login.php");
                    exit;
                }
            } else {
                $error = "Invalid token.";
            }
        }
    } else {
        $error = "Passwords do not match.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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

        .reset-container {
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

        .reset-container:hover {
            transform: translateY(-15px);
        }

        .reset-container img {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            border-radius: 50%;
        }

        .reset-container h2 {
            font-size: 2.5em;
            font-weight: bold;
            margin-bottom: 1em;
            color: #fff;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);
        }

        .reset-container input {
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

        .reset-container input:focus {
            border-color: #ff2d55;
        }

        .reset-container button {
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

        .reset-container button:hover {
            background-color: #ff4b4b;
            transform: scale(1.05);
        }

        .back-to-login-link {
            color: #fff;
            margin-top: 15px;
            text-decoration: none;
            font-size: 1em;
            position: relative;
            display: inline-block;
            padding-bottom: 5px;
            transition: all 0.3s ease;
        }

        .back-to-login-link::after {
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

        .back-to-login-link:hover {
            color: #ff2d55;
        }

        .back-to-login-link:hover::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        .error-message, .success-message {
            color: #ff4b2b;
            font-size: 0.9em;
            margin-top: 15px;
        }

        .success-message {
            color: #4caf50;
        }
    </style>
</head>
<body>
    <div class="bg-overlay"></div>
    <div class="reset-container">
        <!-- Logo -->
        <img src="../M/ub.JPG" alt="UB Logo">

        <h2>Reset Password</h2>

        <?php if ($error): ?>
            <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="success-message"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
        
        <form method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <input type="password" name="new_password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>


