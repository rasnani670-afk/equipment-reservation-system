<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $equipmentId = $_POST['equipment_id'];
    $borrowerType = $_POST['borrower_type'];
    $borrowerName = $_POST['borrower_name'];
    $idNumber = $_POST['id_number'];
    $department = $_POST['department'];
    $course = $_POST['course'];
    $quantity = $_POST['quantity'];
    $borrowing_status = 1;

    if (isset($_POST['releasedBy'])) {
        $releasedBy = $_POST['releasedBy'];
    } else {
        $releasedBy = null;
    }

    if (isset($_POST['staffId'])) {
        $releasedByStaffId = $_POST['staffId'];
    } else {
        $releasedByStaffId = null;
    }

    if(isset($_POST['releasedBy'])){ // Admin side
        $pdo->beginTransaction();
        try {
            //Get equipment table
        $query = "SELECT equipment_id, available_quantity FROM equipment WHERE equipment_id = ?";
        $stmtFetch = $pdo->prepare($query);
        $stmtFetch->execute([$equipmentId]);
        $availQuantityRecord = $stmtFetch->fetch(PDO::FETCH_ASSOC);

            //Compare available_quantity from equipment table and input quantity from the form
        if($availQuantityRecord['available_quantity'] < $quantity){
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => 'quantity cannot be more than the available quantity of the equipment.']);
        }else {
            $stmt = $pdo->prepare("INSERT INTO borrowing (borrower_type, borrower_name, id_number, department, course, released_by, equipment_id, quantity, borrowing_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$borrowerType, $borrowerName, $idNumber, $department, $course, $releasedBy, $equipmentId, $quantity, $borrowing_status]);
            
            // Get the last inserted borrowing_id 
            // This is the ID of the newly created borrowing record
            $borrowId = $pdo->lastInsertId();

            // Update equipment quantity
            $stmtUpdate = $pdo->prepare("UPDATE equipment SET quantity = quantity - ? WHERE equipment_id = ?");
            $stmtUpdate->execute([$quantity, $equipmentId]);

            //set date and time
            date_default_timezone_set('Asia/Manila');
            // $date = date('Y-m-d H:i:s');
            // $dateTime = new DateTime($date);
            // $time = $dateTime->format('H:i:s');

            $stmtDetails = $pdo->prepare("INSERT INTO borrowingdetails (BorrowId, EquipmentId) VALUES (?, ?)");
            $stmtDetails->execute([$borrowId, $equipmentId]);

            $pdo->commit();
            echo json_encode(['success' => true]);
            exit;
        }
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            exit;
        }
    } else { // Staff side
        $pdo->beginTransaction();
        try {
            //Get equipment table
        $query = "SELECT equipment_id, available_quantity FROM equipment WHERE equipment_id = ?";
        $stmtFetch = $pdo->prepare($query);
        $stmtFetch->execute([$equipmentId]);
        $availQuantityRecord = $stmtFetch->fetch(PDO::FETCH_ASSOC);

            //Compare available_quantity from equipment table and input quantity from the form
        if($availQuantityRecord['available_quantity'] < $quantity){
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => 'quantity cannot be more than the available quantity of the equipment.']);
        }else {
            $stmt = $pdo->prepare("INSERT INTO borrowing (borrower_type, borrower_name, id_number, department, course, released_by, equipment_id, quantity, borrowing_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$borrowerType, $borrowerName, $idNumber, $department, $course, $releasedByStaffId, $equipmentId, $quantity, $borrowing_status]);
            
            // Get the last inserted borrowing_id 
            // This is the ID of the newly created borrowing record
            $borrowId = $pdo->lastInsertId();

            // Update equipment quantity
            $stmtUpdate = $pdo->prepare("UPDATE equipment SET quantity = quantity - ? WHERE equipment_id = ?");
            $stmtUpdate->execute([$quantity, $equipmentId]);

            //set date and time
            date_default_timezone_set('Asia/Manila');
            // $date = date('Y-m-d H:i:s');
            // $dateTime = new DateTime($date);
            // $time = $dateTime->format('H:i:s');

            $stmtDetails = $pdo->prepare("INSERT INTO borrowingdetails (BorrowId, EquipmentId) VALUES (?, ?)");
            $stmtDetails->execute([$borrowId, $equipmentId]);

            $pdo->commit();
            echo json_encode(['success' => true]);
            exit;
        }
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            exit;
        }
    }
}
