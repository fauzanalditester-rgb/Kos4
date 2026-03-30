# Laravel Comprehensive Debugger for Railway Deployment
# Run: .\comprehensive-debug.ps1

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  COMPREHENSIVE LARAVEL DEBUGGER" -ForegroundColor Cyan
Write-Host "  Kos Harmoni Pro - Railway Ready" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

$CriticalIssues = @()
$Warnings = @()
$Success = @()

# 1. Check Migration Files
Write-Host "[1/10] Checking Database Migrations..." -ForegroundColor Yellow
$migrations = Get-ChildItem "database\migrations" -Filter "*.php" -ErrorAction SilentlyContinue
if ($migrations) {
    Write-Host "  ✓ Found $($migrations.Count) migration files" -ForegroundColor Green
    $Success += "Migrations: $($migrations.Count) files found"
    
    # Check for duplicates
    $tableNames = @{}
    foreach ($migration in $migrations) {
        $content = Get-Content $migration.FullName -Raw
        if ($content -match "create_([a-z_]+)_table") {
            $tableName = $matches[1]
            if ($tableNames.ContainsKey($tableName)) {
                Write-Host "  ✗ DUPLICATE: $tableName in $($migration.Name)" -ForegroundColor Red
                $CriticalIssues += "Duplicate migration for table: $tableName"
            } else {
                $tableNames[$tableName] = $migration.Name
            }
        }
    }
    if (-not ($CriticalIssues -match "Duplicate")) {
        Write-Host "  ✓ No duplicate migrations" -ForegroundColor Green
    }
} else {
    Write-Host "  ✗ No migrations found!" -ForegroundColor Red
    $CriticalIssues += "Missing migrations folder or files"
}
Write-Host ""

# 2. Check Model Files
Write-Host "[2/10] Checking Model Files..." -ForegroundColor Yellow
$models = Get-ChildItem "app\Models" -Filter "*.php" -ErrorAction SilentlyContinue
if ($models) {
    Write-Host "  ✓ Found $($models.Count) model files" -ForegroundColor Green
    $Success += "Models: $($models.Count) files found"
    
    $requiredModels = @("User", "Tenant", "Room", "Invoice", "Payment", "Property", "Expense", "Finance")
    foreach ($model in $requiredModels) {
        $modelFile = "app\Models\$model.php"
        if (Test-Path $modelFile) {
            Write-Host "    ✓ $model model" -ForegroundColor Green
        } else {
            Write-Host "    ⚠ $model model missing" -ForegroundColor Yellow
            $Warnings += "Missing model: $model"
        }
    }
} else {
    Write-Host "  ✗ No models found!" -ForegroundColor Red
    $CriticalIssues += "Missing Models folder"
}
Write-Host ""

# 3. Check Controllers
Write-Host "[3/10] Checking Controllers..." -ForegroundColor Yellow
$controllers = Get-ChildItem "app\Http\Controllers" -Filter "*.php" -Recurse -ErrorAction SilentlyContinue
if ($controllers) {
    Write-Host "  ✓ Found $($controllers.Count) controller files" -ForegroundColor Green
    $Success += "Controllers: $($controllers.Count) files found"
} else {
    Write-Host "  ⚠ No controllers found (might be using Livewire only)" -ForegroundColor Yellow
    $Warnings += "No controllers found"
}
Write-Host ""

# 4. Check Livewire Components
Write-Host "[4/10] Checking Livewire Components..." -ForegroundColor Yellow
$livewire = Get-ChildItem "app\Livewire" -Filter "*.php" -Recurse -ErrorAction SilentlyContinue
if ($livewire) {
    Write-Host "  ✓ Found $($livewire.Count) Livewire components" -ForegroundColor Green
    $Success += "Livewire: $($livewire.Count) components found"
} else {
    Write-Host "  ⚠ No Livewire components found" -ForegroundColor Yellow
}
Write-Host ""

# 5. Check Views
Write-Host "[5/10] Checking Views..." -ForegroundColor Yellow
$views = Get-ChildItem "resources\views" -Filter "*.blade.php" -Recurse -ErrorAction SilentlyContinue
if ($views) {
    Write-Host "  ✓ Found $($views.Count) Blade views" -ForegroundColor Green
    $Success += "Views: $($views.Count) files found"
} else {
    Write-Host "  ✗ No views found!" -ForegroundColor Red
    $CriticalIssues += "Missing views"
}
Write-Host ""

# 6. Check Routes
Write-Host "[6/10] Checking Routes..." -ForegroundColor Yellow
if (Test-Path "routes\web.php") {
    Write-Host "  ✓ routes/web.php exists" -ForegroundColor Green
    $content = Get-Content "routes\web.php" -Raw
    $routes = ([regex]::Matches($content, "Route::(get|post|put|delete|patch)\s*\(")).Count
    Write-Host "    Routes defined: ~$routes" -ForegroundColor Gray
    $Success += "Routes: web.php exists with ~$routes routes"
} else {
    Write-Host "  ✗ routes/web.php missing!" -ForegroundColor Red
    $CriticalIssues += "Missing routes/web.php"
}
if (Test-Path "routes\api.php") {
    Write-Host "  ✓ routes/api.php exists" -ForegroundColor Green
} else {
    Write-Host "  ⚠ routes/api.php missing (optional)" -ForegroundColor Yellow
}
Write-Host ""

# 7. Check Configuration Files
Write-Host "[7/10] Checking Deployment Configs..." -ForegroundColor Yellow
$configs = @(
    @{File="Dockerfile"; Required=$true},
    @{File="railway.json"; Required=$true},
    @{File=".env.example"; Required=$true},
    @{File="docker\nginx.conf"; Required=$true},
    @{File="docker\supervisord.conf"; Required=$true}
)
foreach ($config in $configs) {
    if (Test-Path $config.File) {
        Write-Host "  ✓ $($config.File) exists" -ForegroundColor Green
        $Success += "Config: $($config.File)"
    } else {
        if ($config.Required) {
            Write-Host "  ✗ $($config.File) missing!" -ForegroundColor Red
            $CriticalIssues += "Missing $($config.File)"
        } else {
            Write-Host "  ⚠ $($config.File) missing" -ForegroundColor Yellow
            $Warnings += "Missing $($config.File)"
        }
    }
}
Write-Host ""

# 8. Check Seeders
Write-Host "[8/10] Checking Database Seeders..." -ForegroundColor Yellow
$seeders = Get-ChildItem "database\seeders" -Filter "*.php" -ErrorAction SilentlyContinue
if ($seeders) {
    Write-Host "  ✓ Found $($seeders.Count) seeder files" -ForegroundColor Green
    $Success += "Seeders: $($seeders.Count) files found"
    
    if (Test-Path "database\seeders\DatabaseSeeder.php") {
        Write-Host "  ✓ DatabaseSeeder.php exists" -ForegroundColor Green
    } else {
        Write-Host "  ✗ DatabaseSeeder.php missing!" -ForegroundColor Red
        $CriticalIssues += "Missing DatabaseSeeder.php"
    }
} else {
    Write-Host "  ⚠ No seeders found" -ForegroundColor Yellow
    $Warnings += "Missing seeders"
}
Write-Host ""

# 9. Check Storage & Cache
Write-Host "[9/10] Checking Storage & Bootstrap..." -ForegroundColor Yellow
$storageFolders = @("storage\app", "storage\framework", "storage\logs", "bootstrap\cache")
foreach ($folder in $storageFolders) {
    if (Test-Path $folder) {
        Write-Host "  ✓ $folder exists" -ForegroundColor Green
    } else {
        Write-Host "  ⚠ $folder missing (will be created)" -ForegroundColor Yellow
    }
}
Write-Host ""

# 10. Check Public Folder
Write-Host "[10/10] Checking Public Assets..." -ForegroundColor Yellow
if (Test-Path "public\index.php") {
    Write-Host "  ✓ public/index.php exists" -ForegroundColor Green
    $Success += "Public: index.php exists"
} else {
    Write-Host "  ✗ public/index.php missing!" -ForegroundColor Red
    $CriticalIssues += "Missing public/index.php"
}

if (Test-Path "public\css" -PathType Container) {
    $cssFiles = (Get-ChildItem "public\css" -Filter "*.css").Count
    Write-Host "  ✓ public/css exists ($cssFiles CSS files)" -ForegroundColor Green
}

if (Test-Path "public\js" -PathType Container) {
    $jsFiles = (Get-ChildItem "public\js" -Filter "*.js").Count
    Write-Host "  ✓ public/js exists ($jsFiles JS files)" -ForegroundColor Green
}
Write-Host ""

# SUMMARY
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  DEBUG SUMMARY" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

if ($CriticalIssues.Count -eq 0) {
    Write-Host "🎉 EXCELLENT! No critical issues found!" -ForegroundColor Green
    Write-Host "   Application is ready for Railway deployment!" -ForegroundColor Green
} else {
    Write-Host "🔴 CRITICAL ISSUES: $($CriticalIssues.Count)" -ForegroundColor Red
    foreach ($issue in $CriticalIssues) {
        Write-Host "   • $issue" -ForegroundColor Red
    }
}

Write-Host ""

if ($Warnings.Count -gt 0) {
    Write-Host "⚠️  WARNINGS: $($Warnings.Count)" -ForegroundColor Yellow
    foreach ($warning in $Warnings) {
        Write-Host "   • $warning" -ForegroundColor Yellow
    }
    Write-Host ""
}

Write-Host "✅ SUCCESS ITEMS: $($Success.Count)" -ForegroundColor Green
foreach ($item in $Success) {
    Write-Host "   • $item" -ForegroundColor Gray
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan

# DEPLOYMENT READINESS
if ($CriticalIssues.Count -eq 0) {
    Write-Host "DEPLOYMENT STATUS: 🟢 READY" -ForegroundColor Green
    Write-Host ""
    Write-Host "Next Steps:" -ForegroundColor White
    Write-Host "  1. git add . && git commit -m 'Railway ready'" -ForegroundColor Cyan
    Write-Host "  2. git push origin main" -ForegroundColor Cyan
    Write-Host "  3. Deploy to Railway following DEPLOY_RAILWAY.md" -ForegroundColor Cyan
} else {
    Write-Host "DEPLOYMENT STATUS: 🔴 NOT READY" -ForegroundColor Red
    Write-Host ""
    Write-Host "Fix critical issues before deploying:" -ForegroundColor White
    foreach ($issue in $CriticalIssues) {
        Write-Host "  ✗ $issue" -ForegroundColor Red
    }
}

Write-Host ""
Write-Host "For detailed guide: See DEPLOY_RAILWAY.md" -ForegroundColor Gray
Write-Host "========================================" -ForegroundColor Cyan
