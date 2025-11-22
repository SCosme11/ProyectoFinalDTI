<?php
session_start();
include 'db.php';

if(!isset($_SESSION['usuario_id'])){
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION['usuario_id'];

//Mover de carrito a historial
$sql_move = "INSERT INTO Historial (Usuario, Producto)
             SELECT Usuario, Producto FROM Carrito WHERE Usuario = ?";
$stmt_move = mysqli_prepare($conn, $sql_move);
mysqli_stmt_bind_param($stmt_move, "i", $id_usuario);

if(mysqli_stmt_execute($stmt_move)){
    $sql_del = "DELETE FROM Carrito WHERE Usuario = ?";
    $stmt_del = mysqli_prepare($conn, $sql_del);
    mysqli_stmt_bind_param($stmt_del, "i", $id_usuario);
    mysqli_stmt_execute($stmt_del);

    echo "<script>alert('¡Compra procesada con éxito!'); window.location.href='/index.php';</script>";
} else {
    echo "Error al procesar compra: ".mysqli_error($conn);
}

mysqli_close($conn);

?>