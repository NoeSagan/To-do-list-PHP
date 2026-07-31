<?php
require_once '../config/db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$id   = intval($data['id'] ?? 0);

if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'ID inválido']);
    exit;
}

$pdo  = conectar();
$stmt = $pdo->prepare("DELETE FROM tareas WHERE id = ?");
$stmt->execute([$id]);

echo json_encode(['success' => true]);
