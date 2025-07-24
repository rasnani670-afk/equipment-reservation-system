<?php
header('Content-Type: application/json');

session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $email = $_POST['email'];

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $query = "SELECT user_id FROM users WHERE username = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$username]);
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    $pdo->beginTransaction();
    try {
        // Check if username already exists
        if ($existingUser) {

            echo json_encode(['success' => false, 'message' => 'Username is already taken.']);
            exit;

        }else{

            $insertQuery = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
            $stmtInsert = $pdo->prepare($insertQuery);
            $stmtInsert->execute([$username, $hashedPassword, $email]);

            if ($stmtInsert->rowCount() > 0) {
                $pdo->commit();
                echo json_encode(['success' => true, 'message' => 'Account created successfully.']);
            } else {
                $pdo->rollBack();
                echo json_encode(['success' => false, 'message' => 'Error creating account. Please try again.']);
            }
        }

    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
