<?php 
session_start();
include 'db.php';

if(!isset($_SESSION['usuario_id'])){
    echo "<script>alert('Debes iniciar sesión para comprar.'); window.location.href='login.php';</script>";
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_usuario = $_SESSION['usuario_id'];
    $id_producto = $_POST['id_producto'];
    $cantidad = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 1;
    $sql = "INSERT INTO Carrito (Usuario, Producto) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    $exito = true;

    for($i = 0; $i < $cantidad; $i++){
        mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_producto);
        if(!mysqli_stmt_execute($stmt)){
            $exito = false;
        }
    }

    if($exito){
        header("Location: carrito.php");
    } else {
        echo "Error al agegar al carrito: ".mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

} else {
    header("Location: /index.php");
}

?>