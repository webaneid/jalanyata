<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/system_seed.php';

$servername = env_value('DB_HOST', 'localhost');
$username = env_value('DB_USER', 'root');
$password = env_value('DB_PASS', 'root');
$dbname = env_value('DB_NAME', 'jalanyata');
$charset = env_value('DB_CHARSET', 'utf8mb4');

try {
    $conn = new PDO(
        "mysql:host=$servername;dbname=$dbname;charset=$charset",
        $username,
        $password
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    jalanyata_ensure_developer_account($conn);
} catch(PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
