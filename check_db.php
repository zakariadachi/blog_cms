<?php
require_once 'db.php';

echo "Checking database users...\n\n";

$stmt = $pdo->query("SELECT user_name, email, estAdmin, LENGTH(passwords) as pass_length FROM users ORDER BY user_name");
$users = $stmt->fetchAll();

if (empty($users)) {
    echo "NO USERS FOUND IN DATABASE!\n";
    echo "The database appears to be empty.\n";
} else {
    echo "Found " . count($users) . " users:\n";
    foreach ($users as $u) {
        echo "  - {$u['user_name']} | {$u['email']} | Admin: {$u['estAdmin']} | Pass Length: {$u['pass_length']}\n";
    }
}
?>
