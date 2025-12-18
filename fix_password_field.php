<?php
require_once 'db.php';

echo "Fixing password field length...\n";

try {
    // Change passwords column from VARCHAR(30) to VARCHAR(255)
    $pdo->exec("ALTER TABLE users MODIFY COLUMN passwords VARCHAR(255) DEFAULT 'user1234'");
    echo "✓ Successfully updated passwords column to VARCHAR(255)\n";
    
    echo "\nCurrent column info:\n";
    $result = $pdo->query("SHOW COLUMNS FROM users LIKE 'passwords'");
    $column = $result->fetch();
    echo "  Type: {$column['Type']}\n";
    echo "  Default: {$column['Default']}\n";
    
} catch (PDOException $e) {
    die("Error: " . $e->getMessage() . "\n");
}

echo "\n✓ Password field fix complete!\n";
echo "You can now create users with secure bcrypt passwords.\n";
?>
