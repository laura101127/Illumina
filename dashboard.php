<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

$stmt = $conn->prepare("SELECT nombre, tipo_usuario, peso, altura, motivo FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$user_data = $stmt->get_result()->fetch_assoc();
$stmt->close();

$query_recetas = "SELECT id, nombre, descripcion, tiempo_preparacion, indice_glucemico FROM receta LIMIT 6";
$recetas_result = $conn->query($query_recetas);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Illumina | Panel Principal</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
</head>
<body>

    <header class="navbar">
        <div class="logo-container">
            <img src="media/logo.png" alt="Illumina Logo" class="logo">
            <span>Illumina</span>
        </div>
        <nav>
            <a href="dashboard.php" class="nav-link active">Inicio</a>
            <a href="recetas.php" class="nav-link">Recetas</a>
            <a href="progreso.php" class="nav-link">Mi Progreso</a>
            <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
        </nav>
    </header>

    <main class="main-content">
        <section class="welcome-banner">
            <h1>¡Hola, <span id="userName"><?php echo htmlspecialchars($user_data['nombre'] ?? 'Usuario'); ?></span>! 👋</h1>
            <p>Bienvenido a tu plataforma de nutrición inteligente.</p>
        </section>

        <section class="kpi-grid">
            <div class="kpi-card">
                <h3>Peso Actual</h3>
                <p class="kpi-value"><?php echo !empty($user_data['peso']) ? htmlspecialchars($user_data['peso']) . ' kg' : 'Sin registrar'; ?></p>
            </div>
            <div class="kpi-card">
                <h3>Estatura</h3>
                <p class="kpi-value"><?php echo !empty($user_data['altura']) ? htmlspecialchars($user_data['altura']) . ' m' : 'Sin registrar'; ?></p>
            </div>
            <div class="kpi-card">
                <h3>Objetivo Nutricional</h3>
                <p class="kpi-value"><?php echo htmlspecialchars($user_data['motivo'] ?? 'Bienestar General'); ?></p>
            </div>
        </section>

        <section class="filter-section">
            <h2>Recetas Recomendadas</h2>
            <div class="filter-buttons">
                <button class="btn-filter active" data-filter="todos">Todas</button>
                <button class="btn-filter" data-filter="bajo">Bajo IG</button>
                <button class="btn-filter" data-filter="medio">Medio IG</button>
            </div>
        </section>

        <section class="recipes-section">
            <div class="recipes-grid" id="recipesGrid">
                <?php if ($recetas_result && $recetas_result->num_rows > 0): ?>
                    <?php while ($receta = $recetas_result->fetch_assoc()): 
                        $ig = strtolower($receta['indice_glucemico'] ?? 'bajo');
                    ?>
                        <article class="recipe-card" data-category="<?php echo htmlspecialchars($ig); ?>">
                            <div class="badge"><?php echo htmlspecialchars($receta['indice_glucemico'] ?? 'Bajo IG'); ?></div>
                            <h3><?php echo htmlspecialchars($receta['nombre']); ?></h3>
                            <p><?php echo htmlspecialchars($receta['descripcion']); ?></p>
                            <div class="recipe-meta">
                                <span>⏱️ <?php echo htmlspecialchars($receta['tiempo_preparacion']); ?> mins</span>
                                <button class="btn-favorite" title="Guardar en favoritos">❤️</button>
                            </div>
                        </article>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="no-recipes">No hay recetas disponibles en el sistema actualmente.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <script src="js/dashboard.js"></script>
</body>
</html>