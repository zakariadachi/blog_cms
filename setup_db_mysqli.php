<?php
// setup_db_mysqli.php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_PORT', 3307);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    echo "Connecting to MySQL via MySQLi...\n";
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, '', DB_PORT);
    
    // Create DB
    echo "Creating database 'blog_cms'...\n";
    $mysqli->query("CREATE DATABASE IF NOT EXISTS blog_cms");
    $mysqli->select_db("blog_cms");

    // Read SQL
    $sqlFile = 'blog_cms (2).sql';
    $sql = file_get_contents($sqlFile);
    
    // Fix Collation for compatibility (MariaDB/Older MySQL)
    $sql = str_replace('utf8mb4_0900_ai_ci', 'utf8mb4_unicode_ci', $sql);

    echo "Importing SQL with multi_query...\n";
    if ($mysqli->multi_query($sql)) {
        do {
            // Consume results
            if ($result = $mysqli->store_result()) {
                $result->free();
            }
        } while ($mysqli->next_result());
        echo "Import complete!\n";
    } else {
        echo "Error executing SQL: " . $mysqli->error . "\n";
    }
    
    // Fix password field length for bcrypt compatibility
    echo "Fixing password field length for bcrypt...\n";
    $mysqli->query("ALTER TABLE users MODIFY COLUMN passwords VARCHAR(255) DEFAULT 'user1234'");
    echo "Done.\n";

    $mysqli->close();

} catch (mysqli_sql_exception $e) {
    die("MySQLi Error: " . $e->getMessage() . "\n");
}
?>
