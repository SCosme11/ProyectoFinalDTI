<?php
include 'header.php';
include 'db.php';

if(!isset($_SESSION['es_admin']) || $_SESSION['es_admin'] !== true){
    echo "<script>window.location.href=/index.php;</script>";
    exit;
}

$id_producto = '';
if(isset($_GET['id'])) {
    $id_producto = $_GET['id'];
} elseif(isset($_POST['id_producto'])){
    $id_producto = $_POST['id_producto'];
} else {
    echo "<script>window.location.href='admin.php';</script>";
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $fabricante = $_POST['fabricante'];
    $origen = $_POST['origen'];
    
    // Verificar si subieron una nueva imagen
    if(isset($_FILES['imagen']) && $_FILES['imagen']['size'] > 0 && $_FILES['imagen']['error'] === UPLOAD_ERR_OK){
        // Lógica con actualización de imagen
        $imagen_contenido = file_get_contents($_FILES['imagen']['tmp_name']);
        
        $sql = "UPDATE Productos SET Nombre=?, Descripcion=?, Precio=?, Cantidad=?, Fabricante=?, Origen=?, Imagen=? WHERE ID_Producto=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssdisssi", $nombre, $descripcion, $precio, $cantidad, $fabricante, $origen, $imagen_contenido, $id_producto);
    } else {
        // Lógica SIN actualización de imagen (mantiene la anterior)
        $sql = "UPDATE Productos SET Nombre=?, Descripcion=?, Precio=?, Cantidad=?, Fabricante=?, Origen=? WHERE ID_Producto=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssdissi", $nombre, $descripcion, $precio, $cantidad, $fabricante, $origen, $id_producto);
    }

    if(mysqli_stmt_execute($stmt)){
        $_SESSION['mensaje_texto'] = "Producto actualizado correctamente";
        $_SESSION['mensaje_tipo'] = "success";
        header("Location: admin.php");
    } else {
        $_SESSION['mensaje_texto'] = "Error al actualizar: " . mysqli_error($conn);
        $_SESSION['mensaje_tipo'] = "danger";
        header("Location: admin.php");
    }
}

$sql_get = "SELECT * FROM Productos WHERE ID_Producto = ?";
$stmt_get = mysqli_prepare($conn, $sql_get);
mysqli_stmt_bind_param($stmt_get, "i", $id_producto);
mysqli_stmt_execute($stmt_get);
$resultado = mysqli_stmt_get_result($stmt_get);
$row = mysqli_fetch_assoc($resultado);

if(!$row){
    echo "<div class='container my-5'>Producto no encontrado.</div>";
    include 'footer.php';
    exit;
}
?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h3 class="mb-0"><i class="bi bi-pencil-square"></i> Editar Producto</h3>
                </div>
                <div class="card-body">
                    <form action="editar_producto.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_producto" value="<?php echo $row['ID_Producto']; ?>">

                        <div class="mb-3">
                            <label class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" name="nombre" value="<?php echo htmlspecialchars($row['Nombre']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" name="descripcion" rows="4" required><?php echo htmlspecialchars($row['Descripcion']); ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Precio (MXN)</label>
                                <input type="number" step="0.5" class="form-control" name="precio" value="<?php echo $row['Precio']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Cantidad (Stock)</label>
                                <input type="number" step="1" class="form-control" name="cantidad" value="<?php echo $row['Cantidad']; ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fabricante</label>
                                <input type="text" class="form-control" name="fabricante" value="<?php echo htmlspecialchars($row['Fabricante']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Origen</label>
                                <input type="text" class="form-control" name="origen" value="<?php echo htmlspecialchars($row['Origen']); ?>" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Imagen (Dejar vacío para mantener la actual)</label>
                            <input type="file" class="form-control" name="imagen" accept="image/*">
                            <?php if(!empty($row['Imagen'])): ?>
                                <div class="mt-2">
                                    <small class="text-muted">Imagen actual:</small><br>
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row['Imagen']); ?>" width="100" class="img-thumbnail">
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="admin.php" class="btn btn-secondary me-md-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>