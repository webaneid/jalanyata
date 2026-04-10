<?php

if (!function_exists('jalanyata_flash_session_start')) {
    function jalanyata_flash_session_start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}

if (!function_exists('jalanyata_flash_set')) {
    function jalanyata_flash_set($key, $message)
    {
        jalanyata_flash_session_start();
        $_SESSION[$key] = $message;
    }
}

if (!function_exists('jalanyata_flash_has')) {
    function jalanyata_flash_has($key)
    {
        jalanyata_flash_session_start();
        return isset($_SESSION[$key]) && $_SESSION[$key] !== '';
    }
}

if (!function_exists('jalanyata_flash_pull')) {
    function jalanyata_flash_pull($key, $default = null)
    {
        jalanyata_flash_session_start();

        if (!array_key_exists($key, $_SESSION)) {
            return $default;
        }

        $value = $_SESSION[$key];
        unset($_SESSION[$key]);

        return $value;
    }
}

if (!function_exists('jalanyata_flash_render')) {
    function jalanyata_flash_render($key, $variant = 'danger')
    {
        $message = jalanyata_flash_pull($key);

        if ($message === null || $message === '') {
            return;
        }

        $allowedVariants = ['success', 'danger', 'info'];
        if (!in_array($variant, $allowedVariants, true)) {
            $variant = 'danger';
        }

        echo '<div class="ane-alert ane-alert--' . htmlspecialchars($variant, ENT_QUOTES, 'UTF-8') . '" role="alert">';
        echo htmlspecialchars((string) $message, ENT_QUOTES, 'UTF-8');
        echo '</div>';
    }
}
