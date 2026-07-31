<?php
require_once 'config/db.php';

$pdo    = conectar();
$stmt   = $pdo->query("SELECT id, texto, completada FROM tareas ORDER BY created_at ASC");
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
    <h1>Lista de Tareas</h1>

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
