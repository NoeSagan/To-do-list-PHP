<?php
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/../config/db.php';

iniciar_sesion_segura();

if (!empty($_SESSION['usuario_id'])) {
    header('Location: ' . BASE_URL . '/index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario  = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($usuario === '' || $password === '') {
        $error = 'Usuario y contraseña son requeridos.';
    } else {
        $pdo  = conectar();
        $stmt = $pdo->prepare("SELECT id, password_hash FROM usuarios WHERE usuario = ? LIMIT 1");
        $stmt->execute([$usuario]);
        $row  = $stmt->fetch();

        if ($row && password_verify($password, $row['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['usuario_id'] = (int) $row['id'];
            $_SESSION['usuario']    = $usuario;
            header('Location: ' . BASE_URL . '/index.php');
            exit;
        }

        $error = 'Usuario o contraseña incorrectos.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>/styles.css">
</head>
<body>
  <main class="contenedor">
    <h1>Lista de Tareas</h1>

    <?php if ($error !== ''): ?>
      <p class="error-msg"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <form method="POST" class="form-login">
      <div class="campo">
        <label for="usuario">Usuario</label>
        <input
          type="text"
          id="usuario"
          name="usuario"
          value="<?= htmlspecialchars($_POST['usuario'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
          required
          autocomplete="username"
          autofocus
        >
      </div>
      <div class="campo">
        <label for="password">Contraseña</label>
        <input
          type="password"
          id="password"
          name="password"
          required
          autocomplete="current-password"
        >
      </div>
      <button type="submit" class="btn-login">Entrar</button>
    </form>
  </main>
</body>
</html>
