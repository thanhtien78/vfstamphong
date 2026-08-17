<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
session_destroy();
$basePath = $basePath ?? rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\');
header('Location: ' . $basePath . '/login');
exit;
?>




