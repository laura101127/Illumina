<?php

session_start();

require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.html");
    exit;
}

$correo = strtolower(trim($_POST["correo"] ?? ""));
$password = $_POST["contrasena"] ?? "";
$tipo = $_POST["tipo_usuario"] ?? "";

if ($correo === "" || $password === "") {
    die("Debes ingresar tu correo y contraseña.");
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    die("El correo electrónico no es válido.");
}

// Seleccionar tabla según el tipo de cuenta
if ($tipo === "paciente") {

    $tabla = "usuarios";

} elseif ($tipo === "profesional") {

    $tabla = "profesionales";

} else {

    die("Selecciona un tipo de cuenta válido.");

}

// Buscar cuenta
$sql = "SELECT id, nombre, correo, contrasena
        FROM $tabla
        WHERE correo = ?
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows !== 1) {
    die("No encontramos una cuenta con ese correo.");
}

$cuenta = $resultado->fetch_assoc();

// Verificar contraseña
if (!password_verify($password, $cuenta["contrasena"])) {
    die("La contraseña ingresada es incorrecta.");
}

// Crear sesión segura
session_regenerate_id(true);

if ($tipo === "paciente") {

    $_SESSION["usuario_id"] = $cuenta["id"];
    $_SESSION["usuario_nombre"] = $cuenta["nombre"];
    $_SESSION["usuario_correo"] = $cuenta["correo"];
    $_SESSION["tipo_cuenta"] = "paciente";

    $destino = "perfil.php";

} else {

    $_SESSION["profesional_id"] = $cuenta["id"];
    $_SESSION["profesional_nombre"] = $cuenta["nombre"];
    $_SESSION["profesional_correo"] = $cuenta["correo"];
    $_SESSION["tipo_cuenta"] = "profesional";

    $destino = "perfil_profecional.php";

}

$stmt->close();
$conn->close();

header("Location: " . $destino);
exit;

?>