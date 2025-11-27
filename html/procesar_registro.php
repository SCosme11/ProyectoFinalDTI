<?php
session_start();
include 'db.php';

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$password = $_POST['password'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$tarjeta = $_POST['tarjeta'];
$direccion = $_POST['direccion'];

//Hasheamos la contraseña
$password_hashed = password_hash($password, PASSWORD_DEFAULT);

//Preparamos la consulta para evitar inyecciones de código
$sql = "INSERT INTO Usuarios (Nombre, Correo, password, Fecha_nacimiento, Numero_tarjeta, Direccion)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssssss", $nombre, $correo, $password_hashed, $fecha_nacimiento, $tarjeta, $direccion);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['mensaje_texto'] = "Cuenta creada con éxito. Por favor inicia sesión.";
    $_SESSION['mensaje_tipo'] = "success";
    header("Location: login.php");
} else {
    $_SESSION['mensaje_texto'] = "Error al registrar: ". mysqli_error($conn);
    $_SESSION['mensaje_tipo'] = "danger";
    header("Location: registro.php");
}

mysqli_close($conn);
?>
