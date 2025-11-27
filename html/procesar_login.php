<?php
session_start();
include 'db.php';

$correo = $_POST['correo'];
$password = $_POST['password'];

//Buscamos al usuario por correo
$sql = "SELECT ID_Usuario, Nombre, password, Correo FROM Usuarios WHERE Correo = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $correo);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if($row = mysqli_fetch_assoc($resultado)) {
    //Verifica contraseña
    if(password_verify($password, $row['password'])){
        $_SESSION['usuario_id'] = $row['ID_Usuario'];
        $_SESSION['usuario_nombre'] = $row['Nombre'];
        $_SESSION['usuario_correo'] = $row['Correo'];

        //Para ver si el usuario es el administrador
        if($row['Correo'] === 'admin@cosmos.com') {
            $_SESSION['es_admin'] = true;
        } else {
            $_SESSION['es_admin'] = false;
        }

        //Redirigir al index
        header("Location: /index.php");
        exit();
    } else {
        $_SESSION['mensaje_texto'] = "Contraseña incorrecta.";
        $_SESSION['mensaje_tipo'] = "danger";
        header("Location: login.php");
        exit();
    }
} else {
    //No se encontró al usuario
    $_SESSION['mensaje_texto'] = "El correo ingresado no está registrado.";
    $_SESSION['mensaje_tipo'] = "warning";
    header("Location: login.php");
    exit();
}

mysqli_close($conn);
?>