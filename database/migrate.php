<?php

require_once __DIR__ . '/../includes/config.php';

function jalanyata_migration_pdo()
{
    $host = env_value('DB_HOST', '127.0.0.1');
    $user = env_value('DB_USER', 'root');
    $pass = env_value('DB_PASS', 'root');
    $name = env_value('DB_NAME', 'jalanyata');
    $charset = env_value('DB_CHARSET', 'utf8mb4');

    $pdo = new PDO(
        "mysql:host={$host};dbname={$name};charset={$charset}",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );

    return $pdo;
}

function jalanyata_ensure_migrations_table(PDO $pdo)
{
    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS schema_migrations (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            filename VARCHAR(255) NOT NULL,
            applied_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY filename (filename)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci'
    );
}

function jalanyata_applied_migrations(PDO $pdo)
{
    $stmt = $pdo->query('SELECT filename FROM schema_migrations ORDER BY filename ASC');

    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function jalanyata_parse_sql_statements($sql)
{
    $statements = [];
    $buffer = '';

    foreach (preg_split("/\\r\\n|\\n|\\r/", $sql) as $line) {
        $trimmedLine = trim($line);

        if ($trimmedLine === '' || strpos($trimmedLine, '-- ') === 0 || strpos($trimmedLine, '--') === 0) {
            continue;
        }

        $buffer .= $line . "\n";

        if (substr(rtrim($line), -1) === ';') {
            $statements[] = trim($buffer);
            $buffer = '';
        }
    }

    $remaining = trim($buffer);
    if ($remaining !== '') {
        $statements[] = $remaining;
    }

    return $statements;
}

function jalanyata_run_sql_file(PDO $pdo, $filePath, $filename)
{
    $sql = file_get_contents($filePath);
    if ($sql === false) {
        throw new RuntimeException("Gagal membaca file migration: {$filename}");
    }

    $statements = jalanyata_parse_sql_statements($sql);

    foreach ($statements as $statement) {
        if ($statement !== '') {
            $pdo->exec($statement);
        }
    }

    $recordStmt = $pdo->prepare('INSERT INTO schema_migrations (filename) VALUES (:filename)');
    $recordStmt->bindValue(':filename', $filename, PDO::PARAM_STR);
    $recordStmt->execute();
}

try {
    $pdo = jalanyata_migration_pdo();
    jalanyata_ensure_migrations_table($pdo);

    $applied = jalanyata_applied_migrations($pdo);
    $migrationFiles = glob(__DIR__ . '/migrations/*.sql') ?: [];
    sort($migrationFiles);

    if ($migrationFiles === []) {
        fwrite(STDOUT, "Tidak ada file migration.\n");
        exit(0);
    }

    $appliedCount = 0;

    foreach ($migrationFiles as $filePath) {
        $filename = basename($filePath);

        if (in_array($filename, $applied, true)) {
            fwrite(STDOUT, "skip {$filename}\n");
            continue;
        }

        jalanyata_run_sql_file($pdo, $filePath, $filename);
        fwrite(STDOUT, "applied {$filename}\n");
        $appliedCount++;
    }

    if ($appliedCount === 0) {
        fwrite(STDOUT, "Schema sudah up to date.\n");
    }
} catch (Throwable $e) {
    fwrite(STDERR, 'Migration gagal: ' . $e->getMessage() . "\n");
    exit(1);
}
