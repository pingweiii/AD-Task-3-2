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

echo "Truncating tables…\n";
foreach (array_keys($schemaFiles) as $table) {
  $pdo->exec("TRUNCATE TABLE {$table} RESTART IDENTITY CASCADE;");
}
echo "Reset complete!\n";

echo "Seeding users…\n";

// query preparations. NOTE: make sure they matches order and number
$stmt = $pdo->prepare("
    INSERT INTO users (username, role, first_name, last_name, password)
    VALUES (:username, :role, :fn, :ln, :pw)
");

// plug-in datas from the staticData and add to the database
foreach ($users as $u) {
  $stmt->execute([
    ':username' => $u['username'],
    ':role' => $u['role'],
    ':fn' => $u['first_name'],
    ':ln' => $u['last_name'],
    ':pw' => password_hash($u['password'], PASSWORD_DEFAULT),
  ]);
}

$stmt = $pdo->query("SELECT * FROM users");

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    echo "---------------------------\n";
    echo "User ID: " . $user['id'] . "\n";
    echo "Username: " . $user['username'] . "\n";
    echo "First Name: " . $user['first_name'] . "\n";
    echo "Last Name: " . $user['last_name'] . "\n";
    echo "Role: " . $user['role'] . "\n";
    echo "---------------------------\n";
}

?>