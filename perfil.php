<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.html");
    exit;
}

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$baseDatos = "illumina";

$conexion = new mysqli($servidor, $usuario, $contrasena, $baseDatos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8mb4");

$id_usuario = $_SESSION["usuario_id"];

$stmt = $conexion->prepare("SELECT nombre, correo, fecha_nacimiento, peso, altura, motivo, alimentacion, tiene_alergias, alergias FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($usuario_datos = $resultado->fetch_assoc()) {
    $nombreCompleto = trim($usuario_datos["nombre"]);
    $correo = $usuario_datos["correo"];
    $fechaNacimiento = $usuario_datos["fecha_nacimiento"];
    $peso = $usuario_datos["peso"];
    $altura = $usuario_datos["altura"];
    $motivo = $usuario_datos["motivo"];
    $alimentacion = $usuario_datos["alimentacion"];
    $tieneAlergias = $usuario_datos["tiene_alergias"];
    $alergias = $usuario_datos["alergias"];
} else {
    die("Usuario no encontrado.");
}

$stmt->close();
$conexion->close();

$partesNombre = explode(" ", $nombreCompleto);
$primerNombre = $partesNombre[0];

$fechaNac = new DateTime($fechaNacimiento);
$hoy = new DateTime();
$edad = $hoy->diff($fechaNac)->y;

$alturaMetros = $altura / 100;
$imc = ($alturaMetros > 0) ? round($peso / ($alturaMetros * $alturaMetros), 1) : 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil | Illumina</title>
    <link rel="icon" type="image/png" href="media/logo.png">
    <link rel="stylesheet" href="perfil.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="perfil-container">

    <aside class="sidebar">
        <a href="index.html" class="brand">
            <img src="media/logo.png" alt="Illumina" class="brand-logo">
            <span>Illumina</span>
        </a>

        <nav class="nav-menu">
            <a href="perfil.php" class="nav-item active">👤 Mi Perfil</a>
            <a href="dashboard.php" class="nav-item">📊 Progreso</a>
            <a href="logout.php" class="nav-item logout">🚪 Cerrar Sesión</a>
        </nav>
    </aside>

    <main class="perfil-content">

        <header class="perfil-header">
            <div class="avatar-box">
                <span class="avatar-inicial"><?php echo strtoupper(substr($primerNombre, 0, 1)); ?></span>
            </div>
            <div class="header-info">
                <h1>Hola, <?php echo htmlspecialchars($primerNombre); ?></h1>
                <p class="correo"><?php echo htmlspecialchars($correo); ?></p>
                <span class="badge-paciente">Paciente Illumina</span>
            </div>
        </header>

        <section class="stats-grid">
            <div class="stat-card">
                <span class="stat-label">Edad</span>
                <strong class="stat-value"><?php echo $edad; ?> <small>años</small></strong>
            </div>

            <div class="stat-card">
                <span class="stat-label">Peso</span>
                <strong class="stat-value"><?php echo $peso; ?> <small>kg</small></strong>
            </div>

            <div class="stat-card">
                <span class="stat-label">Estatura</span>
                <strong class="stat-value"><?php echo $altura; ?> <small>cm</small></strong>
            </div>

            <div class="stat-card destacado">
                <span class="stat-label">IMC Calculado</span>
                <strong class="stat-value"><?php echo $imc; ?></strong>
            </div>
        </section>

        <section class="info-section">
            <h2>Información de Salud y Alimentación</h2>

            <div class="info-grid">
                <div class="info-box">
                    <h3>Objetivo / Motivo</h3>
                    <p><?php echo htmlspecialchars($motivo); ?></p>
                </div>

                <div class="info-box">
                    <h3>Preferencias de Dieta</h3>
                    <p><?php echo htmlspecialchars($alimentacion); ?></p>
                </div>

                <div class="info-box full-width">
                    <h3>Alergias o Intolerancias</h3>
                    <p>
                        <?php 
                        if ($tieneAlergias === "si" && !empty($alergias)) {
                            echo htmlspecialchars($alergias);
                        } else {
                            echo "No reporta alergias o intolerancias.";
                        }
                        ?>
                    </p>
                </div>
            </div>
        </section>

    </main>

</div>

<script src="perfil.js"></script>
</body>
</html>