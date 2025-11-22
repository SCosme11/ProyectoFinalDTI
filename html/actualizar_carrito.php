<?php
session_start();
include 'db.php';

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = $_SESSION['usuario_id'];
    $id_producto = intval($_POST['id_producto']);
    $cantidad_deseada = intval($_POST['cantidad']);

    // Validación básica: mínimo 1 producto. Para eliminar está el botón de eliminar.
    if ($cantidad_deseada < 1) {
        $cantidad_deseada = 1;
    }

    // 1. Contar cuántos tiene actualmente
    $sql_count = "SELECT COUNT(*) as total FROM Carrito WHERE Usuario = ? AND Producto = ?";
    $stmt_count = mysqli_prepare($conn, $sql_count);
    mysqli_stmt_bind_param($stmt_count, "ii", $id_usuario, $id_producto);
    mysqli_stmt_execute($stmt_count);
    $res_count = mysqli_stmt_get_result($stmt_count);
    $row_count = mysqli_fetch_assoc($res_count);
    
    $cantidad_actual = $row_count['total'];
    $diferencia = $cantidad_deseada - $cantidad_actual;

    if ($diferencia > 0) {
        // El usuario quiere MÁS productos: Insertamos la diferencia
        $sql_insert = "INSERT INTO Carrito (Usuario, Producto) VALUES (?, ?)";
        $stmt_insert = mysqli_prepare($conn, $sql_insert);
        mysqli_stmt_bind_param($stmt_insert, "ii", $id_usuario, $id_producto);
        
        for ($i = 0; $i < $diferencia; $i++) {
            mysqli_stmt_execute($stmt_insert);
        }
        mysqli_stmt_close($stmt_insert);

    } elseif ($diferencia < 0) {
        // El usuario quiere MENOS productos: Borramos la diferencia
        // Usamos ABS para convertir -2 en 2 positivo
        $cantidad_a_borrar = abs($diferencia);
        
        // Usamos LIMIT para borrar solo los sobrantes
        $sql_delete = "DELETE FROM Carrito WHERE Usuario = ? AND Producto = ? LIMIT ?";
        $stmt_delete = mysqli_prepare($conn, $sql_delete);
        mysqli_stmt_bind_param($stmt_delete, "iii", $id_usuario, $id_producto, $cantidad_a_borrar);
        mysqli_stmt_execute($stmt_delete);
        mysqli_stmt_close($stmt_delete);
    }

    // Regresar al carrito
    header("Location: carrito.php");
    exit;
} else {
    header("Location: index.php");
}
?>