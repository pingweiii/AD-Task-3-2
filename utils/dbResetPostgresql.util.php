<?php
declare(strict_types=1);

// 1) Composer autoload
require 'vendor/autoload.php';

// 2) Composer bootstrap
require 'bootstrap.php';

// 3) envSetter
require_once UTILS_PATH . '/envSetter.util.php';

// ——— Connect to PostgreSQL ———
$dsn = "pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['dbname']}";
$pdo = new PDO($dsn, $pgConfig['user'], $pgConfig['pass'], [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

// ——— Apply Schema Files ———
$schemaFiles = [
  'users'          => 'database/users.model.sql',
  'meeting'       => 'database/meeting.model.sql',
  'meeting_users'  => 'database/meeting_users.model.sql',
];

foreach ($schemaFiles as $tableName => $filePath) {
  echo "Applying schema from {$filePath}…\n";
  $sql = file_get_contents($filePath);
  if ($sql === false) {
    throw new RuntimeException("Could not read {$filePath}");
  } else {
    echo "Creation Success from {$filePath}\n";
    $pdo->exec($sql);
  }
}

// ——— Truncate Tables ———
echo "Truncating tables…\n";
foreach (array_keys($schemaFiles) as $table) {
  $pdo->exec("TRUNCATE TABLE {$table} RESTART IDENTITY CASCADE;");
}
echo "Reset complete!\n";
?>