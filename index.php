<?php
require_once BASE_PATH . "/bootstrap.php";
require_once UTILS_PATH . "/auth.util.php";

// Redirect logic
if (Auth::check()) {
    header("Location: /pages/dashboard/index.php");
    exit;
} else {
    header("Location: /pages/login/index.php");
    exit;
}
?>
