<?php
header('Content-Type: application/json');

session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $equipment_id = $_POST['equipment_id'];
    $reservation_name = $_POST['reservation_name'];
    $usage_date = $_POST['usage_date'];
    $quantity = (int) $_POST['quantity'];

    if (empty($usage_date) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $usage_date) || $quantity <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid or missing inputs.']);
        exit;
    }

    if (!strtotime($usage_date)) {
        echo json_encode(['success' => false, 'message' => 'Invalid date format.']);
        exit;
    }

    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("SELECT available_quantity FROM equipment WHERE equipment_id = ?");
        $stmt->execute([$equipment_id]);
        $equipment = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($equipment && $equipment['available_quantity'] >= $quantity) {
            $stmtInsert = $pdo->prepare("
                INSERT INTO reservations (equipment_id, reservation_name, usage_date, quantity)
                VALUES (?, ?, ?, ?)
            ");
            $stmtInsert->execute([$equipment_id, $reservation_name, $usage_date, $quantity]);

            $stmtUpdate = $pdo->prepare("
                UPDATE equipment
                SET available_quantity = available_quantity - ?
                WHERE equipment_id = ?
            ");
            $stmtUpdate->execute([$quantity, $equipment_id]);

            $pdo->commit();
            echo json_encode(['success' => true, 'message' => 'Reservation created successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Not enough quantity available for reservation.']);
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}
?>
