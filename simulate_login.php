<?php
// Simulate the login POST request
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST['username'] = 'testuser1';
$_POST['password'] = 'password123';

echo "=== SIMULATING LOGIN REQUEST ===\n";
echo "Username: {$_POST['username']}\n";
echo "Password: {$_POST['password']}\n\n";

// Start output buffering to capture the HTML output
ob_start();
include 'login.php';
$output = ob_get_clean();

// Print just the error part if present
if (preg_match('/<div class="alert alert-danger">(.+?)<\/div>/', $output, $matches)) {
    echo "Error Message: " . strip_tags($matches[1]) . "\n";
} elseif (isset($_SESSION['user_name'])) {
    echo "✓ Login successful!\n";
    echo "Session user_name: {$_SESSION['user_name']}\n";
    echo "Session estAdmin: {$_SESSION['estAdmin']}\n";
} else {
    echo "No error message and no session set - unexpected result\n";
}
?>
