<?php
require_once 'db.php';

echo "=== Creating Test User and Testing Login ===\n\n";

// Check current users
echo "Current users:\n";
$users = $pdo->query("SELECT user_name, estAdmin, LENGTH(passwords) as pass_len FROM users")->fetchAll();
foreach ($users as $u) {
    echo "  - {$u['user_name']} (Admin: {$u['estAdmin']}, Pass Length: {$u['pass_len']})\n";
}
echo "\n";

// Delete test user if exists
$pdo->exec("DELETE FROM users WHERE user_name = 'testuser1'");

// Create a test regular user
$username = 'testuser1';
$password = 'password123';
$hashed = password_hash($password, PASSWORD_DEFAULT);

echo "Creating test user...\n";
echo "  Username: $username\n";
echo "  Password: $password\n";
echo "  Hash: $hashed\n";
echo "  Hash Length: " . strlen($hashed) . "\n\n";

$stmt = $pdo->prepare("INSERT INTO users (user_name, nom, prenom, email, passwords, estAdmin, date_inscricption) VALUES (?, ?, ?, ?, ?, ?, CURDATE())");
$stmt->execute(['testuser1', 'Test', 'User', 'test@test.com', $hashed, 0]);

echo "✓ User created!\n\n";

// Now test the login logic
echo "Testing login logic...\n";
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_name = :username");
$stmt->execute([':username' => $username]);
$user = $stmt->fetch();

if (!$user) {
    die("ERROR: User not found after creation!\n");
}

echo "User found in database.\n";
echo "Stored password: {$user['passwords']}\n";
echo "Stored password length: " . strlen($user['passwords']) . "\n\n";

// Test verification
$plain_match = ($password === $user['passwords']);
$hash_match = password_verify($password, $user['passwords']);

echo "Plain text match: " . ($plain_match ? "YES" : "NO") . "\n";
echo "password_verify match: " . ($hash_match ? "YES" : "NO") . "\n\n";

if ($hash_match) {
    echo "✓✓✓ LOGIN SHOULD WORK! ✓✓✓\n";
    echo "\nYou can now log in with:\n";
    echo "  Username: testuser1\n";
    echo "  Password: password123\n";
} else {
    echo "✗✗✗ LOGIN WILL FAIL ✗✗✗\n";
    echo "Something is wrong with password storage/verification.\n";
}
?>
