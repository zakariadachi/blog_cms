<?php
// setup_db.php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_PORT', 3306);

try {
    // 1. Connect without DB name
    echo "Connecting to MySQL at " . DB_HOST . ":" . DB_PORT . "... ";
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    echo "Connected.\n";

    // 2. Create Database
    echo "Creating database 'blog_cms'... ";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS blog_cms");
    echo "Done.\n";

    // 3. Select Database
    $pdo->exec("USE blog_cms");

    // 4. Read SQL file
    $sqlFile = '127_0_0_1.sql';
    if (!file_exists($sqlFile)) {
        die("Error: SQL file '$sqlFile' not found.\n");
    }
    
    echo "Reading '$sqlFile'... ";
    $sql = file_get_contents($sqlFile);
    
    // 5. Execute SQL
    // Naïve approach: Execute the whole thing. If it fails, we split.
    echo "Importing SQL... ";
    try {
        $pdo->exec($sql);
        echo "Done.\n";
        echo "Database setup completed successfully.\n";
    } catch (PDOException $e) {
        echo "Failed to execute single block. Attempting to split by ';\n'...\n";
        // Simple split by semicolon at end of line
        $commands = explode(";\n", $sql);
        foreach ($commands as $cmd) {
            $cmd = trim($cmd);
            if (!empty($cmd)) {
                try {
                    $pdo->exec($cmd);
                } catch (PDOException $ex) {
                    echo "Warning: Error executing command: " . substr($cmd, 0, 50) . "... " . $ex->getMessage() . "\n";
                }
            }
        }
        echo "Split import completed.\n";
    }

} catch (PDOException $e) {
    die("Setup failed: " . $e->getMessage() . "\n");
}
?>
