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
        echo "<script>alert('Producto eliminado correctamente'); window.location.href='admin.php';</script>";
        
    } catch (mysqli_sql_exception $e) {
        // El código de error 1451 es específico de restricción de llave foránea
        if($e->getCode() == 1451) {
            echo "<script>
                alert('No se puede eliminar este producto porque está registrado en el Historial de compras de algunos clientes.\\n\\nPara mantener la integridad de los datos, no se permite borrar productos que ya han sido vendidos.'); 
                window.location.href='admin.php';
            </script>";
        } else {
            // Otros errores
            echo "<script>alert('Error desconocido al eliminar: " . $e->getMessage() . "'); window.location.href='admin.php';</script>";
        }
    }

    mysqli_stmt_close($stmt);
} else {
    header("Location: admin.php");
}
?>