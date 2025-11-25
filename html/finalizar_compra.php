<?php
session_start();
include 'db.php';

if(!isset($_SESSION['usuario_id'])){
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION['usuario_id'];

//Obtener resumen de compra
$sql_resumen = "SELECT Producto, COUNT(*) as cantidad_comprada FROM Carrito WHERE Usuario = ? GROUP BY Producto";
$stmt_resumen = mysqli_prepare($conn, $sql_resumen);
mysqli_stmt_bind_param($stmt_resumen, "i", $id_usuario);
mysqli_stmt_execute($stmt_resumen);
$resultado_resumen = mysqli_stmt_get_result($stmt_resumen);

//Verificamos si el carrito tiene algo antes de procesar
if(mysqli_num_rows($resultado_resumen) > 0) {

    //Descontar del inventario
    while($item = mysqli_fetch_assoc($resultado_resumen)){
        $id_prod = $item['Producto'];
        $cant = $item['cantidad_comprada'];

        //Actualizamos la tabla Productos restando la cantidad
        $sql_update = "UPDATE Productos SET Cantidad = Cantidad - ? WHERE ID_Producto = ?";
        $stmt_update = mysqli_prepare($conn, $sql_update);
        mysqli_stmt_bind_param($stmt_update, "ii", $cant, $id_prod);
        mysqli_stmt_execute($stmt_update);
        mysqli_stmt_close($stmt_update);
    }

    //Mover a Historial
    $sql_move = "INSERT INTO Historial (Usuario, Producto) SELECT Usuario, Producto FROM Carrito WHERE Usuario = ?";
    $stmt_move = mysqli_prepare($conn, $sql_move);
    mysqli_stmt_bind_param($stmt_move, "i", $id_usuario);
    
    if(mysqli_stmt_execute($stmt_move)){
        //Vaciar Carrito
        $sql_del = "DELETE FROM Carrito WHERE Usuario = ?";
        $stmt_del = mysqli_prepare($conn, $sql_del);
        mysqli_stmt_bind_param($stmt_del, "i", $id_usuario);
        mysqli_stmt_execute($stmt_del);

        echo "<script>alert('¡Compra procesada con éxito!'); window.location.href='/index.php';</script>";
    } else {
        echo "Error al guardar historial: ".mysqli_error($conn);
    }

} else {
    echo "<script>alert('Tu carrito está vacío.'); window.location.href='/index.php';</script>";
}

mysqli_close($conn);
?>