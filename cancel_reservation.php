<?php
header('Content-Type: application/json');
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation_id = $_POST['reservation_id'];
    $equipment_id = $_POST['equipment_id'];
    $quantity = (int) $_POST['quantity'];

    $pdo->beginTransaction();

    try {
        $stmtCheckStatus = $pdo->prepare("SELECT status FROM reservations WHERE reservation_id = ?");
        $stmtCheckStatus->execute([$reservation_id]);
        $reservation = $stmtCheckStatus->fetch(PDO::FETCH_ASSOC);

        if ($reservation) {
            if ($reservation['status'] !== 'cancelled') {
                $stmtUpdateStatus = $pdo->prepare("UPDATE reservations SET status = 'cancelled' WHERE reservation_id = ?");
                $stmtUpdateStatus->execute([$reservation_id]);

                $stmtUpdateEquipment = $pdo->prepare("UPDATE equipment SET available_quantity = available_quantity + ? WHERE equipment_id = ?");
                $stmtUpdateEquipment->execute([$quantity, $equipment_id]);

                $pdo->commit();

                echo json_encode(['success' => true, 'message' => 'Reservation cancelled and equipment quantity restored.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'This reservation has already been cancelled.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Reservation not found.']);
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Failed to cancel reservation: ' . $e->getMessage()]);
    }
}
?>
