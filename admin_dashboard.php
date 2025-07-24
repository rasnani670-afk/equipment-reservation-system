

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;700&display=swap">

    <style>
        body { font-family: 'Montserrat', sans-serif; background-color: #1c1c1c; color: #f0f0f0; padding-top: 68px;}
        .sidebar { background-color: #000; color: white; height: 100vh; position: fixed; width: 240px; padding-top: 20px; padding-bottom: 100px; overflow-y: auto; }
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
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="reserveEquipmentButton">
                                <i class="fas fa-calendar-alt"></i>
                                Reserve Equipment
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="createAccountButton">
                                <i class="fas fa-user-plus"></i>
                                Create Staff Account
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="viewAccountLink">
                                <i class="fas fa-user"></i>
                                View Staff Accounts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="viewReservedLink">
                                <i class="fas fa-user"></i>
                                View Reserved Equipments
                            </a>
                        </li>
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
                        <li class="nav-item">
                            <a class="nav-link" href="#" id="viewReportLink">
                                <i class="fas fa-clipboard-list"></i>
                                View Reports
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

                        <div style="display: flex; justify-content: flex-end; margin: 20px 0;">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search by equipment name or brand..." style="width: 350px;">
                        </div>

                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th>Equipment Name</th>
                                    <th>Brand</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody id="equipmentTableBody">
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
                        <div style="display: flex; justify-content: flex-end; margin: 20px 0;">
                            <input type="text" id="searchInput2" class="form-control" placeholder="Search by equipment name or brand..." style="width: 350px;">
                        </div>

                        <table class="table table-dark table-striped">
                            <thead>
                                <tr><th>Equipment Name</th><th>Brand</th><th>Quantity</th><th>Action</th></tr>
                            </thead>
                            <tbody id="equipmentTableBody2">
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
                                            <button class="borrowBtn btn btn-danger" data-id="<?php echo $equipment['equipment_id']; ?>" data-bs-toggle="modal" data-bs-target="#borrowModal">Borrow</button>
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

                    <!-- Create Staff Account Modal -->
                    <div class="modal fade" id="createAccountModal" tabindex="-1" aria-labelledby="createAccountModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 shadow" style="background-color: #1c1c1c;">
                                <div class="modal-header" style="border-bottom: none;">
                                    <h5 class="modal-title" id="createAccountModalLabel" style="color: #ff2d55;">Create Staff Account</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: #ff2d55;"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="createAccountForm" onsubmit="return validatePasswords()">
                                        <div class="mb-3">
                                            <label for="username" class="form-label" style="color: #f0f0f0;">Username</label>
                                            <input type="text" id="username" name="username" class="form-control" required style="border-radius: 20px; background-color: #333; color: #fff;">
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label" style="color: #f0f0f0;">Password</label>
                                            <input type="password" id="password" name="password" class="form-control" required style="border-radius: 20px; background-color: #333; color: #fff;">
                                        </div>
                                        <div class="mb-3">
                                            <label for="confirmPassword" class="form-label" style="color: #f0f0f0;">Confirm Password</label>
                                            <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" required style="border-radius: 20px; background-color: #333; color: #fff;">
                                            <div id="passwordError" class="text-danger mt-2" style="display: none;">Passwords do not match. Please try again.</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label" style="color: #f0f0f0;">Email</label>
                                            <input type="text" id="email" name="email" class="form-control" required style="border-radius: 20px; background-color: #333; color: #fff;">
                                        </div>
                                        <button type="submit" class="btn btn-danger w-100" style="border-radius: 20px; background-color: #ff2d55;">Create Account</button>
                                    </form>
                                </div>
                            </div>
                        </div>
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
                                        <div class="mb-3">
                                            <label for="releasedBy" class="form-label" style="color: #f0f0f0;">Released By</label>
                                            <select id="releasedBy" name="releasedBy" class="form-select" required style="border-radius: 20px; background-color: #333; color: #fff;">
                                                <?php foreach($stffList as $data){ ?>
                                                    <option value="<?php echo $data['user_id']?>" ><?php echo $data['username'] ?></option>
                                                <?php  } ?>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-danger w-100" style="border-radius: 20px; background-color: #ff2d55;">Confirming Borrowing</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reserve Equipment Modal -->
                    <div class="modal fade" id="reserveEquipmentModal" tabindex="-1" aria-labelledby="reserveEquipmentModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 shadow" style="background-color: #1c1c1c;">
                                <div class="modal-header" style="border-bottom: none;">
                                    <h5 class="modal-title" id="reserveEquipmentModalLabel" style="color: #ff2d55;">Make a Reservation</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: #ff2d55;"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="successMessage" style="display: none; padding: 10px; margin-bottom: 20px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px;">
                                        Reservation successfully made!
                                    </div>

                                    <form id="reservationForm" method="post" action="process_reservation.php">
                                        <div class="mb-3">
                                            <label for="equipment_id" class="form-label" style="color: #f0f0f0;">Equipment:</label>
                                            <select name="equipment_id" id="equipment_id" required class="form-select" style="border-radius: 20px; background-color: #333; color: #fff;">
                                                <?php
                                                    $stmtAvailable = $pdo->prepare("SELECT * FROM equipment WHERE available_quantity > 0 AND is_removed = FALSE");
                                                    $stmtAvailable->execute();
                                                    $availableEquipment = $stmtAvailable->fetchAll(PDO::FETCH_ASSOC);
                                                    foreach ($availableEquipment as $equipment): ?>
                                                        <option value="<?= htmlspecialchars($equipment['equipment_id']) ?>">
                                                            <?= htmlspecialchars($equipment['equipment_name']) ?> (Available: <?= htmlspecialchars($equipment['available_quantity']) ?>)
                                                        </option>
                                                    <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="reservation_name" class="form-label" style="color: #f0f0f0;">Reservation Name:</label>
                                            <input type="text" name="reservation_name" id="reservation_name" required class="form-control" style="border-radius: 20px; background-color: #333; color: #fff;">
                                        </div>

                                        <div class="mb-3">
                                            <label for="usage_date" class="form-label" style="color: #f0f0f0;">Usage Date:</label>
                                            <input type="date" name="usage_date" id="usage_date" required class="form-control" style="border-radius: 20px; background-color: #333; color: #fff;">
                                        </div>

                                        <div class="mb-3">
                                            <label for="quantity" class="form-label" style="color: #f0f0f0;">Quantity:</label>
                                            <input type="number" name="quantity" id="quantity" min="1" required class="form-control" style="border-radius: 20px; background-color: #333; color: #fff;">
                                        </div>

                                        <button type="submit" class="btn btn-danger w-100" style="border-radius: 20px; background-color: #ff2d55;">Reserve</button>
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

                    <!-- Delete User Account Modal -->
                    <div class="modal fade" id="userDeleteModal" tabindex="-1" aria-labelledby="userDeleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-4 shadow" style="background-color: #1c1c1c;">
                                <div class="modal-header" style="border-bottom: none;">
                                    <h5 class="modal-title" id="userDeleteModalLabel" style="color: #ff2d55;">Delete Account</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: #ff2d55;"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to permanently <strong><span style="color: red;">Delete</span></strong> this account?
                                    <br><br>
                                    <strong>User ID:</strong> <span id="userIdText"></span><br>
                                    <strong>Username:</strong> <span id="usernameText"></span><br>
                                    <hr>
                                    <form id="userDeleteForm">
                                        <input type="hidden" id="userId" name="userId">
                                        <button type="submit" class="btn btn-danger w-100" style="border-radius: 20px; background-color: #ff2d55;">Delete</button>
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

                    <!-- View Reserved Equipments -->
                    <div id="viewReservedEquipmentsSection" class="section mt-4" style="display: none;">
                        <h2>View Reserved Equipments</h2>
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th>Reservation ID</th>
                                    <th>Equipment Name</th>
                                    <th>Reservation Name</th>
                                    <th>Usage Date</th>
                                    <th>Reservation Date</th>
                                    <th>Quantity Reserved</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmtReservations = $pdo->prepare("
                                    SELECT r.*, e.equipment_name 
                                    FROM reservations r 
                                    JOIN equipment e ON r.equipment_id = e.equipment_id
                                ");
                                $stmtReservations->execute();
                                $reservations = $stmtReservations->fetchAll(PDO::FETCH_ASSOC);

                                // Check if data is found
                                if (empty($reservations)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No data found</td>
                                    </tr>
                                <?php else:
                                    foreach ($reservations as $reservation): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($reservation['reservation_id']) ?></td>
                                            <td><?= htmlspecialchars($reservation['equipment_name']) ?></td>
                                            <td><?= htmlspecialchars($reservation['reservation_name']) ?></td>
                                            <td><?= htmlspecialchars($reservation['usage_date']) ?></td>
                                            <td><?= htmlspecialchars($reservation['reservation_date']) ?></td>
                                            <td><?= htmlspecialchars($reservation['quantity']) ?></td>
                                            <td style="width: 160px;">
                                                <span class="status-circle <?php echo getReservationStatusClass($reservation['status']); ?>"></span>    
                                                <?= htmlspecialchars(ucfirst($reservation['status'])) ?>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <?php if ($reservation['status'] === 'pending'): ?>
                                                        <form id="cancelReservationForm" action="cancel_reservation.php" method="POST"> 
                                                            <input type="hidden" id="reservationId" name="reservation_id" value="<?= $reservation['reservation_id'] ?>">
                                                            <input type="hidden" id="equipmentId" name="equipment_id" value="<?= $reservation['equipment_id'] ?>">
                                                            <input type="hidden" id="quantity" name="quantity" value="<?= $reservation['quantity'] ?>">
                                                            <button type="submit" class="btn btn-danger mb-2">Cancel</button>
                                                        </form>

                                                        <form id="completeReservationForm" action="complete_reservation.php" method="POST">
                                                            <input type="hidden" name="reservation_id" value="<?= $reservation['reservation_id'] ?>">
                                                            <button type="submit" class="btn btn-success">Complete</button>
                                                        </form>

                                                    <?php elseif ($reservation['status'] === 'completed'): ?>
                                                        <span class="text-success font-weight-bold">Completed</span>
                                                    <?php elseif ($reservation['status'] === 'cancelled'): ?>
                                                        <span class="text-danger font-weight-bold">Cancelled</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                endif;
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- View User Accounts Section -->
                    <div id="viewAccountSection" class="section mt-4" style="display: none;">
                        <h2>View User Accounts</h2>
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // Fetch  details
                                    $stmtAccounts = $pdo->prepare(
                                        "SELECT user_id, username, password, role
                                        FROM users 
                                        WHERE role = 'staff'"
                                    );
                                    $stmtAccounts->execute();
                                    $accounts = $stmtAccounts->fetchAll(PDO::FETCH_ASSOC);

                                    // Check if data is found
                                    if (empty($accounts)): ?>
                                    <tr>
                                        <td colspan="9" class="text-center">No data found</td>
                                    </tr>
                                <?php else:
                                    foreach ($accounts as $data): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($data['user_id']); ?></td>
                                            <td><?php echo htmlspecialchars($data['username']); ?></td>
                                            <td><?php echo htmlspecialchars($data['password']); ?></td>
                                            <td><?php echo htmlspecialchars($data['role']); ?></td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <!-- <button 
                                                        class="userEditBtn btn btn-danger mb-2" 
                                                        data-id="<?php echo $data['user_id']; ?>" 
                                                        data-username="<?php echo htmlspecialchars($data['username']); ?>"
                                                        data-password="<?php echo htmlspecialchars($data['password']); ?>"
                                                        data-role="<?php echo $data['role']; ?>"
                                                        data-bs-toggle="modal" data-bs-target="#userEditModal"
                                                    >
                                                        Edit
                                                    </button> -->
                                                    <button 
                                                        class="userDeleteBtn btn btn-danger" 
                                                        data-id="<?php echo $data['user_id']; ?>"
                                                        data-username="<?php echo $data['username']; ?>"
                                                        data-bs-toggle="modal" data-bs-target="#userDeleteModal"
                                                    >
                                                        Delete
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
                                        AND borrowing.borrowing_status = 1"
                                    );
                                    $stmtBorrowed->execute();
                                    $borrowedEquipment = $stmtBorrowed->fetchAll(PDO::FETCH_ASSOC);

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
                                    AND borrowing.borrowing_status = 2"
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
                                    <th>Action</th>
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
                                    AND borrowing.borrowing_status = 3"
                                );
                                $stmtMissing->execute();
                                $missingEquipment = $stmtMissing->fetchAll(PDO::FETCH_ASSOC);

                                // Check if data is found
                                if (empty($missingEquipment)): ?>
                                    <tr>
                                        <td colspan="10" class="text-center">No data found</td>
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
                                            <td>
                                                <button 
                                                    class="returnBtn btn btn-danger mb-2" 
                                                    data-id="<?php echo $data['borrowing_id']; ?>" 
                                                    data-borrower-name="<?php echo htmlspecialchars($data['borrower_name']); ?>"
                                                    data-borrowed-equipment="<?php echo htmlspecialchars($data['equipment_name']); ?>"
                                                    data-quantity="<?php echo $data['borrowed_quantity']; ?>"
                                                    data-bs-toggle="modal" data-bs-target="#returnModal"
                                                >
                                                    Return
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                endif;
                                ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- View Reports Section -->
                    <div id="viewReportSection" class="section mt-4" style="display: none;">
                        <h2>View Reports</h2>

                        <!-- Button Section -->
                        <!-- <div id="generateReport buttonSection" class="button-section">
                            <button class="generatePDFBtn btn btn-danger mb-2">Generate Report</button>
                        </div> -->

                        <br>

                        <!-- Filter Section -->
                        <div class="mb-4">
                            <form id="filterForm">
                                <div class="row">
                                    <!-- Left Column: Month Filter -->
                                    <div class="col-md-4 col-sm-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <label for="monthFilter" class="form-label me-2" style="white-space: nowrap; width: 150px;">Filter by Month:</label>
                                            <select id="monthFilter" name="monthFilter" class="form-select">
                                                <option value="">Select Month</option>
                                                <option value="January">January</option>
                                                <option value="February">February</option>
                                                <option value="March">March</option>
                                                <option value="April">April</option>
                                                <option value="May">May</option>
                                                <option value="June">June</option>
                                                <option value="July">July</option>
                                                <option value="August">August</option>
                                                <option value="September">September</option>
                                                <option value="October">October</option>
                                                <option value="November">November</option>
                                                <option value="December">December</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Middle Column: Year Filter -->
                                    <div class="col-md-4 col-sm-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <label for="yearFilter" class="form-label me-2" style="white-space: nowrap; width: 150px;">Filter by Year:</label>
                                            <select id="yearFilter" name="yearFilter" class="form-select">
                                                <option value="">Select Year</option>
                                                <option value="2024">2024</option>
                                                <option value="2023">2023</option>
                                                <option value="2022">2022</option>
                                                <option value="2021">2021</option>
                                                <option value="2020">2020</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Right Column: Submit Button (Placed beside the Year Filter) -->
                                    <div class="col-md-2 col-sm-6 mb-3">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Informational Text-->
                        <div style="margin-top: -30px;">
                            <p style="font-size: 12px; color: #d9534f;">
                                <strong>Note:</strong> If no month or year is selected, the report will default to the overall equipment report.
                                <br>
                                <strong>Additional note:</strong>If a month is selected but no year is provided, the report will default to the current year.</span>
                            </p>
                        </div>

                        <!-- Summary of Key Metrics Section -->
                        <div class="container mt-4">
                            <div class="row">
                                <!-- Left Section (Summary of Key Metrics) -->
                                <div class="col-md-6">
                                    <h5>Overall Equipment Report Summary:</h5>
                                    <br>
                                    <ul class="list-unstyled">
                                        <li><strong>Total Borrowed:</strong> <span id="totalBorrowed">Loading...</span></li>
                                        <li><strong>Total Returned:</strong> <span id="totalReturned">Loading...</span></li>
                                        <li><strong>Total Missing:</strong> <span id="totalMissing">Loading...</span></li>
                                        <li><strong>Average Borrow Duration:</strong> <span id="avgBorrowDuration">Loading...</span> days</li>
                                    </ul>
                                </div>

                                <!-- Right Section (Filters and Equipment Report Summary) -->
                                <div class="col-md-6">
                                <h5 id="reportSummaryHeader">Equipment Report Summary by Month and Year:</h5>

                                    <!-- Equipment Report Summary Section -->
                                    <div class="summary p-3">
                                        <ul class="list-unstyled mb-0" id="report-summary">
                                            <!-- Dynamic data will be injected here -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Table Section -->
                        <div id="reportTableSection" class="table-section mt-4">
                            <h4 id="equipmentReportHeader">Equipment Report by Month and Year:</h4>
                            <table id="reportTable" class="table table-dark table-striped">
                                <thead>
                                    <tr>
                                        <th>Equipment Name</th>
                                        <th>Quantity Borrowed</th>
                                        <th>Quantity Returned</th>
                                        <th>Quantity Missing</th>
                                        <!-- <th>Status</th>
                                        <th>Actions</th> -->
                                    </tr>
                                </thead>
                                <tbody id="dataTable">
                                        <!-- Dynamic data will be injected here -->
                                </tbody>
                            </table>
                        </div>
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
                    document.getElementById('dashboardSection').style.display = 'none';
                    document.getElementById('viewBorrowedSection').style.display = 'block';
                } else if (target == 'viewReturnedLink'){
                    document.getElementById('dashboardSection').style.display = 'none';
                    document.getElementById('viewReturnedSection').style.display = 'block';
                } else if (target == 'viewMissingLink'){
                    document.getElementById('dashboardSection').style.display = 'none';
                    document.getElementById('viewMissingSection').style.display = 'block';
                } else if (target == 'viewAccountLink'){
                    document.getElementById('dashboardSection').style.display = 'block';
                    document.getElementById('viewAccountSection').style.display = 'block';
                } else if (target == 'reserveEquipmentLink') {
                    document.getElementById('dashboardSection').style.display = 'block';
                    document.getElementById('reserveEquipmentSection').style.display = 'block';
                } else if (target == 'viewReservedLink') {
                    document.getElementById('dashboardSection').style.display = 'none';
                    document.getElementById('viewReservedEquipmentsSection').style.display = 'block';
                } else if (target == 'viewReportLink') {
                    document.getElementById('dashboardSection').style.display = 'none';
                    document.getElementById('viewReportSection').style.display = 'block';
                } else if (target == 'viewDashboard2Link') { // Dashboard with delete equipment button
                    document.getElementById('dashboardSection').style.display = 'none';
                    document.getElementById('dashboardSection2').style.display = 'block';
                } else if (target == 'viewDashboardLink') { // Dashboard without delete equipment button
                    document.getElementById('dashboardSection').style.display = 'block';
                    document.getElementById('dashboardSection2').style.display = 'none';
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
                document.getElementById('borrowEquipmentId').value = equipmentId;
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


        // Show the "Create Staff Account" modal
        document.getElementById('createAccountButton').addEventListener('click', function(event) {
            event.preventDefault();
            new bootstrap.Modal(document.getElementById('createAccountModal')).show();
        });

        // Validation for password and confirm password under form submission for creating a new staff account
        function validatePasswords() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmPassword").value;
            var errorMessage = document.getElementById("passwordError");

            // Hide the error message initially
            errorMessage.style.display = "none";

            // Check if passwords match
            if (password !== confirmPassword) {
                errorMessage.style.display = "block";
                return false;
            }

            // Check password strength (optional, if you want more validation)
            // if (password.length < 6) {
            //     errorMessage.innerHTML = "Password must be at least 6 characters long.";
            //     errorMessage.style.display = "block";
            //     return false;
            // }

            //return true; // Allow form submission
        }

        // Form submission for creating a new staff account
        document.getElementById('createAccountForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch('create_account.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Successfully created a new account!');
                    window.location.reload();
                } else {
                    alert('Error creating a new account: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });

        // Delete User Account
        document.querySelectorAll('.userDeleteBtn').forEach(btn => {
            btn.addEventListener('click', function () {
                const userId = this.getAttribute('data-id');
                const username = this.getAttribute('data-username');

                document.getElementById('userId').value = userId;
                document.getElementById('userIdText').textContent = userId;
                document.getElementById('usernameText').textContent = username;
            });
        });

        document.getElementById('userDeleteForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch('delete_account.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Successfully deleted the account!');
                    window.location.reload();
                } else {
                    alert('Error deleted the account: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
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

        // Reserve Equipment Modal
        document.getElementById('reserveEquipmentButton').addEventListener('click', function(event) {
            event.preventDefault();
            new bootstrap.Modal(document.getElementById('reserveEquipmentModal')).show();
        });

        // Create Reserve Equipment
        document.getElementById('reservationForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            fetch(this.action, {
                method: this.method,
                body: formData
            })
            .then(response => response.json()) 
            .then(data => {
                if (data.success) {
                    alert('Reservation created successfully!');
                    window.location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('There was an error processing your reservation.');
            });
        });

        // Complete and Cancel Equipment Reservation
        document.addEventListener('DOMContentLoaded', function() {
            // Check if any forms for canceling or completing reservations exist
            const cancelReservationForms = document.querySelectorAll('#cancelReservationForm');
            const completeReservationForms = document.querySelectorAll('#completeReservationForm');

            // Handle cancel reservation forms
            cancelReservationForms.forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(form);
                    fetch(form.action, {
                        method: form.method,
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Reservation cancelled successfully!');
                            window.location.reload();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('There was an error cancelling the reservation.');
                    });
                });
            });

            // Handle complete reservation forms
            completeReservationForms.forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(form);
                    fetch(form.action, {
                        method: form.method,
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Reservation completed successfully!');
                            window.location.reload();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('There was an error completing the reservation.');
                    });
                });
            });
        });


        // Form submission for Report
        document.getElementById('filterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            const month = document.getElementById('monthFilter').value;
            const year = document.getElementById('yearFilter').value;

            let reportHeader = "Equipment Report Summary by";
            let tableHeader = "Equipment Report by";

            // Get current year if year is not provided
            const currentYear = new Date().getFullYear();

            if (month && year) {
                reportHeader += ` ${month} ${year}:`;
                tableHeader += ` ${month} ${year}:`;
            } else if (month) {
                reportHeader += ` ${month} ${currentYear}:`;
                tableHeader += ` ${month} ${currentYear}:`;
            } else if (year) {
                reportHeader += ` ${year}:`;
                tableHeader += ` ${year}:`;
            } else {
                reportHeader = "";
                tableHeader = "Overall Equipment Report:";
            }

            document.getElementById('reportSummaryHeader').textContent = reportHeader;
            document.getElementById('equipmentReportHeader').textContent = tableHeader;

            fetch('fetch_filter_report.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Check if there are no filters (no month or year)
                    if (!month && !year) {
                        document.getElementById('report-summary').innerHTML = ''; // Clear the summary if no filters are selected
                    } else {
                        document.getElementById('report-summary').innerHTML = `
                            <li><strong>Total Borrowed for Selected Period:</strong> ${data.total_borrowed}</li>
                            <li><strong>Total Returned for Selected Period:</strong> ${data.total_returned}</li>
                            <li><strong>Total Missing for Selected Period:</strong> ${data.total_missing}</li>
                            <li><strong>Average Borrow Duration for Selected Period:</strong> ${data.avg_borrow_duration} days</li>
                        `;
                    }

                    // Clear the table before inserting new rows
                    document.getElementById('dataTable').innerHTML = '';

                    // Assuming 'data' is the response object from the server
                    if (data.success && data.equipment.length > 0) {
                        // Loop through the equipment data and insert it into the table
                        data.equipment.forEach(item => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${item.equipment_name}</td>
                                <td>${item.quantity_borrowed}</td>
                                <td>${item.quantity_returned}</td>
                                <td>${item.quantity_missing}</td>
                            `;
                            document.getElementById('dataTable').appendChild(row);
                        });
                    } else {
                        // If no data or if the 'success' flag is false, show a message indicating no data
                        const noDataRow = document.createElement('tr');
                        noDataRow.innerHTML = `
                            <td colspan="4" style="text-align:center;">No data found for the selected period.</td>
                        `;
                        document.getElementById('dataTable').appendChild(noDataRow);
                    }
                } else {
                    document.getElementById('report-summary').innerHTML = `
                        <li>Error: ${data.message}</li>
                    `;
                }
            })
            .catch(error => {
                console.error("Fetch error:", error); // Log fetch errors
                document.getElementById('report-summary').innerHTML = `
                    <li>Error fetching the data.</li>
                `;
            });
        });

        // Function to fetch the overall equipment report data
        document.addEventListener("DOMContentLoaded", function() {
            fetch('fetch_overall_report.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success !== false) {
                        // Update the UI with the fetched data
                        document.getElementById('totalBorrowed').innerText = data.total_borrowed;
                        document.getElementById('totalReturned').innerText = data.total_returned;
                        document.getElementById('totalMissing').innerText = data.total_missing;
                        document.getElementById('avgBorrowDuration').innerText = data.avg_borrow_duration;
                    } else {
                        alert('Error fetching report: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while fetching the report.');
                });
        });

        // Get the search input and table body for dashboard equipment
        const searchInput = document.getElementById('searchInput');
        const tableBody = document.getElementById('equipmentTableBody');

        searchInput.addEventListener('input', function() {
            const searchTerm = searchInput.value.toLowerCase();
            
            const rows = tableBody.getElementsByTagName('tr');
            
            for (let i = 0; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                const equipmentName = cells[0].textContent.toLowerCase();
                const brand = cells[1].textContent.toLowerCase();
                
                if (equipmentName.includes(searchTerm) || brand.includes(searchTerm)) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        });

        // Get the search input and table body for dashboard equipment
        const searchInput2 = document.getElementById('searchInput2');
        const tableBody2 = document.getElementById('equipmentTableBody2');

        searchInput2.addEventListener('input', function() {
            const searchTerm = searchInput2.value.toLowerCase();
            
            const rows = tableBody2.getElementsByTagName('tr');
            
            for (let i = 0; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                const equipmentName = cells[0].textContent.toLowerCase();
                const brand = cells[1].textContent.toLowerCase();
                
                if (equipmentName.includes(searchTerm) || brand.includes(searchTerm)) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        });
    </script>   
</body>
</html>  