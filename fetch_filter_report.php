<?php
header('Content-Type: application/json');

session_start();
include 'db.php';

// Function to validate and sanitize input
function validate_input($input) {
    return isset($input) && !empty($input);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $month = isset($_POST['monthFilter']) ? $_POST['monthFilter'] : null;
    $year = isset($_POST['yearFilter']) ? $_POST['yearFilter'] : null;

    if ($month && !$year) {
        $year = date('Y');
    }

    $queryCount = "
        SELECT 
            COUNT(CASE WHEN b.borrowing_status = 1 THEN 1 END) AS total_borrowed,
            COUNT(CASE WHEN b.borrowing_status = 2 THEN 1 END) AS total_returned,
            COUNT(CASE WHEN b.borrowing_status = 3 THEN 1 END) AS total_missing,
            AVG(DATEDIFF(b.return_date, bd.BorrowDate)) AS avg_borrow_duration
        FROM borrowing b
        LEFT JOIN borrowingdetails bd ON b.borrowing_id = bd.BorrowId
        WHERE 1=1";

    $queryTable = "
        SELECT 
            e.equipment_name,
            COALESCE(SUM(CASE WHEN b.borrowing_status = 1 THEN b.quantity ELSE 0 END), 0) AS quantity_borrowed,
            COALESCE(SUM(CASE WHEN b.borrowing_status = 2 THEN b.quantity ELSE 0 END), 0) AS quantity_returned,
            COALESCE(SUM(CASE WHEN b.borrowing_status = 3 THEN b.quantity ELSE 0 END), 0) AS quantity_missing
        FROM equipment e
        JOIN borrowing b ON e.equipment_id = b.equipment_id
        JOIN borrowingdetails bd ON b.borrowing_id = bd.BorrowId
        
    ";
    
    // Add conditions for the month and year filter if provided
    $params = [];

    if ($month) {
        $queryCount .= " AND MONTH(bd.BorrowDate) = ?";
        $queryTable .= " AND MONTH(bd.BorrowDate) = ?";
        
        $params[] = date('m', strtotime($month));
    }

    if ($year) {
        $queryCount .= " AND YEAR(bd.BorrowDate) = ?";
        $queryTable .= " AND YEAR(bd.BorrowDate) = ?";
        
        $params[] = $year;
    }

    $queryTable .= " GROUP BY e.equipment_name";

    try {
        $stmtCount = $pdo->prepare($queryCount);
        $stmtCount->execute($params);

        $resultCount = $stmtCount->fetch(PDO::FETCH_ASSOC);

        $stmtFetchReport = $pdo->prepare($queryTable);
        $stmtFetchReport->execute($params);
        $data = $stmtFetchReport->fetchAll(PDO::FETCH_ASSOC);

        if ($resultCount) {
            $avg_borrow_duration = $resultCount['avg_borrow_duration'] ? round($resultCount['avg_borrow_duration'], 2) : 0;

            echo json_encode([
                'success' => true,
                'total_borrowed' => $resultCount['total_borrowed'],
                'total_returned' => $resultCount['total_returned'],
                'total_missing' => $resultCount['total_missing'],
                'avg_borrow_duration' => $avg_borrow_duration,
                'equipment' => $data,
                'queryTable' => $queryTable
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No data found for the selected period']);
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage() . ' on query: ' . $queryCount . ' | ' . $queryTable
        ]);
    }
}
?>
