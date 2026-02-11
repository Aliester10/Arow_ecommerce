<?php

$envFile = __DIR__ . '/.env';
$key = 'base64:' . base64_encode(random_bytes(32));

if (!file_exists($envFile)) {
    die(".env file not found.\n");
}

$contents = file_get_contents($envFile);

if (strpos($contents, 'APP_KEY=') === false) {
    $contents .= "\nAPP_KEY=$key";
} else {
    $contents = preg_replace('/^APP_KEY=.*$/m', "APP_KEY=$key", $contents);
}

file_put_contents($envFile, $contents);

echo "Application key set successfully: $key\n";
