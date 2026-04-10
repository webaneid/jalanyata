<?php

if (!function_exists('jalanyata_load_env')) {
    function jalanyata_load_env($path)
    {
        if (!is_readable($path)) {
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '' || strpos($line, '#') === 0 || strpos($line, '=') === false) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            if ($name === '') {
                continue;
            }

            if (
                (substr($value, 0, 1) === '"' && substr($value, -1) === '"') ||
                (substr($value, 0, 1) === "'" && substr($value, -1) === "'")
            ) {
                $value = substr($value, 1, -1);
            }

            if (getenv($name) === false) {
                putenv($name . '=' . $value);
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}

if (!defined('JALANYATA_ENV_LOADED')) {
    jalanyata_load_env(dirname(__DIR__) . '/.env');
    define('JALANYATA_ENV_LOADED', true);
}

if (!function_exists('env_value')) {
    function env_value($key, $default = null)
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

        if ($value === false || $value === null || $value === '') {
            return $default;
        }

        return $value;
    }
}

if (!function_exists('app_base_path')) {
    function app_base_path()
    {
        $path = trim((string) env_value('APP_BASE_PATH', ''), '/');

        if ($path === '') {
            return '';
        }

        return '/' . $path;
    }
}

if (!function_exists('app_url')) {
    function app_url($path = '')
    {
        $baseUrl = rtrim((string) env_value('APP_URL', 'http://jalanyata.test'), '/');
        $path = trim((string) $path);

        if ($path === '' || $path === '/') {
            return $baseUrl;
        }

        return $baseUrl . '/' . ltrim($path, '/');
    }
}

if (!function_exists('app_path_url')) {
    function app_path_url($path = '')
    {
        $basePath = app_base_path();
        $path = trim((string) $path);

        if ($path === '' || $path === '/') {
            return $basePath === '' ? '/' : $basePath;
        }

        return ($basePath === '' ? '' : $basePath) . '/' . ltrim($path, '/');
    }
}

$baseUrl = app_base_path();
$baseDomain = app_url();
$baseOridomain = parse_url($baseDomain, PHP_URL_HOST) ?: 'jalanyata.test';
 
