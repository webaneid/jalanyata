<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/flash.php';

if (!function_exists('jalanyata_session_start')) {
    function jalanyata_session_start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}

if (!function_exists('jalanyata_redirect')) {
    function jalanyata_redirect($path)
    {
        header('Location: ' . app_path_url($path));
        exit;
    }
}

if (!function_exists('jalanyata_role_matches')) {
    function jalanyata_role_matches($currentRole, $requiredRole)
    {
        if ($requiredRole === null) {
            return true;
        }

        if ($currentRole === $requiredRole) {
            return true;
        }

        if ($currentRole === 'developer' && $requiredRole === 'admin') {
            return true;
        }

        return false;
    }
}

if (!function_exists('jalanyata_login_user')) {
    function jalanyata_login_user($userId, $username, $role)
    {
        jalanyata_session_start();
        session_regenerate_id(true);

        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        $_SESSION['user_role'] = $role;
    }
}

if (!function_exists('jalanyata_require_role')) {
    function jalanyata_require_role($role = null)
    {
        jalanyata_session_start();

        if (!isset($_SESSION['user_id'])) {
            jalanyata_flash_set('login_error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
            jalanyata_redirect('/login');
        }

        if (!jalanyata_role_matches($_SESSION['user_role'] ?? null, $role)) {
            jalanyata_flash_set('login_error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
            jalanyata_redirect('/login');
        }
    }
}

if (!function_exists('jalanyata_logout_user')) {
    function jalanyata_logout_user()
    {
        jalanyata_session_start();

        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();
    }
}
