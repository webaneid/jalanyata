<?php
// File: logout.php
// Fungsi: Mengakhiri sesi user dan mengarahkannya ke halaman login.

require_once __DIR__ . '/includes/auth.php';

jalanyata_logout_user();
jalanyata_redirect('/login');
