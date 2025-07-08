<?php

require_once BASE_PATH . '/bootstrap.php';              // path to project root
require_once UTILS_PATH . '/auth.util.php';        // defines the Auth class

// ✅ make sure Auth::login() comes after the include
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (Auth::login($username, $password)) {
        header('Location: ../pages/dashboard/index.php');
        exit;
    } else {
        header('Location: ../pages/login/index.php?error=Invalid%20credentials');
        exit;
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    Auth::logout();
    header('Location: ../pages/login/index.php?message=Logged%20out');
    exit;
}
