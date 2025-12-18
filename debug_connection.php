<?php
// debug_connection.php
$host = 'localhost';
$ports = [3306, 3307];
$user = 'root';
$pass = '';

echo "<h2>MySQL Port Diagnostic</h2>";

foreach ($ports as $port) {
    echo "Testing connection to <b>$host:$port</b>... ";
    try {
        $dsn = "mysql:host=$host;port=$port;charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        echo "<span style='color:green'>SUCCESS! Server is running on port $port.</span><br>";
        
        // Check for database
        $stmt = $pdo->query("SHOW DATABASES LIKE 'blog_cms'");
        if ($stmt->fetch()) {
            echo " - Database 'blog_cms' exists.<br>";
        } else {
            echo " - Database 'blog_cms' does NOT exist.<br>";
        }
    } catch (PDOException $e) {
        echo "<span style='color:red'>FAILED.</span> (" . $e->getMessage() . ")<br>";
    }
    echo "<hr>";
}
?>
