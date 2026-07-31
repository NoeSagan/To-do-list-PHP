<?php
require_once '../config/db.php';

header('Content-Type: application/json');

$pdo  = conectar();
$stmt = $pdo->query("SELECT id, texto, completada FROM tareas ORDER BY created_at ASC");

$tareas = [];
while ($row = $stmt->fetch()) {
    $tareas[] = [
        'id'         => (int) $row['id'],
        'texto'      => $row['texto'],
        'completada' => (int) $row['completada'] === 1,
    ];
}

echo json_encode($tareas);
