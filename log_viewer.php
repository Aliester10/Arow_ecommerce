<?php

// Simple log viewer for debugging
$logFile = __DIR__ . '/storage/logs/laravel.log';

echo "<h1>Laravel Log Viewer</h1>";

if (file_exists($logFile)) {
    echo "<h2>Log file: " . htmlspecialchars($logFile) . "</h2>";
    echo "<h3>File size: " . number_format(filesize($logFile)) . " bytes</h3>";
    
    // Read last 100 lines
    $lines = file($logFile);
    $totalLines = count($lines);
    $lastLines = array_slice($lines, -100);
    
    echo "<h3>Last 100 lines (from $totalLines total lines):</h3>";
    echo "<pre style='background: #f5f5f5; padding: 10px; border: 1px solid #ccc; overflow: auto; max-height: 500px;'>";
    
    // Filter for our specific logs
    $relevantLines = [];
    foreach ($lastLines as $line) {
        if (strpos($line, 'Spesifikasi_produk') !== false || 
            strpos($line, 'Direct SQL') !== false ||
            strpos($line, 'Check constraint') !== false) {
            $relevantLines[] = $line;
        }
    }
    
    if (!empty($relevantLines)) {
        echo "<strong style='color: red;'>=== RELEVANT LOGS ===</strong>\n";
        foreach ($relevantLines as $line) {
            echo htmlspecialchars($line);
        }
        echo "\n<strong style='color: red;'>=== END RELEVANT LOGS ===</strong>\n\n";
    }
    
    echo "<strong style='color: blue;'>=== LAST 50 LINES ===</strong>\n";
    foreach (array_slice($lastLines, -50) as $line) {
        echo htmlspecialchars($line);
    }
    
    echo "</pre>";
    
    // Clear log button
    if (isset($_GET['clear'])) {
        file_put_contents($logFile, '');
        echo "<script>window.location.href = '?';</script>";
    }
    
    echo "<br><br>";
    echo "<a href='?clear=1' style='background: red; color: white; padding: 10px; text-decoration: none;'>Clear Log</a>";
    
} else {
    echo "<h2>Log file not found: " . htmlspecialchars($logFile) . "</h2>";
    echo "<p>Check if the file exists and permissions are correct.</p>";
}

?>
