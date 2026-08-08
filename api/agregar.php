<?php
require_once __DIR__ . '/../auth/auth_check.php';
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');
require_auth_api();

$data  = json_decode(file_get_contents('php://input'), true);
$texto = trim($data['texto'] ?? '');

if ($texto === '') {
    http_response_code(400);
    echo json_encode(['error' => 'No puede estar vacío']);
    exit;
}

$pdo  = conectar();
$stmt = $pdo->prepare("INSERT INTO tareas (texto, usuario_id) VALUES (?, ?) RETURNING id");
$stmt->execute([$texto, usuario_id()]);
$row  = $stmt->fetch();

echo json_encode([
    'id'         => (int) $row['id'],
    'texto'      => $texto,
    'completada' => false,
]);
