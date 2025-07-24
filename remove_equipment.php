<?php
header('Content-Type: application/json');

session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $equipmentId = $_POST['equipmentId'];

    $query = "SELECT equipment_id FROM equipment WHERE equipment_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$equipmentId]);
    $existingEquipment = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check for dependent records in the borrowing table
    $checkBorrowingQuery = "SELECT COUNT(*) FROM borrowing WHERE equipment_id = ? AND returned = 0";
    $checkStmt = $pdo->prepare($checkBorrowingQuery);
    $checkStmt->execute([$equipmentId]);
    $dependentRecords = $checkStmt->fetchColumn();

    $pdo->beginTransaction();
    try {
        if (!$existingEquipment) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => 'Equipment not found.']);
            exit;

        }

        if ($dependentRecords > 0) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => 'Equipment cannot be deleted because it is currently borrowed.']);
            exit;
        }

        // $deleteQuery = "DELETE FROM equipment WHERE equipment_id = ?";
        // $deleteStmt = $pdo->prepare($deleteQuery);
        // $deleteStmt->execute([$equipmentId]);
    
        // Soft deletion
        $updateQuery = "UPDATE equipment SET is_removed = TRUE WHERE equipment_id = ?";
        $updateStmt = $pdo->prepare($updateQuery);
        $updateStmt->execute([$equipmentId]);
 
        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'Equipment successfully deleted.']);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
