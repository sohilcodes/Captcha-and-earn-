<?php
// scripts/init_db.php
// Run once at service start. Safe to run multiple times.

$root = __DIR__ . "/..";
$dbDir = $root . "/db";

if (!is_dir($dbDir)) {
    mkdir($dbDir, 0755, true);
}

$files = [
    'users.json' => json_encode([
        // optional sample user, remove if you don't want it
        "test@example.com" => [
            "password" => "test123",
            "wallet" => 200.0,
            "today_used" => 0,
            "last_reset" => date('Y-m-d'),
            "plan" => null
        ]
    ], JSON_PRETTY_PRINT),
    'earnings.json' => json_encode([], JSON_PRETTY_PRINT),
    'withdraw.json' => json_encode([], JSON_PRETTY_PRINT),
    'plans.json' => json_encode([], JSON_PRETTY_PRINT)
];

foreach ($files as $name => $content) {
    $path = $dbDir . "/" . $name;
    if (!file_exists($path)) {
        file_put_contents($path, $content);
        // make writable by PHP
        @chmod($path, 0666);
        echo "Created $path\n";
    } else {
        // ensure writable
        @chmod($path, 0666);
    }
}

// Also ensure db folder is writable
@chmod($dbDir, 0777);

echo "DB init complete\n";
return 0;
