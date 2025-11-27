<?php
session_start();
include 'db.php';

if (!isset($_SESSION['es_admin']) || $_SESSION['es_admin'] !== true) {
    echo "<script>alert('Acceso denegado'); window.location.href='/index.php';</script>";
    exit;
}

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "DELETE FROM Productos WHERE ID_Producto = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    try {
        mysqli_stmt_execute($stmt);
        // Si llega aquí, es que no hubo error
        $_SESSION['mensaje_texto'] = "Producto eliminado correctamente";
        $_SESSION['mensaje_tipo'] = "success";
        header("Location: admin.php");
        
    } catch (mysqli_sql_exception $e) {
        // El código de error 1451 es específico de restricción de llave foránea
        if($e->getCode() == 1451) {
            $_SESSION['mensaje_texto'] = "No se puede eliminar este producto porque está registrado en el Historial de compras de algunos clientes.\\n\\nPara mantener la integridad de los datos, no se permite borrar productos que ya han sido vendidos.";
            $_SESSION['mensaje_tipo'] = "danger";
            header("Location: admin.php");
        } else {
            // Otros errores
            $_SESSION['mensaje_texto'] = "Error desconocido al eliminar: ".$e->getMessage();
            $_SESSION['mensaje_tipo'] = "danger";
            header("Location: admin.php");
        }
    }

    mysqli_stmt_close($stmt);
} else {
    header("Location: admin.php");
}
?>