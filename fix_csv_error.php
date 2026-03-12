<?php

// Script untuk fix CSV class error
echo "Checking and fixing PhpSpreadsheet CSV class issue...\n";

// Check if vendor/autoload.php exists
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "ERROR: vendor/autoload.php not found. Run 'composer install' first.\n";
    exit(1);
}

require_once __DIR__ . '/vendor/autoload.php';

// Check if PhpSpreadsheet CSV class exists
if (class_exists('PhpOffice\PhpSpreadsheet\Reader\Csv')) {
    echo "✅ PhpOffice\PhpSpreadsheet\Reader\Csv class found!\n";
} else {
    echo "❌ PhpOffice\PhpSpreadsheet\Reader\Csv class NOT found!\n";
    echo "Trying to fix...\n";
    
    // Try to include the class manually
    $csvPath = __DIR__ . '/vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Reader/Csv.php';
    if (file_exists($csvPath)) {
        echo "✅ CSV.php file exists at: $csvPath\n";
        require_once $csvPath;
        
        if (class_exists('PhpOffice\PhpSpreadsheet\Reader\Csv')) {
            echo "✅ CSV class loaded successfully!\n";
        } else {
            echo "❌ Still cannot load CSV class\n";
        }
    } else {
        echo "❌ CSV.php file NOT found at: $csvPath\n";
    }
}

// Check maatwebsite/excel configuration
echo "\nChecking maatwebsite/excel configuration...\n";

// Test basic Excel functionality
try {
    $excel = new \Maatwebsite\Excel\Facades\Excel();
    echo "✅ Excel facade loaded successfully!\n";
} catch (Exception $e) {
    echo "❌ Error loading Excel facade: " . $e->getMessage() . "\n";
}

// Check if we can create a simple CSV reader
try {
    if (class_exists('PhpOffice\PhpSpreadsheet\Reader\Csv')) {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        echo "✅ CSV Reader created successfully!\n";
    }
} catch (Exception $e) {
    echo "❌ Error creating CSV Reader: " . $e->getMessage() . "\n";
}

echo "\n=== Suggested Commands for Hosting ===\n";
echo "1. composer install --no-dev\n";
echo "2. composer dump-autoload\n";
echo "3. php artisan config:clear\n";
echo "4. php artisan cache:clear\n";
echo "5. chmod -R 755 vendor/\n";
echo "6. chmod -R 755 storage/\n";
echo "7. chmod -R 755 bootstrap/cache/\n";

echo "\n=== Alternative Fix ===\n";
echo "If the issue persists, try this in your hosting:\n";
echo "1. Delete vendor folder\n";
echo "2. Run: composer install --no-dev --optimize-autoloader\n";
echo "3. Run: composer require phpoffice/phpspreadsheet\n";
echo "4. Run: composer require maatwebsite/excel\n";

?>
