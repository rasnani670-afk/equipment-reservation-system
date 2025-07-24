<?php

include 'db.php'; // Assuming your PDO connection is in db.php

// Delete all users from the table before inserting new ones (only if necessary)
$pdo->exec("DELETE FROM users");

// Array of users to be added
$users = [
    ['username' => 'admin', 'password' => password_hash('admin123', PASSWORD_DEFAULT), 'role' => 'admin', 'email' => '20227193@s.ubaguio.edu'],
    ['username' => 'staff1', 'password' => password_hash('staff123', PASSWORD_DEFAULT), 'role' => 'staff', 'email' => 'staff1@example.com'],
    ['username' => 'staff2', 'password' => password_hash('staff123', PASSWORD_DEFAULT), 'role' => 'staff', 'email' => 'staff2@example.com'],
    ['username' => 'user1', 'password' => password_hash('user123', PASSWORD_DEFAULT), 'role' => 'user', 'email' => 'user1@example.com'],
];

// Loop to insert users into the database
foreach ($users as $user) {
    // SQL query to insert users with email and reset fields
    $sql = "INSERT INTO users (username, password, role, email, reset_token, reset_token_expiry) 
            VALUES (:username, :password, :role, :email, NULL, NULL)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'username' => $user['username'],
        'password' => $user['password'],
        'role' => $user['role'],
        'email' => $user['email']       
    ]);
}

echo "Users created successfully.";
?>
