<?php
/**
 * Database Connection Fix for Hostinger
 * Upload ke root dan akses: https://antirugi.app/fix-db.php
 * HAPUS file ini setelah selesai!
 */

header('Content-Type: text/html; charset=utf-8');

echo "<h1>🔧 Database Connection Fix</h1>";

// Test database connection from .env
$envFile = __DIR__ . '/.env';
if (!file_exists($envFile)) {
    die("<p style='color:red'>❌ .env file not found!</p>");
}

// Parse .env
$env = [];
$lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
    if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
        list($key, $value) = explode('=', $line, 2);
        $env[trim($key)] = trim($value);
    }
}

$dbHost = $env['DB_HOST'] ?? 'localhost';
$dbDatabase = $env['DB_DATABASE'] ?? '';
$dbUsername = $env['DB_USERNAME'] ?? '';
$dbPassword = $env['DB_PASSWORD'] ?? '';

echo "<h2>Current .env Settings:</h2>";
echo "<pre>";
echo "DB_HOST: $dbHost\n";
echo "DB_DATABASE: $dbDatabase\n";
echo "DB_USERNAME: $dbUsername\n";
echo "DB_PASSWORD: " . str_repeat('*', strlen($dbPassword)) . "\n";
echo "</pre>";

echo "<h2>Test Connection:</h2>";

try {
    $dsn = "mysql:host=$dbHost;port=3306;charset=utf8mb4";
    $pdo = new PDO($dsn, $dbUsername, $dbPassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5
    ]);
    echo "<p style='color:green'>✅ Connected to MySQL server!</p>";
    
    // Test database exists
    $stmt = $pdo->query("SHOW DATABASES LIKE '$dbDatabase'");
    $exists = $stmt->fetch();
    
    if ($exists) {
        echo "<p style='color:green'>✅ Database '$dbDatabase' exists!</p>";
        
        // Try to use database
        $pdo->exec("USE `$dbDatabase`");
        echo "<p style='color:green'>✅ Can access database!</p>";
        
        // Check tables
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo "<p>Tables found: " . count($tables) . "</p>";
        if (count($tables) > 0) {
            echo "<ul>";
            foreach ($tables as $table) {
                echo "<li>$table</li>";
            }
            echo "</ul>";
        } else {
            echo "<p style='color:orange'>⚠️ No tables found - need to import SQL!</p>";
        }
    } else {
        echo "<p style='color:red'>❌ Database '$dbDatabase' NOT found!</p>";
        echo "<p>Create it in cPanel → MySQL Database Wizard</p>";
    }
} catch (PDOException $e) {
    echo "<p style='color:red'>❌ Connection failed: " . $e->getMessage() . "</p>";
    
    if (strpos($e->getMessage(), '1045') !== false) {
        echo "<h3>🔧 Fix Suggestions:</h3>";
        echo "<ol>";
        echo "<li>Go to cPanel → MySQL Database Wizard</li>";
        echo "<li>Create database: <strong>$dbDatabase</strong></li>";
        echo "<li>Create user: <strong>$dbUsername</strong></li>";
        echo "<li>Set password: <strong>" . htmlspecialchars($dbPassword) . "</strong></li>";
        echo "<li>Add user to database with ALL PRIVILEGES</li>";
        echo "<li>Try again</li>";
        echo "</ol>";
        
        // Show password for copy-paste
        echo "<p><strong>Password to use:</strong> <code>" . htmlspecialchars($dbPassword) . "</code></p>";
    }
}

echo "<hr><p><strong>⚠️ DELETE this file after fixing!</strong></p>";
