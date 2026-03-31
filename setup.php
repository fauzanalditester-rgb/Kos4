<?php
/**
 * Complete Database & Environment Fix for Hostinger
 * Upload ke root dan akses: https://antirugi.app/setup.php
 * HAPUS file ini setelah selesai!
 */

header('Content-Type: text/html; charset=utf-8');
echo "<h1>🔧 Complete Setup & Fix Tool</h1>";

$envFile = __DIR__ . '/.env';
$envExample = __DIR__ . '/.env.example';

// ============================================
// STEP 1: Check current .env
// ============================================
echo "<h2>Step 1: Check Current .env</h2>";

if (!file_exists($envFile)) {
    echo "<p style='color:orange'>⚠️ .env not found! Will create from .env.example</p>";
    if (file_exists($envExample)) {
        copy($envExample, $envFile);
        echo "<p style='color:green'>✅ Created .env from .env.example</p>";
    } else {
        die("<p style='color:red'>❌ No .env or .env.example found!</p>");
    }
} else {
    echo "<p style='color:green'>✅ .env exists</p>";
}

// Parse current .env
$env = [];
$lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
    if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
        list($key, $value) = explode('=', $line, 2);
        $env[trim($key)] = trim($value);
    }
}

$currentDb = $env['DB_DATABASE'] ?? 'NOT SET';
$currentUser = $env['DB_USERNAME'] ?? 'NOT SET';
$currentPass = $env['DB_PASSWORD'] ?? 'NOT SET';

echo "<p>Current Database Config:</p>";
echo "<ul>";
echo "<li>DB_DATABASE: <code>$currentDb</code></li>";
echo "<li>DB_USERNAME: <code>$currentUser</code></li>";
echo "<li>DB_PASSWORD: <code>" . str_repeat('*', strlen($currentPass)) . "</code></li>";
echo "</ul>";

// ============================================
// STEP 2: Test Database Connection
// ============================================
echo "<h2>Step 2: Test Database Connection</h2>";

$dbHost = $env['DB_HOST'] ?? 'localhost';
$dbName = $env['DB_DATABASE'] ?? '';
$dbUser = $env['DB_USERNAME'] ?? '';
$dbPass = $env['DB_PASSWORD'] ?? '';

$connectionError = null;
$databaseExists = false;

try {
    $dsn = "mysql:host=$dbHost;port=3306;charset=utf8mb4";
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5
    ]);
    
    echo "<p style='color:green'>✅ MySQL server connection: OK</p>";
    
    // Check database
    $stmt = $pdo->query("SHOW DATABASES LIKE '$dbName'");
    $databaseExists = $stmt->fetch();
    
    if ($databaseExists) {
        echo "<p style='color:green'>✅ Database '$dbName' exists</p>";
        
        // Try to use database
        $pdo->exec("USE `$dbName`");
        echo "<p style='color:green'>✅ Can access database</p>";
        
        // Check tables
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        if (count($tables) > 0) {
            echo "<p style='color:green'>✅ Tables found: " . count($tables) . "</p>";
        } else {
            echo "<p style='color:orange'>⚠️ No tables found - need to import SQL</p>";
            echo "<p><a href='?action=import_sql'>Click here to import database SQL</a></p>";
        }
    } else {
        echo "<p style='color:red'>❌ Database '$dbName' NOT found!</p>";
        echo "<p>Create it in cPanel → MySQL Database Wizard</p>";
    }
} catch (PDOException $e) {
    $connectionError = $e->getMessage();
    echo "<p style='color:red'>❌ Connection failed: " . htmlspecialchars($e->getMessage()) . "</p>";
    
    // Show cPanel instructions
    echo "<div style='background:#ffebee;padding:15px;border-radius:5px;margin:10px 0;'>";
    echo "<h3>🔧 Fix Instructions:</h3>";
    echo "<ol>";
    echo "<li>Go to cPanel → MySQL Database Wizard</li>";
    echo "<li><strong>Create Database:</strong> <code>$dbName</code></li>";
    echo "<li><strong>Create User:</strong> <code>$dbUser</code></li>";
    echo "<li><strong>Password:</strong> <code>" . htmlspecialchars($dbPass) . "</code></li>";
    echo "<li><strong>Add user to database</strong> with ALL PRIVILEGES</li>";
    echo "<li>Click <strong>'Make Changes'</strong></li>";
    echo "</ol>";
    echo "<p>Then refresh this page.</p>";
    echo "</div>";
}

// ============================================
// STEP 3: Generate APP_KEY
// ============================================
echo "<h2>Step 3: APP_KEY Check</h2>";

if (empty($env['APP_KEY'])) {
    echo "<p style='color:orange'>⚠️ APP_KEY is empty!</p>";
    
    // Generate new key
    $key = 'base64:' . base64_encode(random_bytes(32));
    
    // Update .env
    $envContent = file_get_contents($envFile);
    $envContent = preg_replace('/^APP_KEY=.*$/m', "APP_KEY=$key", $envContent);
    file_put_contents($envFile, $envContent);
    
    echo "<p style='color:green'>✅ Generated new APP_KEY</p>";
} else {
    echo "<p style='color:green'>✅ APP_KEY is set</p>";
}

// ============================================
// STEP 4: Clear Laravel Cache
// ============================================
echo "<h2>Step 4: Clear Cache</h2>";

$cacheDirs = [
    __DIR__ . '/storage/framework/cache',
    __DIR__ . '/storage/framework/views',
    __DIR__ . '/storage/framework/sessions',
    __DIR__ . '/bootstrap/cache'
];

foreach ($cacheDirs as $dir) {
    if (is_dir($dir)) {
        $files = glob($dir . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}

echo "<p style='color:green'>✅ Cache cleared</p>";

// ============================================
// STEP 5: Check File Permissions
// ============================================
echo "<h2>Step 5: File Permissions</h2>";

$writableDirs = [
    'storage' => __DIR__ . '/storage',
    'bootstrap/cache' => __DIR__ . '/bootstrap/cache'
];

foreach ($writableDirs as $name => $dir) {
    if (is_dir($dir)) {
        if (is_writable($dir)) {
            echo "<p style='color:green'>✅ $name is writable</p>";
        } else {
            echo "<p style='color:orange'>⚠️ $name is not writable</p>";
            @chmod($dir, 0755);
        }
    } else {
        echo "<p style='color:red'>❌ $name directory not found!</p>";
    }
}

// ============================================
// SUMMARY
// ============================================
echo "<h2>Summary</h2>";

if ($connectionError) {
    echo "<div style='background:#ffebee;padding:15px;border-radius:5px;'>";
    echo "<h3 style='color:red'>⚠️ Database connection failed</h3>";
    echo "<p>Please fix the database credentials in cPanel first.</p>";
    echo "</div>";
} elseif (!$databaseExists) {
    echo "<div style='background:#fff3e0;padding:15px;border-radius:5px;'>";
    echo "<h3 style='color:orange'>⚠️ Database not found</h3>";
    echo "<p>Create database '$dbName' in cPanel.</p>";
    echo "</div>";
} else {
    echo "<div style='background:#e8f5e9;padding:15px;border-radius:5px;'>";
    echo "<h3 style='color:green'>🎉 Setup Complete!</h3>";
    echo "<p>Your application should be working now.</p>";
    echo "<p><a href='/' style='font-size:18px;'>Go to Website</a></p>";
    echo "</div>";
}

echo "<hr><p><strong>⚠️ DELETE this file (setup.php) after setup!</strong></p>";

// Handle SQL Import
if (isset($_GET['action']) && $_GET['action'] === 'import_sql') {
    echo "<h2>Importing Database...</h2>";
    
    $sqlFile = __DIR__ . '/database/kos_harmoni_database.sql';
    
    if (!file_exists($sqlFile)) {
        echo "<p style='color:red'>❌ SQL file not found: database/kos_harmoni_database.sql</p>";
    } else {
        try {
            $pdo->exec("USE `$dbName`");
            
            $sql = file_get_contents($sqlFile);
            
            // Remove CREATE DATABASE and USE statements (already selected)
            $sql = preg_replace('/CREATE DATABASE.*?;/s', '', $sql);
            $sql = preg_replace('/USE `.*?`;/', '', $sql);
            
            $pdo->exec($sql);
            echo "<p style='color:green'>✅ Database imported successfully!</p>";
        } catch (PDOException $e) {
            echo "<p style='color:red'>❌ Import failed: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
}
