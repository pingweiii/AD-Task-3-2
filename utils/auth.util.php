<?php

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Required files
require_once BASE_PATH . '/bootstrap.php';
require_once BASE_PATH . '/vendor/autoload.php';
require_once UTILS_PATH . '/envSetter.util.php';

class Auth
{
    /**
     * Attempt to log in with provided credentials
     */
    public static function login(string $username, string $password): bool
    {
        global $pgConfig;

        try {
            // Connect to PostgreSQL
            $dsn = "pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['dbname']}";
            $pdo = new PDO($dsn, $pgConfig['user'], $pgConfig['pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);

            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if user exists and verify password
            if (!$user || !isset($user['password'])) {
                return false;
            }

            if ($user && isset($user['password']) && password_verify($password, $user['password'])) {
    $_SESSION['user'] = [
        'id' => $user['id'] ?? '',
        'username' => $user['username'] ?? '',
        'role' => $user['role'] ?? '',
        'first_name' => $user['first_name'] ?? '',
        'last_name' => $user['last_name'] ?? '',
    ];
    return true;
}

return false;

        } catch (PDOException $e) {
            error_log("Auth::login failed - " . $e->getMessage());
        }

        return false;
    }

    /**
     * Return the current logged-in user as array
     */
    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Return true if user is logged in
     */
    public static function check(): bool
    {
        return isset($_SESSION['user']);
    }

    /**
     * Log the user out by destroying the session
     */
    public static function logout(): void
    {
        session_unset();
        session_destroy();
    }
}
