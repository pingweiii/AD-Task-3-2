<?php
declare(strict_types=1);

require 'vendor/autoload.php';

require 'bootstrap.php';

require_once UTILS_PATH . '/envSetter.util.php';

$users = require_once DUMMIES_PATH . '/users.staticData.php';

$dsn = "pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['dbname']}";
$pdo = new PDO($dsn, $pgConfig['user'], $pgConfig['pass'], [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

$schemaFiles = [
  'users'          => 'database/user.model.sql',
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

echo "Truncating tables…\n";
foreach (array_keys($schemaFiles) as $table) {
  $pdo->exec("TRUNCATE TABLE {$table} RESTART IDENTITY CASCADE;");
}
echo "Reset complete!\n";
?>