<?php
if (!defined('BASE_URL')) {
    define('BASE_URL', '');
}

function iniciar_sesion_segura(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_set_cookie_params([
            'lifetime' => 0,
            'path'     => '/',
            'domain'   => '',
            'secure'   => !empty($_SERVER['HTTPS']),
            'httponly' => true,
            'samesite' => 'Strict',
        ]);
        session_start();
    }
}

function require_auth(): void {
    iniciar_sesion_segura();
    if (empty($_SESSION['usuario_id'])) {
        header('Location: ' . BASE_URL . '/auth/login.php');
        exit;
    }
}

function require_auth_api(): void {
    iniciar_sesion_segura();
    if (empty($_SESSION['usuario_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'No autenticado']);
        exit;
    }
}

function usuario_id(): int {
    return (int) ($_SESSION['usuario_id'] ?? 0);
}

function usuario_nombre(): string {
    return htmlspecialchars($_SESSION['usuario'] ?? '', ENT_QUOTES, 'UTF-8');
}
