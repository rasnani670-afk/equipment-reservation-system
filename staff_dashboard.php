

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;700&display=swap">

    <style>
        body { font-family: 'Montserrat', sans-serif; background-color: #1c1c1c; color: #f0f0f0; padding-top: 68px;}
        .sidebar { background-color: #000; color: white; height: 100vh; position: fixed; width: 240px; padding-top: 20px; }
        .sidebar .nav-link { color: #fff; border-radius: 40px; padding: 10px 20px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #ff2d55; }
        .table th { background-color: #ff2d55; color: white; }
        .card { border: none; background-color: #2c2c2c; }
        .navbar { background-color: #000; border-bottom: 2px solid #ff2d55; }
        h2 { color: #ff2d55; }
        .modal-header {
            transition: background-color 0.3s ease;
        }
        .modal-header:hover {
            background-color: #ff2d55;
        }
        .btn-danger:hover {
            background-color: #e0243e;
        }
        

        @media (max-width: 768px) {
            .sidebar { position: relative; width: 100%; height: auto; }
            .sidebar .nav-link { text-align: center; }
            main { margin-left: 0; }
        }

        .status-circle {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 10px;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Navbar -->
        <nav class="navbar navbar-expand navbar-dark fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"><img src="../M/ub.JPG" alt="School Logo" height="40"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <nav class="col-md-3 col-lg-2 d-md-block sidebar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#" id="dashboardLink">
                                <i class="fas fa-tachometer-alt"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="borrowLink">
                                <i class="fas fa-arrow-right"></i>
                                Borrow Equipment
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="addEquipmentButton">
                                <i class="fas fa-plus-circle"></i>
                                Add Equipment
                            </a>
                        </li>
                        <!-- 
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="returnLink">
                                <i class="fas fa-arrow-left"></i>
                                Return Equipment
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="reserveLink">
                                <i class="fas fa-calendar-alt"></i>
                                Reserve Equipment
                            </a>
                        </li>
                         -->
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="viewBorrowedLink">
                                <i class="fas fa-folder-open"></i>
                                View Borrowed Equipments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="viewReturnedLink">
                                <i class="fas fa-recycle"></i>
                                View Returned Equipments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="viewMissingLink">
                                <i class="fas fa-exclamation-triangle"></i>
                                View Missing Equipments
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- Main Content -->
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5" style="margin-left: 250px;">
                    <!-- Dashboard Section -->
                    <div id="dashboardSection">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h2 class="mt-4">All Equipment</h2>
                        <a class="btn btn-danger nav-link" href="#" id="viewDashboard2Link" style="margin-top: 25px; padding: 5px 15px;">
                            Remove Equipment
                        </a>
                    </div>

                        <table class="table table-dark table-striped">
                            <thead>
                                <tr><th>Equipment Name</th><th>Brand</th><th>Quantity</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach ($equipmentList as $equipment): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($equipment['equipment_name']); ?></td>
                                        <td><?php echo htmlspecialchars($equipment['brand']); ?></td>
                                        <td><?php echo htmlspecialchars($equipment['quantity']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Dashboard Section with remove button-->
                    <div id="dashboardSection2" class="section" style="display: none;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h2 class="mt-4">All Equipment</h2>
                            <a class="btn btn-danger nav-link" href="#" id="viewDashboardLink" style="margin-top: 25px; padding: 5px 15px;">
                                Back
                            </a>
                        </div>
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr><th>Equipment Name</th><th>Brand</th><th>Quantity</th><th>Action</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach ($equipmentList as $equipment): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($equipment['equipment_name']); ?></td>
                                        <td><?php echo htmlspecialchars($equipment['brand']); ?></td>
                                        <td><?php echo htmlspecialchars($equipment['quantity']); ?></td>
                                        <td>
                                            <button 
                                                class="removeEquipmentBtn btn btn-danger" 
                                                data-id="<?php echo $equipment['equipment_id']; ?>" 
                                                data-name="<?php echo $equipment['equipment_name']; ?>" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#removeEquipmentModal"
                                            >
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Available Equipment for Borrowing -->
                    <div id="borrowSection" class="section mt-4" style="display: none;">
                        <h2>Available Equipment for Borrowing</h2>
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr><th>Equipment Name</th><th>Brand</th><th>Quantity</th><th>Action</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach ($availableEquipment as $equipment): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($equipment['equipment_name']); ?></td>
                                        <td><?php echo htmlspecialchars($equipment['brand']); ?></td>
                                        <td><?php echo htmlspecialchars($equipment['quantity']); ?></td>
                                        <td>
                                            <button 
                                                class="borrowBtn btn btn-danger" 
                                                data-id="<?php echo $equipment['equipment_id']; ?>"
                                                data-staff-id="<?php echo $_SESSION['user_id']; ?>" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#borrowModal"
                                            >
                                                Borrow
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Return Equipment Section -->
                    <div id="returnSection" class="section mt-4" style="display: none;">
                        <h2>Return Equipment</h2>
                        <form id="returnForm1">
                            <div class="mb-3">
                                <label for="returnEquipmentId" class="form-label" style="color: #f0f0f0;">Borrow ID</label>
                                <input type="text" id="returnEquipmentId" name="borrow_id" class="form-control" required style="border-radius: 20px; background-color: #333; color: #fff;">
                            </div>
                            <button type="submit" class="btn btn-danger w-100" style="border-radius: 20px; background-color: #ff2d55;">Return Equipment</button>
                        </form>
                    </div>

                    <!-- Add Equipment Modal -->
                    <div class="modal fade" id="addEquipmentModal" tabindex="-1" aria-labelledby="addEquipmentModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 shadow" style="background-color: #1c1c1c;">
                                <div class="modal-header" style="border-bottom: none;">
                                    <h5 class="modal-title" id="addEquipmentModalLabel" style="color: #ff2d55;">Add Equipment</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: #ff2d55;"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="addEquipmentForm" onsubmit="return validatePasswords()">
                                        <div class="mb-3">
                                            <label for="equipmentName" class="form-label" style="color: #f0f0f0;">Equipment Name</label>
                                            <input type="text" id="equipmentName" name="equipmentName" class="form-control" required style="border-radius: 20px; background-color: #333; color: #fff;">
                                        </div>
                                        <div class="mb-3">
                                            <label for="quantity" class="form-label" style="color: #f0f0f0;">Quantity</label>
                                            <input type="number" id="quantity" name="quantity" class="form-control" required style="border-radius: 20px; background-color: #333; color: #fff;">
                                        </div>
                                        <div class="mb-3">
                                            <label for="brand" class="form-label" style="color: #f0f0f0;">Brand</label>
                                            <input type="text" id="brand" name="brand" class="form-control" required style="border-radius: 20px; background-color: #333; color: #fff;">
                                        </div>
                                        <button type="submit" class="btn btn-danger w-100" style="border-radius: 20px; background-color: #ff2d55;">Create Account</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Borrow Equipment Modal -->
                    <div class="modal fade" id="borrowModal" tabindex="-1" aria-labelledby="borrowModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 shadow" style="background-color: #1c1c1c;">
                                <div class="modal-header" style="border-bottom: none;">
                                    <h5 class="modal-title" id="borrowModalLabel" style="color: #ff2d55;">Borrow Equipment</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: #ff2d55;"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="borrowForm">
                                        <input type="hidden" id="borrowEquipmentId" name="equipment_id">
                                        <input type="hidden" id="staffId" name="staffId">
                                        <div class="mb-3">
                                            <label for="borrowerName" class="form-label" style="color: #f0f0f0;">Borrower Name</label>
                                            <input type="text" id="borrowerName" name="borrower_name" class="form-control" required style="border-radius: 20px; background-color: #333; color: #fff;">
                                        </div>
                                        <div class="mb-3">
                                            <label for="borrowerType" class="form-label" style="color: #f0f0f0;">Borrower Type</label>
                                            <select id="borrowerType" name="borrower_type" class="form-select" required style="border-radius: 20px; background-color: #333; color: #fff;">
                                                <option value="Student">Student</option>
                                                <option value="Faculty">Faculty</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="quantity" class="form-label" style="color: #f0f0f0;">Quantity</label>
                                            <input type="number" id="quantity" name="quantity" class="form-control" required style="border-radius: 20px; background-color: #333; color: #fff;" min="1">
                                        </div>
                                        <div class="mb-3">
                                            <label for="idNumber" class="form-label" style="color: #f0f0f0;">ID Number</label>
                                            <input type="text" id="idNumber" name="id_number" class="form-control" required style="border-radius: 20px; background-color: #333; color: #fff;">
                                        </div>
                                        <div class="mb-3">
                                            <label for="department" class="form-label" style="color: #f0f0f0;">Department</label>
                                            <input type="text" id="department" name="department" class="form-control" required style="border-radius: 20px; background-color: #333; color: #fff;">
                                        </div>
                                        <div class="mb-3">
                                            <label for="course" class="form-label" style="color: #f0f0f0;">Course</label>
                                            <input type="text" id="course" name="course" class="form-control" required style="border-radius: 20px; background-color: #333; color: #fff;">
                                        </div>
                                        <button type="submit" class="btn btn-danger w-100" style="border-radius: 20px; background-color: #ff2d55;">Confirming Borrowing</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Return Equipment Modal -->
                    <div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 shadow" style="background-color: #1c1c1c;">
                                <div class="modal-header" style="border-bottom: none;">
                                    <h5 class="modal-title" id="returnModalLabel" style="color: #ff2d55;">Return Equipment Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: #ff2d55;"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="returnForm2">
                                        <input type="hidden" id="rEquipmentId" name="borrow_id">

                                        <div class="mb-3">
                                            <label for="borrowerName" class="form-label" style="color: #f0f0f0;">Borrower Name</label>
                                            <input type="text" id="rborrowerName" name="borrower_name" class="form-control" required style="border-radius: 20px; background-color: #333; color: #fff;" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="rEquipmentName" class="form-label" style="color: #f0f0f0;">Equipment Borrowed</label>
                                            <input type="text" id="rEquipmentName" name="equipment_borrowed" class="form-control" required style="border-radius: 20px; background-color: #333; color: #fff;" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="rquantity" class="form-label" style="color: #f0f0f0;">Quantity</label>
                                            <input type="number" id="rquantity" name="rquantity" class="form-control" required style="border-radius: 20px; background-color: #333; color: #fff;" min="1"disabled>
                                        </div>
                                        <button type="submit" class="btn btn-danger w-100" style="border-radius: 20px; background-color: #ff2d55;">Return Equipment</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                     <!-- Mark Equipment Missing Modal -->
                     <div class="modal fade" id="missingModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 shadow" style="background-color: #1c1c1c;">
                                <div class="modal-header" style="border-bottom: none;">
                                    <h5 class="modal-title" id="missingModalLabel" style="color: #ff2d55;">Confirm Marking as Missing</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: #ff2d55;"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to mark this item as <strong>Missing</strong>?
                                    <br><br>
                                    <strong>Equipment ID:</strong> <span id="mEquipmentIdText"></span><br>
                                    <strong>Equipment Name:</strong> <span id="mEquipmentNameText"></span><br>
                                    <strong>Quantity:</strong> <span id="mQuantityText"></span>
                                    <hr>
                                    <form id="missingForm">
                                        <input type="hidden" id="borrowingId" name="borrowingId">
                                        <button type="submit" class="btn btn-danger w-100" style="border-radius: 20px; background-color: #ff2d55;">Mark as Missing</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Remove Equipment Modal -->
                    <div class="modal fade" id="removeEquipmentModal" tabindex="-1" aria-labelledby="removeEquipmentModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 shadow" style="background-color: #1c1c1c;">
                                <div class="modal-header" style="border-bottom: none;">
                                    <h5 class="modal-title" id="removeEquipmentModalLabel" style="color: #ff2d55;">Remove Equipment</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: #ff2d55;"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to permanently <strong><span style="color: red;">Remove</span></strong> this equipment?
                                    <br><br>
                                    <strong>Equipment ID:</strong> <span id="equipmentIdText"></span><br>
                                    <strong>Equipment Name:</strong> <span id="equipmentNameText"></span><br>
                                    <hr>
                                    <form id="removeEquipmentForm">
                                        <input type="hidden" id="equipmentId" name="equipmentId">
                                        <button type="submit" class="btn btn-danger w-100" style="border-radius: 20px; background-color: #ff2d55;">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- View Borrowed Equipment Section -->
                    <div id="viewBorrowedSection" class="section mt-4" style="display: none;">
                        <h2>View Borrowed Equipment</h2>
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th>Borrow ID</th>
                                    <th>Borrower Type</th>
                                    <th>ID Number</th>
                                    <th>Department</th>
                                    <th>Course</th>
                                    <th>Released By</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                    
                                    // Fetch borrowed equipment details
                                    $stmtBorrowed = $pdo->prepare(
                                        "SELECT *, borrowing.quantity AS borrowed_quantity, borrowing.equipment_id AS borrow_equipment_id 
                                        FROM borrowing 
                                        INNER JOIN users INNER JOIN equipment INNER JOIN borrowingstatus
                                        WHERE borrowing.released_by = users.user_id 
                                        AND borrowing.equipment_id = equipment.equipment_id
                                        AND borrowing.borrowing_status = borrowingstatus.status_id
                                        AND borrowing.borrowing_status = 1
                                        AND borrowing.released_by = $currentUserId"
                                    );
                                    $stmtBorrowed->execute();
                                    $borrowedEquipment = $stmtBorrowed->fetchAll(PDO::FETCH_ASSOC);

                                    function getStatusClass($status) {
                                        switch ($status) {
                                            case 'Borrowed':
                                                return 'bg-warning';
                                            case 'Returned':
                                                return 'bg-success';
                                            case 'Missing':
                                                return 'bg-danger';
                                        }
                                    }

                                    // Check if data is found
                                    if (empty($borrowedEquipment)): ?>
                                    <tr>
                                        <td colspan="9" class="text-center">No data found</td>
                                    </tr>
                                <?php else:
                                    foreach ($borrowedEquipment as $borrowed): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($borrowed['borrowing_id']); ?></td>
                                            <td><?php echo htmlspecialchars($borrowed['borrower_type']); ?></td>
                                            <td><?php echo htmlspecialchars($borrowed['id_number']); ?></td>
                                            <td><?php echo htmlspecialchars($borrowed['department']); ?></td>
                                            <td><?php echo htmlspecialchars($borrowed['course']); ?></td>
                                            <td><?php echo htmlspecialchars($borrowed['username']); ?></td>
                                            <td>
                                                <span class="status-circle <?php echo getStatusClass($borrowed['status_name']); ?>"></span>
                                                <?php echo htmlspecialchars($borrowed['status_name']); ?>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <button 
                                                        class="returnBtn btn btn-danger mb-2" 
                                                        data-id="<?php echo $borrowed['borrowing_id']; ?>" 
                                                        data-borrower-name="<?php echo htmlspecialchars($borrowed['borrower_name']); ?>"
                                                        data-borrowed-equipment="<?php echo htmlspecialchars($borrowed['equipment_name']); ?>"
                                                        data-quantity="<?php echo $borrowed['borrowed_quantity']; ?>"
                                                        data-bs-toggle="modal" data-bs-target="#returnModal"
                                                    >
                                                        Return
                                                    </button>
                                                    <button 
                                                        class="missingBtn btn btn-danger" 
                                                        data-id="<?php echo $borrowed['borrowing_id']; ?>"
                                                        data-borrower-name="<?php echo htmlspecialchars($borrowed['borrower_name']); ?>"
                                                        data-equipment-id="<?php echo $borrowed['equipment_id']; ?>"
                                                        data-borrowed-equipment="<?php echo htmlspecialchars($borrowed['equipment_name']); ?>"
                                                        data-quantity="<?php echo $borrowed['borrowed_quantity']; ?>"
                                                        data-bs-toggle="modal" data-bs-target="#missingModal"
                                                    >
                                                        Missing
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                endif;
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- View Returned Equipment Section -->
                    <div id="viewReturnedSection" class="section mt-4" style="display: none;">
                        <h2>View Returned Equipment</h2>
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th>Borrow ID</th>
                                    <th>Borrower Type</th>
                                    <th>Borrower Name</th>
                                    <th>ID Number</th>
                                    <th>Department</th>
                                    <th>Course</th>
                                    <th>Released By</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch returned equipment details
                                $stmtReturned = $pdo->prepare(
                                    "SELECT *, borrowing.quantity AS borrowed_quantity, borrowing.equipment_id AS borrow_equipment_id 
                                    FROM borrowing 
                                    INNER JOIN users INNER JOIN equipment INNER JOIN borrowingstatus
                                    WHERE borrowing.released_by = users.user_id 
                                    AND borrowing.equipment_id = equipment.equipment_id
                                    AND borrowing.borrowing_status = borrowingstatus.status_id
                                    AND borrowing.borrowing_status = 2
                                    AND borrowing.released_by = $currentUserId"
                                );
                                $stmtReturned->execute();
                                $returnedEquipment = $stmtReturned->fetchAll(PDO::FETCH_ASSOC);

                                // Check if data is found
                                if (empty($returnedEquipment)): ?>
                                    <tr>
                                        <td colspan="9" class="text-center">No data found</td>
                                    </tr>
                                <?php else:
                                    foreach ($returnedEquipment as $returned): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($returned['borrowing_id']); ?></td>
                                            <td><?php echo htmlspecialchars($returned['borrower_type']); ?></td>
                                            <td><?php echo htmlspecialchars($returned['borrower_name']); ?></td>
                                            <td><?php echo htmlspecialchars($returned['id_number']); ?></td>
                                            <td><?php echo htmlspecialchars($returned['department']); ?></td>
                                            <td><?php echo htmlspecialchars($returned['course']); ?></td>
                                            <td><?php echo htmlspecialchars($returned['username']); ?></td>
                                            <td><?php echo htmlspecialchars($returned['quantity']); ?></td>
                                            <td>
                                                <span class="status-circle <?php echo getStatusClass($returned['status_name']); ?>"></span>
                                                <?php echo htmlspecialchars($returned['status_name']); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                endif;
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- View Missing Equipment Section -->
                    <div id="viewMissingSection" class="section mt-4" style="display: none;">
                        <h2>View Missing Equipment</h2>
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th>Borrow ID</th>
                                    <th>Borrower Type</th>
                                    <th>Borrower Name</th>
                                    <th>ID Number</th>
                                    <th>Department</th>
                                    <th>Course</th>
                                    <th>Released By</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmtMissing = $pdo->prepare(
                                    "SELECT *, borrowing.quantity AS borrowed_quantity, borrowing.equipment_id AS borrow_equipment_id 
                                    FROM borrowing 
                                    INNER JOIN users INNER JOIN equipment INNER JOIN borrowingstatus
                                    WHERE borrowing.released_by = users.user_id 
                                    AND borrowing.equipment_id = equipment.equipment_id
                                    AND borrowing.borrowing_status = borrowingstatus.status_id
                                    AND borrowing.borrowing_status = 3
                                    AND borrowing.released_by = $currentUserId"
                                );
                                $stmtMissing->execute();
                                $missingEquipment = $stmtMissing->fetchAll(PDO::FETCH_ASSOC);

                                // Check if data is found
                                if (empty($missingEquipment)): ?>
                                    <tr>
                                        <td colspan="9" class="text-center">No data found</td>
                                    </tr>
                                <?php else:
                                    foreach ($missingEquipment as $data): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($data['borrowing_id']); ?></td>
                                            <td><?php echo htmlspecialchars($data['borrower_type']); ?></td>
                                            <td><?php echo htmlspecialchars($data['borrower_name']); ?></td>
                                            <td><?php echo htmlspecialchars($data['id_number']); ?></td>
                                            <td><?php echo htmlspecialchars($data['department']); ?></td>
                                            <td><?php echo htmlspecialchars($data['course']); ?></td>
                                            <td><?php echo htmlspecialchars($data['username']); ?></td>
                                            <td><?php echo htmlspecialchars($data['borrowed_quantity']); ?></td>
                                            <td>
                                                <span class="status-circle <?php echo getStatusClass($data['status_name']); ?>"></span>
                                                <?php echo htmlspecialchars($data['status_name']); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                endif;
                                ?>
                            </tbody>
                        </table>
                    </div>


                    <!-- Footer -->
                    <footer class="mt-auto text-white text-center py-3">
                        <p>&copy; 2024 Equipment Management System. All rights reserved.</p>
                    </footer>
                </main>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function () {
                document.querySelectorAll('.section').forEach(section => section.style.display = 'none');
                const target = this.getAttribute('id');
                if (target === 'borrowLink') {
                    document.getElementById('dashboardSection').style.display = 'block';
                    document.getElementById('borrowSection').style.display = 'block';
                } else if (target === 'returnLink') {
                    document.getElementById('dashboardSection').style.display = 'block';
                    document.getElementById('returnSection').style.display = 'block';
                } else if (target === 'viewBorrowedLink') {
                    document.getElementById('dashboardSection').style.display = 'block';
                    document.getElementById('viewBorrowedSection').style.display = 'block';
                } else if (target == 'viewReturnedLink'){
                    document.getElementById('dashboardSection').style.display = 'block';
                    document.getElementById('viewReturnedSection').style.display = 'block';
                } else if (target == 'viewMissingLink'){
                    document.getElementById('dashboardSection').style.display = 'block';
                    document.getElementById('viewMissingSection').style.display = 'block';
                } else if (target == 'viewDashboard2Link') {
                    document.getElementById('dashboardSection').style.display = 'none';
                    document.getElementById('dashboardSection2').style.display = 'block';
                } else if (target == 'viewDashboardLink') {
                    document.getElementById('dashboardSection').style.display = 'block';
                }else {
                    document.getElementById('dashboardSection').style.display = 'block';
                }
            });
        });

        // Borrow Equipment functionality
        document.getElementById('borrowLink').addEventListener('click', function() {
            document.querySelectorAll('.section').forEach(section => section.style.display = 'none');
            document.getElementById('borrowSection').style.display = 'block';
        });

        document.querySelectorAll('.borrowBtn').forEach(btn => {
            btn.addEventListener('click', function () {
                const equipmentId = this.getAttribute('data-id');
                const staffId = this.getAttribute('data-staff-id');

                document.getElementById('borrowEquipmentId').value = equipmentId;
                document.getElementById('staffId').value = staffId;
            });
        });

        document.getElementById('borrowForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('borrow.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Equipment borrowed successfully!');
                    window.location.reload();
                } else {
                    alert('Error borrowing equipment: ' + data.message);
                }
            });
        });

        // Return Equipment functionality
        document.querySelectorAll('.returnBtn').forEach(btn => {
            btn.addEventListener('click', function () {
                const equipmentId = this.getAttribute('data-id');
                const borrowerName = this.getAttribute('data-borrower-name');
                const rEquipmentName = this.getAttribute('data-borrowed-equipment');
                const quantity = this.getAttribute('data-quantity');

                document.getElementById('rEquipmentId').value = equipmentId;
                document.getElementById('rborrowerName').value = borrowerName;
                document.getElementById('rEquipmentName').value = rEquipmentName;
                document.getElementById('rquantity').value = quantity;
            });
        });

        // General form submit handler
        function handleReturnFormSubmit(e) {
            e.preventDefault();

            const formData = new FormData(this);
            fetch('return_equipment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) 
            .then(data => {
                if (data.success) {
                    alert('Equipment returned successfully!');
                    window.location.reload();  
                } else {
                    alert('Error returning equipment: ' + data.message);
                }
            });
        }

        // Add event listeners to both forms
        document.getElementById('returnForm1').addEventListener('submit', handleReturnFormSubmit);
        document.getElementById('returnForm2').addEventListener('submit', handleReturnFormSubmit);

        // Mark Missing borrowed equipment
        document.querySelectorAll('.missingBtn').forEach(btn => {
            btn.addEventListener('click', function () {
                const borrowingId = this.getAttribute('data-id');
                const equipmentId = this.getAttribute('data-equipment-id');
                const equipmentName = this.getAttribute('data-borrowed-equipment');
                const quantity = this.getAttribute('data-quantity');

                document.getElementById('borrowingId').value = borrowingId;
                document.getElementById('mEquipmentIdText').textContent = equipmentId;
                document.getElementById('mEquipmentNameText').textContent = equipmentName;
                document.getElementById('mQuantityText').textContent = quantity;
            });
        });

        document.getElementById('missingForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            fetch('missing.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Equipment marked missing!');
                    window.location.reload();
                } else {
                    alert('Error marking equipment as missing: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error during fetch:', error);
                alert('There was an error processing the request.');
            });
        });

        // Add Equipment
        document.getElementById('addEquipmentButton').addEventListener('click', function(event) {
            event.preventDefault();
            new bootstrap.Modal(document.getElementById('addEquipmentModal')).show();
        });

        document.getElementById('addEquipmentForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch('add_equipment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Successfully added an equipment!');
                    window.location.reload();
                } else {
                    alert('Error adding an equipment: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });

        // Delete Equipment
        document.querySelectorAll('.removeEquipmentBtn').forEach(btn => {
            btn.addEventListener('click', function () {
                const equipmentId = this.getAttribute('data-id');
                const equipmentName = this.getAttribute('data-name');

                document.getElementById('equipmentId').value = equipmentId;
                document.getElementById('equipmentIdText').textContent = equipmentId;
                document.getElementById('equipmentNameText').textContent = equipmentName;
            });
        });

        document.getElementById('removeEquipmentForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('remove_equipment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Equipment removed successfully!');
                    window.location.reload();
                } else {
                    alert('Error removing equipment: ' + data.message);
                }
            });
        });
    </script>
</body>
</html>
