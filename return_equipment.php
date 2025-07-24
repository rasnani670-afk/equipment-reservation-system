<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //$data = json_decode(file_get_contents('php://input'), true);
    //$borrowingId = $data['borrowing_id'];
    //$quantity = $data['quantity'];
    $borrowingId = $_POST['borrow_id'];
    $pdo->beginTransaction();

    try {
        $stmtFetch = $pdo->prepare("SELECT equipment_id, quantity, returned, return_date FROM borrowing WHERE borrowing_id = ?");
        $stmtFetch->execute([$borrowingId]);
        $borrowingRecord = $stmtFetch->fetch(PDO::FETCH_ASSOC);

            //check if data exist
        if(!$borrowingRecord){
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => 'Equipment not found']);
        } else {

            $equipmentId = $borrowingRecord['equipment_id'];
            $quantity = $borrowingRecord['quantity'];
            $returned = true;
            $borrowingStatus = 2;
            
            $stmtUpdateEquipment = $pdo->prepare("UPDATE equipment SET quantity = quantity + ? WHERE equipment_id = ?");
            $stmtUpdateEquipment->execute([$quantity, $equipmentId]);

            $date = date('Y-m-d H:i:s');
            $stmtUpdateBorrowing = $pdo->prepare("UPDATE borrowing SET returned = ?, return_date = ?, borrowing_status = ? WHERE borrowing_id = ?");
            $stmtUpdateBorrowing->execute([$returned, $date, $borrowingStatus, $borrowingId]);

            $pdo->commit();
            echo json_encode(['success' => true]);
        }

    } catch (Exception $e) {

        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}