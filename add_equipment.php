<?php
header('Content-Type: application/json');

session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $equipmentName = trim($_POST['equipmentName']);
    $quantity = $_POST['quantity'];
    $brand = $_POST['brand'];
    $availableQuantity = $_POST['quantity'];

    $pdo->beginTransaction();
    try {
        
        $query = "INSERT INTO equipment (equipment_name, quantity, brand, available_quantity) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$equipmentName, $quantity, $brand, $availableQuantity]);

        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'Equipment added successfully.']);

    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
