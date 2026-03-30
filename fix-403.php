<?php
/**
 * Hostinger 403 Forbidden Diagnostic & Fix
 * Upload file ini ke root public_html/ lalu akses via browser:
 * https://antirugi.app/fix-403.php
 */

echo "<h1>🔧 Hostinger 403 Fix Diagnostic</h1>";

// Check current directory
echo "<h2>1. Current Directory</h2>";
echo "Current path: " . __DIR__ . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";

// Check if public folder exists
echo "<h2>2. Check Folders</h2>";
$folders = ['public', 'storage', 'bootstrap/cache', 'app', 'config', 'routes'];
foreach ($folders as $folder) {
    $path = __DIR__ . '/' . $folder;
    if (file_exists($path)) {
        $perms = substr(sprintf('%o', fileperms($path)), -4);
        echo "✅ $folder exists (permissions: $perms)<br>";
    } else {
        echo "❌ $folder NOT FOUND!<br>";
    }
}

// Check index.php location
echo "<h2>3. Check index.php</h2>";
if (file_exists(__DIR__ . '/index.php')) {
    echo "✅ index.php found in root<br>";
} elseif (file_exists(__DIR__ . '/public/index.php')) {
    echo "⚠️ index.php found in public/ - Need to redirect<br>";
} else {
    echo "❌ index.php NOT FOUND!<br>";
}

// Check .htaccess
echo "<h2>4. Check .htaccess</h2>";
if (file_exists(__DIR__ . '/.htaccess')) {
    $content = file_get_contents(__DIR__ . '/.htaccess');
    echo "✅ .htaccess exists (" . strlen($content) . " bytes)<br>";
    echo "<pre>" . htmlspecialchars($content) . "</pre>";
} else {
    echo "❌ .htaccess NOT FOUND!<br>";
}

// Check .env
echo "<h2>5. Check .env</h2>";
if (file_exists(__DIR__ . '/.env')) {
    $perms = substr(sprintf('%o', fileperms(__DIR__ . '/.env')), -4);
    echo "✅ .env exists (permissions: $perms)<br>";
} else {
    echo "❌ .env NOT FOUND!<br>";
}

// Create fixes
echo "<h2>6. Auto-Fix Issues</h2>";

// Fix 1: Create .htaccess if missing
if (!file_exists(__DIR__ . '/.htaccess')) {
    $htaccess = '<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>';
    file_put_contents(__DIR__ . '/.htaccess', $htaccess);
    echo "✅ Created .htaccess in root<br>";
}

// Fix 2: Create public/.htaccess if missing
if (!file_exists(__DIR__ . '/public/.htaccess')) {
    $htaccess_public = '<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

php_value upload_max_filesize 64M
php_value post_max_size 64M
php_value memory_limit 256M';
    
    if (file_exists(__DIR__ . '/public')) {
        file_put_contents(__DIR__ . '/public/.htaccess', $htaccess_public);
        echo "✅ Created .htaccess in public/<br>";
    }
}

// Fix 3: Copy index.php to root if needed
if (!file_exists(__DIR__ . '/index.php') && file_exists(__DIR__ . '/public/index.php')) {
    // Create root index.php that redirects to public
    $root_index = '<?php
// Redirect to public folder
header("Location: /public/");
exit;';
    file_put_contents(__DIR__ . '/index.php', $root_index);
    echo "✅ Created index.php redirect in root<br>";
}

echo "<h2>7. Next Steps</h2>";
echo "<p>After running this fix:</p>";
echo "<ol>";
echo "<li>Delete this file (fix-403.php) for security</li>";
echo "<li>Refresh your website: <a href='/'>Click here</a></li>";
echo "<li>If still 403, check File Manager permissions manually</li>";
echo "<li>Contact Hostinger support with error details</li>";
echo "</ol>";

echo "<hr><p><strong>Generated:</strong> " . date('Y-m-d H:i:s') . "</p>";
