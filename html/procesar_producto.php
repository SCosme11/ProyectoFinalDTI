<?php
include 'db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    
    // 1. PRECIO Y CANTIDAD
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $fabricante = $_POST['fabricante'];
    $origen = $_POST['origen'];

    // 2. PROCESAR IMAGEN A BLOB (BINARIO)
    // Verificamos si se subió un archivo y si no hubo errores
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        
        // Leemos el contenido binario del archivo temporal
        $imagen_contenido = file_get_contents($_FILES['imagen']['tmp_name']);

        // Preparamos la consulta
        $sql = "INSERT INTO Productos (Nombre, Descripcion, Imagen, Precio, Cantidad, Fabricante, Origen) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "sssdiss", $nombre, $descripcion, $imagen_contenido, $precio, $cantidad, $fabricante, $origen);

        if(mysqli_stmt_execute($stmt)){
            echo "<script>alert('Producto agregado exitosamente'); window.location.href='admin.php';</script>";
        } else {
            echo "Error en BD: ".mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
        
    } else {
        echo "<script>alert('Error: Debes seleccionar una imagen válida.'); window.location.href='admin.php';</script>";
    }
}
?>