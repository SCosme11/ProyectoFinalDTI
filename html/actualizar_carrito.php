<?php
session_start();
include 'db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = $_SESSION['usuario_id'];
    $id_producto = intval($_POST['id_producto']);
    $cantidad_deseada = intval($_POST['cantidad']);

    if ($cantidad_deseada < 1) $cantidad_deseada = 1;

    //Verificar Stock Disponible
    $sql_stock = "SELECT Cantidad FROM Productos WHERE ID_Producto = ?";
    $stmt_stock = mysqli_prepare($conn, $sql_stock);
    mysqli_stmt_bind_param($stmt_stock, "i", $id_producto);
    mysqli_stmt_execute($stmt_stock);
    $res_stock = mysqli_stmt_get_result($stmt_stock);
    $row_stock = mysqli_fetch_assoc($res_stock);
    $stock_real = $row_stock['Cantidad'];

    //Si quiere más de lo que existe
    if ($cantidad_deseada > $stock_real) {
        $_SESSION['mensaje_texto'] = "No puedes tener $cantidad_deseada unidades. Solo hay $stock_real disponibles en inventario";
        $_SESSION['mensaje_tipo'] = "danger";
        header("Location: carrito.php");
        exit;
    }

    //Contar cantidad actual en carrito
    $sql_count = "SELECT COUNT(*) as total FROM Carrito WHERE Usuario = ? AND Producto = ?";
    $stmt_count = mysqli_prepare($conn, $sql_count);
    mysqli_stmt_bind_param($stmt_count, "ii", $id_usuario, $id_producto);
    mysqli_stmt_execute($stmt_count);
    $res_count = mysqli_stmt_get_result($stmt_count);
    $row_count = mysqli_fetch_assoc($res_count);
    
    $cantidad_actual = $row_count['total'];
    $diferencia = $cantidad_deseada - $cantidad_actual;

    //Ajustar filas
    if ($diferencia > 0) {
        $sql_insert = "INSERT INTO Carrito (Usuario, Producto) VALUES (?, ?)";
        $stmt_insert = mysqli_prepare($conn, $sql_insert);
        mysqli_stmt_bind_param($stmt_insert, "ii", $id_usuario, $id_producto);
        for ($i = 0; $i < $diferencia; $i++) {
            mysqli_stmt_execute($stmt_insert);
        }
    } elseif ($diferencia < 0) {
        $cantidad_a_borrar = abs($diferencia);
        $sql_delete = "DELETE FROM Carrito WHERE Usuario = ? AND Producto = ? LIMIT ?";
        $stmt_delete = mysqli_prepare($conn, $sql_delete);
        mysqli_stmt_bind_param($stmt_delete, "iii", $id_usuario, $id_producto, $cantidad_a_borrar);
        mysqli_stmt_execute($stmt_delete);
    }

    header("Location: carrito.php");
    exit;
} else {
    header("Location: index.php");
}
?>