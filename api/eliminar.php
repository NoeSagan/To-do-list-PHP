<?php
require_once __DIR__ . '/../auth/auth_check.php';
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');
require_auth_api();

$data = json_decode(file_get_contents('php://input'), true);
$id   = intval($data['id'] ?? 0);

if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'ID inválido']);
    exit;
}

$pdo  = conectar();
$stmt = $pdo->prepare("DELETE FROM tareas WHERE id = ? AND usuario_id = ?");
$stmt->execute([$id, usuario_id()]);

echo json_encode(['success' => true]);
