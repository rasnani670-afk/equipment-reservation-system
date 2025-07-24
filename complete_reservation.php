<?php
header('Content-Type: application/json');
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservation_id = $_POST['reservation_id'];

    $pdo->beginTransaction();

    try {
        $stmtCheckStatus = $pdo->prepare("SELECT status FROM reservations WHERE reservation_id = ?");
        $stmtCheckStatus->execute([$reservation_id]);
        $reservation = $stmtCheckStatus->fetch(PDO::FETCH_ASSOC);

        if ($reservation) {
            if ($reservation['status'] !== 'completed') {
                $stmtUpdate = $pdo->prepare("UPDATE reservations SET status = 'completed' WHERE reservation_id = ?");
                $stmtUpdate->execute([$reservation_id]);

                $pdo->commit();

                echo json_encode(['success' => true, 'message' => 'Reservation marked as completed.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'This reservation has already been completed.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Reservation not found.']);
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Failed to complete reservation: ' . $e->getMessage()]);
    }
}
?>
