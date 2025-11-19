<?php
/**
 * Database connection bootstrap.
 *
 * Prioritises DATABASE_URL (e.g. Supabase/Neon) and falls back to individual
 * DB_* environment variables or the legacy local MySQL defaults.
 *
 * Exposes a shared PDO instance via $conn.
 */

$databaseUrl = getenv('DATABASE_URL');
$driver = 'mysql';
$host = 'localhost';
$port = 3306;
$dbname = 'task_manager';
$username = 'root';
$password = '';
$sslMode = null;

if ($databaseUrl) {
    $parsedUrl = parse_url($databaseUrl);

    if ($parsedUrl === false || empty($parsedUrl['scheme'])) {
        die('Invalid DATABASE_URL format.');
    }

    $scheme = strtolower($parsedUrl['scheme']);
    $driver = $scheme === 'postgres' || $scheme === 'postgresql' ? 'pgsql' : $scheme;
    $host = $parsedUrl['host'] ?? $host;
    $port = $parsedUrl['port'] ?? ($driver === 'pgsql' ? 5432 : $port);
    $dbname = isset($parsedUrl['path']) ? ltrim($parsedUrl['path'], '/') : $dbname;
    $username = $parsedUrl['user'] ?? $username;
    $password = $parsedUrl['pass'] ?? $password;

    if (!empty($parsedUrl['query'])) {
        parse_str($parsedUrl['query'], $queryParams);
        $sslMode = $queryParams['sslmode'] ?? null;
    }
} else {
    $driver = getenv('DB_DRIVER') ?: $driver;
    $host = getenv('DB_HOST') ?: $host;
    $port = getenv('DB_PORT') ?: ($driver === 'pgsql' ? 5432 : $port);
    $dbname = getenv('DB_NAME') ?: $dbname;
    $username = getenv('DB_USER') ?: $username;
    $password = getenv('DB_PASSWORD') ?: $password;
    $sslMode = getenv('DB_SSLMODE') ?: null;
}

$dsnParts = [
    "{$driver}:host={$host}",
    "port={$port}",
    "dbname={$dbname}",
];

if ($driver === 'mysql') {
    $dsnParts[] = 'charset=utf8mb4';
}

if ($driver === 'pgsql' && $sslMode) {
    $dsnParts[] = "sslmode={$sslMode}";
}

$dsn = implode(';', $dsnParts);

try {
    $conn = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
?>
