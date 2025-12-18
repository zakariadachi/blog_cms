<?php
require_once 'db.php';
require_once 'functions.php';

echo "=== LOGIN DEBUG ===\n\n";

// Check what users exist
$users = $pdo->query("SELECT user_name, passwords, estAdmin FROM users")->fetchAll();

echo "Current users in database:\n";
foreach ($users as $u) {
    echo "  - {$u['user_name']} | Admin: {$u['estAdmin']} | Password: " . substr($u['passwords'], 0, 20) . "...\n";
}

echo "\n";

// Test login for a user
if ($argc < 3) {
    echo "Usage: php debug_login.php <username> <password>\n";
    echo "Example: php debug_login.php testuser mypassword\n";
    exit;
}

$test_username = $argv[1];
$test_password = $argv[2];

echo "Testing login for: $test_username\n";
echo "Password: $test_password\n\n";

$stmt = $pdo->prepare("SELECT * FROM users WHERE user_name = :username");
$stmt->execute([':username' => $test_username]);
$user = $stmt->fetch();

if (!$user) {
    echo "ERROR: User '$test_username' not found in database.\n";
    exit;
}

echo "User found!\n";
echo "Stored password hash: {$user['passwords']}\n";
echo "Admin status: {$user['estAdmin']}\n\n";

// Test password verification
$plain_match = ($test_password === $user['passwords']);
$hash_match = password_verify($test_password, $user['passwords']);

echo "Plain text match: " . ($plain_match ? "YES" : "NO") . "\n";
echo "Password_verify match: " . ($hash_match ? "YES" : "NO") . "\n\n";

if ($plain_match || $hash_match) {
    echo "✓ LOGIN WOULD SUCCEED\n";
} else {
    echo "✗ LOGIN WOULD FAIL\n";
    echo "\nTrying to generate correct hash:\n";
    $correct_hash = password_hash($test_password, PASSWORD_DEFAULT);
    echo "Hash for '$test_password': $correct_hash\n";
}
?>
