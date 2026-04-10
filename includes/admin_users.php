<?php

if (!function_exists('jalanyata_hidden_user_roles')) {
    function jalanyata_hidden_user_roles()
    {
        return ['developer'];
    }
}

if (!function_exists('jalanyata_allowed_manageable_user_roles')) {
    function jalanyata_allowed_manageable_user_roles()
    {
        return ['reader', 'admin'];
    }
}

if (!function_exists('jalanyata_validate_manageable_user_role')) {
    function jalanyata_validate_manageable_user_role($role)
    {
        $role = trim((string) $role);

        if (!in_array($role, jalanyata_allowed_manageable_user_roles(), true)) {
            throw new InvalidArgumentException('Role user tidak valid.');
        }

        return $role;
    }
}

if (!function_exists('jalanyata_hidden_user_where_sql')) {
    function jalanyata_hidden_user_where_sql()
    {
        $roles = jalanyata_hidden_user_roles();
        $quoted = array_map(function ($role) {
            return "'" . str_replace("'", "''", $role) . "'";
        }, $roles);

        return 'role NOT IN (' . implode(', ', $quoted) . ')';
    }
}

if (!function_exists('jalanyata_user_list_state')) {
    function jalanyata_user_list_state($defaultLimit)
    {
        $limit = max(1, (int) $defaultLimit);
        $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;

        return [
            'searchQuery' => isset($_GET['search']) ? trim((string) $_GET['search']) : '',
            'page' => $page,
            'limit' => $limit,
            'offset' => ($page - 1) * $limit,
        ];
    }
}

if (!function_exists('jalanyata_fetch_user_page')) {
    function jalanyata_fetch_user_page(PDO $conn, $filters)
    {
        $searchQuery = $filters['searchQuery'] ?? '';
        $whereParts = [jalanyata_hidden_user_where_sql()];
        if ($searchQuery !== '') {
            $whereParts[] = 'username LIKE :searchQuery';
        }
        $whereSql = ' WHERE ' . implode(' AND ', $whereParts);

        $totalStmt = $conn->prepare('SELECT COUNT(*) FROM users' . $whereSql);
        if ($searchQuery !== '') {
            $totalStmt->bindValue(':searchQuery', '%' . $searchQuery . '%', PDO::PARAM_STR);
        }
        $totalStmt->execute();

        $totalUsers = (int) $totalStmt->fetchColumn();
        $limit = (int) ($filters['limit'] ?? 10);
        $totalPages = (int) ceil($totalUsers / $limit);

        $stmt = $conn->prepare('SELECT id, username, role FROM users' . $whereSql . ' LIMIT :limit OFFSET :offset');
        if ($searchQuery !== '') {
            $stmt->bindValue(':searchQuery', '%' . $searchQuery . '%', PDO::PARAM_STR);
        }
        $stmt->bindValue(':limit', (int) $filters['limit'], PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $filters['offset'], PDO::PARAM_INT);
        $stmt->execute();

        return [
            'users' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'totalUsers' => $totalUsers,
            'totalPages' => $totalPages,
        ];
    }
}

if (!function_exists('jalanyata_user_filter_url')) {
    function jalanyata_user_filter_url($path, $filters, $overrides = [])
    {
        $query = [];

        if (($filters['searchQuery'] ?? '') !== '') {
            $query['search'] = $filters['searchQuery'];
        }

        foreach ($overrides as $key => $value) {
            if ($value === null || $value === '') {
                unset($query[$key]);
                continue;
            }

            $query[$key] = $value;
        }

        $queryString = http_build_query($query);
        $separator = $queryString === '' ? '?' : '?' . $queryString;

        return app_path_url($path) . $separator;
    }
}

if (!function_exists('jalanyata_user_page_url')) {
    function jalanyata_user_page_url($path, $filters, $page)
    {
        return jalanyata_user_filter_url($path, $filters, ['page' => max(1, (int) $page)]);
    }
}

if (!function_exists('jalanyata_render_user_pagination')) {
    function jalanyata_render_user_pagination($path, $filters, $page, $totalPages)
    {
        echo '<div class="ane-pagination">';

        if ($page > 1) {
            echo '<a href="' . htmlspecialchars(jalanyata_user_page_url($path, $filters, $page - 1), ENT_QUOTES, 'UTF-8') . '" class="ane-pagination__item">Sebelumnya</a>';
        }

        echo '<span class="ane-note">Halaman ' . (int) $page . ' dari ' . (int) $totalPages . '</span>';

        if ($page < $totalPages) {
            echo '<a href="' . htmlspecialchars(jalanyata_user_page_url($path, $filters, $page + 1), ENT_QUOTES, 'UTF-8') . '" class="ane-pagination__item">Berikutnya</a>';
        }

        echo '</div>';
    }
}

if (!function_exists('jalanyata_find_user_by_username')) {
    function jalanyata_find_user_by_username(PDO $conn, $username)
    {
        $stmt = $conn->prepare('SELECT id, username, password, role FROM users WHERE username = :username');
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

if (!function_exists('jalanyata_find_manageable_user_by_id')) {
    function jalanyata_find_manageable_user_by_id(PDO $conn, $id)
    {
        $stmt = $conn->prepare(
            'SELECT id, username, role FROM users WHERE id = :id AND ' . jalanyata_hidden_user_where_sql() . ' LIMIT 1'
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}

if (!function_exists('jalanyata_hash_password')) {
    function jalanyata_hash_password($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}

if (!function_exists('jalanyata_is_legacy_sha256_hash')) {
    function jalanyata_is_legacy_sha256_hash($hash)
    {
        return is_string($hash) && preg_match('/^[a-f0-9]{64}$/i', $hash) === 1;
    }
}

if (!function_exists('jalanyata_verify_user_password')) {
    function jalanyata_verify_user_password($password, $storedHash)
    {
        if (!is_string($storedHash) || $storedHash === '') {
            return false;
        }

        if (jalanyata_is_legacy_sha256_hash($storedHash)) {
            return hash_equals(strtolower($storedHash), hash('sha256', $password));
        }

        return password_verify($password, $storedHash);
    }
}

if (!function_exists('jalanyata_password_needs_upgrade')) {
    function jalanyata_password_needs_upgrade($storedHash)
    {
        if (jalanyata_is_legacy_sha256_hash($storedHash)) {
            return true;
        }

        return password_needs_rehash($storedHash, PASSWORD_DEFAULT);
    }
}

if (!function_exists('jalanyata_update_user_password_hash')) {
    function jalanyata_update_user_password_hash(PDO $conn, $id, $passwordHash)
    {
        $stmt = $conn->prepare('UPDATE users SET password = :password WHERE id = :id');
        $stmt->bindValue(':password', $passwordHash, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

if (!function_exists('jalanyata_create_user')) {
    function jalanyata_create_user(PDO $conn, $username, $passwordHash, $role)
    {
        $stmt = $conn->prepare('INSERT INTO users (username, password, role) VALUES (:username, :password, :role)');
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':password', $passwordHash, PDO::PARAM_STR);
        $stmt->bindValue(':role', $role, PDO::PARAM_STR);
        $stmt->execute();
    }
}

if (!function_exists('jalanyata_update_user')) {
    function jalanyata_update_user(PDO $conn, $id, $username, $role, $passwordHash = null)
    {
        if ($passwordHash !== null && $passwordHash !== '') {
            $stmt = $conn->prepare('UPDATE users SET username = :username, role = :role, password = :password WHERE id = :id');
            $stmt->bindValue(':password', $passwordHash, PDO::PARAM_STR);
        } else {
            $stmt = $conn->prepare('UPDATE users SET username = :username, role = :role WHERE id = :id');
        }

        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':role', $role, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

if (!function_exists('jalanyata_delete_user')) {
    function jalanyata_delete_user(PDO $conn, $id)
    {
        $stmt = $conn->prepare('DELETE FROM users WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

if (!function_exists('jalanyata_handle_login_request')) {
    function jalanyata_handle_login_request(PDO $conn, $username, $password)
    {
        if ($username === null || $password === null || $username === '' || $password === '') {
            jalanyata_flash_set('login_error', 'Username dan password harus diisi.');
            jalanyata_redirect('/login');
        }

        try {
            $user = jalanyata_find_user_by_username($conn, $username);

            if (!$user || !jalanyata_verify_user_password($password, $user['password'])) {
                jalanyata_flash_set('login_error', 'Username atau password salah.');
                jalanyata_redirect('/login');
            }

            if (jalanyata_password_needs_upgrade($user['password'])) {
                jalanyata_update_user_password_hash($conn, $user['id'], jalanyata_hash_password($password));
            }

            jalanyata_login_user($user['id'], $user['username'], $user['role']);

            if ($user['role'] === 'admin' || $user['role'] === 'developer') {
                jalanyata_redirect('/dashboard');
            }

            jalanyata_redirect('/reader/dashboard.php');
        } catch (PDOException $e) {
            jalanyata_flash_set('login_error', 'Error koneksi database: ' . $e->getMessage());
            jalanyata_redirect('/login');
        }
    }
}

if (!function_exists('jalanyata_handle_user_add_request')) {
    function jalanyata_handle_user_add_request(PDO $conn, $username, $password, $role)
    {
        try {
            $username = trim((string) $username);
            if ($username === '' || trim((string) $password) === '') {
                throw new InvalidArgumentException('Username dan password wajib diisi.');
            }

            jalanyata_create_user($conn, $username, jalanyata_hash_password($password), jalanyata_validate_manageable_user_role($role));
            jalanyata_flash_set('user_success', 'User berhasil ditambahkan.');
        } catch (InvalidArgumentException $e) {
            jalanyata_flash_set('user_error', $e->getMessage());
        } catch (PDOException $e) {
            jalanyata_flash_set('user_error', 'Gagal menambah user: ' . $e->getMessage());
        }

        jalanyata_redirect('/admin/users.php');
    }
}

if (!function_exists('jalanyata_handle_user_edit_request')) {
    function jalanyata_handle_user_edit_request(PDO $conn, $id, $username, $password, $role)
    {
        try {
            $username = trim((string) $username);
            $manageableUser = jalanyata_find_manageable_user_by_id($conn, $id);
            if ($manageableUser === null) {
                throw new InvalidArgumentException('User tidak ditemukan atau tidak dapat diubah.');
            }

            $validatedRole = jalanyata_validate_manageable_user_role($role);

            if ($password !== null && $password !== '') {
                jalanyata_update_user($conn, $id, $username, $validatedRole, jalanyata_hash_password($password));
            } else {
                jalanyata_update_user($conn, $id, $username, $validatedRole);
            }

            jalanyata_flash_set('user_success', 'User berhasil diubah.');
        } catch (InvalidArgumentException $e) {
            jalanyata_flash_set('user_error', $e->getMessage());
        } catch (PDOException $e) {
            jalanyata_flash_set('user_error', 'Gagal mengedit user: ' . $e->getMessage());
        }

        jalanyata_redirect('/admin/users.php');
    }
}

if (!function_exists('jalanyata_handle_user_delete_request')) {
    function jalanyata_handle_user_delete_request(PDO $conn, $id)
    {
        try {
            $manageableUser = jalanyata_find_manageable_user_by_id($conn, $id);
            if ($manageableUser === null) {
                throw new InvalidArgumentException('User tidak ditemukan atau tidak dapat dihapus.');
            }

            jalanyata_delete_user($conn, $id);
            jalanyata_flash_set('user_success', 'User berhasil dihapus.');
        } catch (InvalidArgumentException $e) {
            jalanyata_flash_set('user_error', $e->getMessage());
        } catch (PDOException $e) {
            jalanyata_flash_set('user_error', 'Gagal menghapus user: ' . $e->getMessage());
        }

        jalanyata_redirect('/admin/users.php');
    }
}
