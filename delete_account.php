<?php
header('Content-Type: application/json');

session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['userId'];

    $query = "SELECT user_id FROM users WHERE user_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$userId]);
    $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

    $pdo->beginTransaction();
    try {
        if (!$existingUser) {

            echo json_encode(['success' => false, 'message' => 'Username not found.']);
            exit;

        }

        $deleteQuery = "DELETE FROM users WHERE user_id = ?";
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->execute([$userId]);
 
        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'Account successfully deleted.']);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
