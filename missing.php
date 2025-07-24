<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['borrowingId'])) {
        $borrowingId = $_POST['borrowingId'];

        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare("UPDATE borrowing SET borrowing_status = 3 WHERE borrowing_id = ? AND returned = 0");
            $stmt->execute([$borrowingId]);

            $pdo->commit();

            echo json_encode(['success' => true, 'message' => 'Equipment marked as missing']);
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }else {
        echo json_encode(['success' => false, 'message' => 'No equipment ID provided']);
    }
}