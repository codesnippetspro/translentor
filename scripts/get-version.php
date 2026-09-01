<?php
// scripts/get-version.php
// Usage: php scripts/get-version.php

if (php_sapi_name() !== 'cli') {
    exit("This script must be run from the command line.\n");
}

$filename = __DIR__ . '/../src/translentor.php';
if (!file_exists($filename)) {
    exit("Error: File not found: $filename\n");
}

$contents = file_get_contents($filename);
if ($contents === false) {
    exit("Error: Could not read $filename\n");
}

$pattern = '/(Version:\s+|@version\s+)(\d+\.\d+[\w\.-]*)/m';
if (preg_match($pattern, $contents, $matches)) {
    echo $matches[2] . "\n";
} else {
    exit("Version not found in $filename\n");
}
