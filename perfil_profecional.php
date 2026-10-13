<?php
session_start();

if (!isset($_SESSION["profesional_id"])) {
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

$id_profesional = $_SESSION["profesional_id"];

$stmt = $conexion->prepare("SELECT nombre, correo, especialidad, tarjeta_profesional, institucion, experiencia, enfoque, link_perfil FROM profesionales WHERE id = ?");
$stmt->bind_param("i", $id_profesional);
$stmt->execute();
$resultado = $stmt->get_result();

if ($pro_datos = $resultado->fetch_assoc()) {
    $nombreCompleto = trim($pro_datos["nombre"]);
    $correo = $pro_datos["correo"];
    $especialidad = $pro_datos["especialidad"];
    $tarjeta = $pro_datos["tarjeta_profesional"];
    $institucion = $pro_datos["institucion"];
    $experiencia = $pro_datos["experiencia"];
    $enfoque = $pro_datos["enfoque"];
    $linkPerfil = $pro_datos["link_perfil"];
} else {
    die("Profesional no encontrado.");
}

$stmt->close();
$conexion->close();

$partesNombre = explode(" ", $nombreCompleto);
$primerNombre = $partesNombre[0];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Profesional | Illumina</title>
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
            <a href="perfil_profesional.php" class="nav-item active">👨‍⚕️ Mi Perfil</a>
            <a href="pacientes.php" class="nav-item">👥 Pacientes</a>
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
                <span class="badge-paciente">Especialista Verificado</span>
            </div>
        </header>

        <section class="stats-grid">
            <div class="stat-card">
                <span class="stat-label">Especialidad</span>
                <strong class="stat-value" style="font-size: 18px;"><?php echo htmlspecialchars($especialidad); ?></strong>
            </div>

            <div class="stat-card">
                <span class="stat-label">Registro / TP</span>
                <strong class="stat-value" style="font-size: 18px;"><?php echo htmlspecialchars($tarjeta); ?></strong>
            </div>

            <div class="stat-card">
                <span class="stat-label">Experiencia</span>
                <strong class="stat-value"><?php echo $experiencia; ?> <small>años</small></strong>
            </div>

            <div class="stat-card destacado">
                <span class="stat-label">Modalidad</span>
                <strong class="stat-value" style="font-size: 18px;">Virtual</strong>
            </div>
        </section>

        <section class="info-section">
            <h2>Información Profesional</h2>

            <div class="info-grid">
                <div class="info-box">
                    <h3>Institución de Egreso</h3>
                    <p><?php echo htmlspecialchars($institucion); ?></p>
                </div>

                <div class="info-box">
                    <h3>Sitio Web / LinkedIn</h3>
                    <p>
                        <?php if (!empty($linkPerfil)): ?>
                            <a href="<?php echo htmlspecialchars($linkPerfil); ?>" target="_blank" style="color: var(--azul-oscuro); font-weight: 600;">Ver Enlace</a>
                        <?php else: ?>
                            No registrado
                        <?php endif; ?>
                    </p>
                </div>

                <div class="info-box full-width">
                    <h3>Enfoque y Metodología Clínica</h3>
                    <p><?php echo htmlspecialchars($enfoque); ?></p>
                </div>
            </div>
        </section>

    </main>

</div>

</body>
</html>