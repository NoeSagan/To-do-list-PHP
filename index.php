<?php
require_once __DIR__ . '/auth/auth_check.php';
require_once __DIR__ . '/config/db.php';

require_auth();

$uid    = usuario_id();
$nombre = usuario_nombre();

$pdo  = conectar();
$stmt = $pdo->prepare("SELECT id, texto, completada FROM tareas WHERE usuario_id = ? ORDER BY created_at ASC");
$stmt->execute([$uid]);

$tareas = [];
while ($row = $stmt->fetch()) {
    $tareas[] = [
        'id'         => (int) $row['id'],
        'texto'      => htmlspecialchars($row['texto'], ENT_QUOTES, 'UTF-8'),
        'completada' => (int) $row['completada'] === 1,
    ];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lista de Tareas</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <main class="contenedor">
    <div class="cabecera">
      <h1>Lista de Tareas</h1>
      <div class="sesion-info">
        <span>Hola, <strong><?= $nombre ?></strong></span>
        <a href="auth/logout.php" class="btn-cerrar">Cerrar sesión</a>
      </div>
    </div>

    <div class="entrada">
      <input type="text" id="nuevaTarea" placeholder="Escribe una tarea...">
      <button id="btnAgregar">Agregar</button>
    </div>

    <ul id="listaTareas">
      <?php foreach ($tareas as $tarea): ?>
        <li class="<?= $tarea['completada'] ? 'completada' : '' ?>" data-id="<?= $tarea['id'] ?>">
          <span class="texto"><?= $tarea['texto'] ?></span>
          <button class="btnEliminar">Eliminar</button>
        </li>
      <?php endforeach; ?>
    </ul>
  </main>

  <script src="script.js"></script>
</body>
</html>
