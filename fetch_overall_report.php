<?php
include 'db.php';

$totalBorrowedQuery = "
    SELECT COUNT(*) 
    FROM borrowing 
    WHERE borrowing_status = (SELECT status_id FROM borrowingstatus WHERE status_name = 'Borrowed')
";
$totalReturnedQuery = "
    SELECT COUNT(*) 
    FROM borrowing 
    WHERE borrowing_status = (SELECT status_id FROM borrowingstatus WHERE status_name = 'Returned')
";
$totalMissingQuery = "
    SELECT COUNT(*) 
    FROM borrowing 
    WHERE borrowing_status = (SELECT status_id FROM borrowingstatus WHERE status_name = 'Missing')
";
$avgBorrowDurationQuery = "
    SELECT AVG(DATEDIFF(b.return_date, bd.BorrowDate)) 
    FROM borrowing b
    INNER JOIN borrowingdetails bd ON b.borrowing_id = bd.BorrowId
    WHERE b.returned = 1
";

try {
    $totalBorrowedStmt = $pdo->query($totalBorrowedQuery);
    $totalBorrowed = $totalBorrowedStmt->fetchColumn();

    $totalReturnedStmt = $pdo->query($totalReturnedQuery);
    $totalReturned = $totalReturnedStmt->fetchColumn();

    $totalMissingStmt = $pdo->query($totalMissingQuery);
    $totalMissing = $totalMissingStmt->fetchColumn();

    $avgBorrowDurationStmt = $pdo->query($avgBorrowDurationQuery);
    $avgBorrowDuration = $avgBorrowDurationStmt->fetchColumn();

    echo json_encode([
        'total_borrowed' => $totalBorrowed,
        'total_returned' => $totalReturned,
        'total_missing' => $totalMissing,
        'avg_borrow_duration' => round($avgBorrowDuration, 2)
    ]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
