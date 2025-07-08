<?php
require_once BASE_PATH . '/bootstrap.php';
require_once UTILS_PATH . '/auth.util.php';

if (!Auth::check()) {
    header('Location: ../login/index.php?error=Please%20log%20in%20first');
    exit;
}

$user = Auth::user();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background:rgb(28, 96, 163);
            margin: 0;
            padding: 2rem;
        }

        .dashboard {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .dashboard h1 {
            margin-top: 0;
            color: #007bff;
        }

        .info {
            margin: 1rem 0;
            font-size: 1.1rem;
        }

        .logout {
            text-align: right;
        }

        .logout a {
            color: white;
            background:rgb(5, 4, 4);
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        .logout a:hover {
            background: #c82333;
        }
    </style>
</head>
<body>

<div class="dashboard">
    <div class="logout">
        <a href="/handlers/auth.handler.php?action=logout">Logout</a>
    </div>

    <h1>Welcome, <?= htmlspecialchars($user['first_name']) ?>!</h1>

    <div class="info"><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></div>
    <div class="info"><strong>Full Name:</strong> <?= htmlspecialchars($user['first_name']) . ' ' . htmlspecialchars($user['last_name']) ?></div>
    <div class="info"><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></div>
</div>

</body>
</html>
