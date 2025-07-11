<?php
// scripts/set-version.php
// Usage: php scripts/set-version.php --v=1.2.3

if (php_sapi_name() !== 'cli') {
    exit("This script must be run from the command line.\n");
}

$options = getopt('', ['v:']);
if (!isset($options['v'])) {
    exit("Usage: php scripts/set-version.php --v=1.2.3\n");
}

$version = $options['v'];

function replaceInFile($filename, $patterns) {
    if (!file_exists($filename)) {
        exit("Error: File not found: $filename\n");
    }

    $contents = file_get_contents($filename);
    if ($contents === false) {
        exit("Error: Could not read $filename\n");
    }

    foreach ($patterns as $pattern => $callback) {
        $contents = preg_replace_callback($pattern, $callback, $contents);
    }

    if (file_put_contents($filename, $contents) === false) {
        exit("Error: Could not write to $filename\n");
    }
}

// Update src/translentor.php
replaceInFile(__DIR__ . '/../src/translentor.php', [
    '/(Version:\s+|@version\s+)(\d+\.\d+[\w\.-]*)/m' => function($matches) use ($version) {
        return $matches[1] . $version;
    },
    "/(define\(\s*'translentor_VERSION'\s*,\s*)'([\w\.-]+)'(\s*\))/m" => function($matches) use ($version) {
      return $matches[1] . "'$version'" . $matches[3];
    }
]);

// Update src/readme.txt
replaceInFile(__DIR__ . '/../src/readme.txt', [
    '/(Stable tag:\s+|@version\s+)(\d+\.\d+[\w\.-]*)/m' => function($matches) use ($version) {
        return $matches[1] . $version;
    }
]);

// Update composer.json
replaceInFile(__DIR__ . '/../composer.json', [
    '/("version"\s*:\s*")([\w\.-]+)(")/m' => function($matches) use ($version) {
        return $matches[1] . $version . $matches[3];
    }
]);

echo "Plugin version updated to $version.\n";
