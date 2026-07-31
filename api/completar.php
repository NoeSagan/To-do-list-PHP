<?php
require_once '../config/db.php';

header('Content-Type: application/json');

$data       = json_decode(file_get_contents('php://input'), true);
$id         = intval($data['id'] ?? 0);
$completada = isset($data['completada']) ? (int) $data['completada'] : -1;

if ($id <= 0 || $completada === -1) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos inválidos']);
    exit;
}

$pdo  = conectar();
$stmt = $pdo->prepare("UPDATE tareas SET completada = ? WHERE id = ?");
$stmt->execute([$completada, $id]);

echo json_encode(['success' => true]);
