<?php
require_once '../config/db.php';

header('Content-Type: application/json');

$data  = json_decode(file_get_contents('php://input'), true);
$texto = trim($data['texto'] ?? '');

if ($texto === '') {
    http_response_code(400);
    echo json_encode(['error' => 'No puede estar vacío']);
    exit;
}

$pdo  = conectar();
$stmt = $pdo->prepare("INSERT INTO tareas (texto) VALUES (?) RETURNING id");
$stmt->execute([$texto]);
$row  = $stmt->fetch();

echo json_encode([
    'id'         => (int) $row['id'],
    'texto'      => $texto,
    'completada' => false,
]);
