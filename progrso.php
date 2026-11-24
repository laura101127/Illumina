<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $peso = !empty($_POST['peso']) ? $_POST['peso'] : null;
    $agua = !empty($_POST['agua']) ? $_POST['agua'] : 0;
    $calorias = !empty($_POST['calorias']) ? $_POST['calorias'] : 0;
    $fecha = date('Y-m-d');

    if ($peso) {
        $stmt_u = $conn->prepare("UPDATE usuarios SET peso = ? WHERE id = ?");
        $stmt_u->bind_param("di", $peso, $usuario_id);
        $stmt_u->execute();
        $stmt_u->close();
        $mensaje = "¡Registro actualizado con éxito!";
    }
}

$stmt = $conn->prepare("SELECT nombre, peso, altura FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$user_data = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Illumina | Mi Progreso</title>
    <link rel="stylesheet" href="css/progreso.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
</head>
<body>

    <header class="navbar">
        <div class="logo-container">
            <img src="media/logo.png" alt="Illumina Logo" class="logo">
            <span>Illumina</span>
        </div>
        <nav>
            <a href="dashboard.php" class="nav-link">Inicio</a>
            <a href="recetas.php" class="nav-link">Recetas</a>
            <a href="progreso.php" class="nav-link active">Mi Progreso</a>
            <a href="perfil.php" class="nav-link">Mi Perfil</a>
            <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
        </nav>
    </header>

    <main class="main-content">
        <section class="head-banner">
            <h1>Seguimiento de Progreso</h1>
            <p>Registra tus métricas diarias para evaluar tu evolución.</p>
            <?php if (!empty($mensaje)): ?>
                <div class="alert-success"><?php echo $mensaje; ?></div>
            <?php endif; ?>
        </section>

        <section class="progress-grid">
            <div class="card-form">
                <h2>Registrar Métricas Hoy</h2>
                <form action="progreso.php" method="POST" id="progressForm">
                    <div class="form-group">
                        <label for="peso">Peso actual (kg)</label>
                        <input type="number" step="0.1" id="peso" name="peso" value="<?php echo htmlspecialchars($user_data['peso'] ?? ''); ?>" placeholder="Ej. 65.5" required>
                    </div>

                    <div class="form-group">
                        <label for="agua">Consumo de Agua (Litros)</label>
                        <input type="number" step="0.1" id="agua" name="agua" placeholder="Ej. 2.0" required>
                    </div>

                    <div class="form-group">
                        <label for="calorias">Calorías consumidas (kcal)</label>
                        <input type="number" id="calorias" name="calorias" placeholder="Ej. 1800">
                    </div>

                    <button type="submit" class="btn-submit">Guardar Registro</button>
                </form>
            </div>

            <div class="card-summary">
                <h2>Estado Actual</h2>
                <div class="metric-box">
                    <span>Peso Registrado</span>
                    <strong><?php echo !empty($user_data['peso']) ? htmlspecialchars($user_data['peso']) . ' kg' : 'Sin datos'; ?></strong>
                </div>
                <div class="metric-box">
                    <span>Estatura</span>
                    <strong><?php echo !empty($user_data['altura']) ? htmlspecialchars($user_data['altura']) . ' m' : 'Sin datos'; ?></strong>
                </div>
            </div>
        </section>
    </main>

    <script src="js/progreso.js"></script>
</body>
</html>