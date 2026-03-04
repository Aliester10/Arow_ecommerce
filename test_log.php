<?php

echo "<h1>Log Directory Test</h1>";

$logDir = __DIR__ . '/storage/logs';
$logFile = $logDir . '/laravel.log';

echo "<h2>Checking log directory...</h2>";

// Check if directory exists
if (!is_dir($logDir)) {
    echo "<p style='color: red;'>Log directory does not exist: $logDir</p>";
    
    // Try to create it
    if (mkdir($logDir, 0755, true)) {
        echo "<p style='color: green;'>Created log directory</p>";
    } else {
        echo "<p style='color: red;'>Cannot create log directory</p>";
    }
} else {
    echo "<p style='color: green;'>Log directory exists: $logDir</p>";
}

// Check permissions
if (is_dir($logDir)) {
    $perms = substr(sprintf('%o', fileperms($logDir)), -4);
    echo "<p>Directory permissions: $perms</p>";
    
    if (is_writable($logDir)) {
        echo "<p style='color: green;'>Directory is writable</p>";
    } else {
        echo "<p style='color: red;'>Directory is NOT writable</p>";
    }
}

// Test writing to log file
echo "<h2>Testing log file...</h2>";

try {
    // Use Laravel's Log facade
    require_once 'vendor/autoload.php';
    
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    
    Log::info('Test log entry from test_log.php');
    echo "<p style='color: green;'>Successfully wrote to Laravel log</p>";
    
    // Check if file exists now
    if (file_exists($logFile)) {
        echo "<p style='color: green;'>Log file exists: $logFile</p>";
        echo "<p>File size: " . number_format(filesize($logFile)) . " bytes</p>";
        
        // Show last few lines
        $lines = file($logFile);
        $lastLines = array_slice($lines, -5);
        echo "<h3>Last 5 lines:</h3>";
        echo "<pre style='background: #f5f5f5; padding: 10px;'>";
        foreach ($lastLines as $line) {
            echo htmlspecialchars($line);
        }
        echo "</pre>";
    } else {
        echo "<p style='color: red;'>Log file still does not exist</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error testing Laravel log: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// Show current working directory
echo "<h2>Server Info</h2>";
echo "<p>Current working directory: " . getcwd() . "</p>";
echo "<p>Document root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Not set') . "</p>";

?>
