<?php
require_once __DIR__ . '/../auth/auth_check.php';
require_once __DIR__ . '/../config/db.php';

header('Content-Type: application/json');
require_auth_api();

$pdo  = conectar();
$stmt = $pdo->prepare("SELECT id, texto, completada FROM tareas WHERE usuario_id = ? ORDER BY created_at ASC");
$stmt->execute([usuario_id()]);

$tareas = [];
while ($row = $stmt->fetch()) {
    $tareas[] = [
        'id'         => (int) $row['id'],
        'texto'      => $row['texto'],
        'completada' => (int) $row['completada'] === 1,
    ];
}

echo json_encode($tareas);
