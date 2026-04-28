<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');        // Ganti dengan username MySQL kamu
define('DB_PASS', '');            // Ganti dengan password MySQL kamu
define('DB_NAME', 'spk_studentexchange');
define('DB_CHARSET', 'utf8mb4');

define('APP_NAME', 'SPK Student Exchange');
define('APP_SCHOOL', 'SMAN 3 Malang');

function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            die(json_encode([
                'error' => true,
                'message' => 'Koneksi database gagal: ' . $e->getMessage()
            ]));
        }
    }
    return $pdo;
}
