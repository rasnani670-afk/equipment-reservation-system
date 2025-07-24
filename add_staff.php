

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Dashboard</title>
</head>
<body>
    <h2>Welcome to the Staff Dashboard</h2>
    <table border="1">
        <tr>
            <th>Equipment</th>
            <th>Quantity</th>
            <th>Brand</th>
        </tr>
        <?php foreach ($equipmentList as $equipment): ?>
        <tr>
            <td><?php echo htmlspecialchars($equipment['equipment_name']); ?></td>
            <td><?php echo htmlspecialchars($equipment['quantity']); ?></td>
            <td><?php echo htmlspecialchars($equipment['brand']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h3>Actions</h3>
    <a href="borrow.php">Borrow Equipment</a> | 
    <a href="return.php">Return Equipment</a> | 
    <a href="reserve.php">Reserve Equipment</a> | 
    <a href="logout.php">Logout</a>
</body>
</html>
