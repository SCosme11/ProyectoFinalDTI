<?php
include 'header.php';
include 'db.php';

if(!isset($_GET['id'])){
    echo "<script>alert('Producto no especificado'); window.location.href='/index.php';</script>";
    exit;
}

$id_producto = $_GET['id'];

$sql = "SELECT * FROM Productos WHERE ID_Producto = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_producto);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if($row = mysqli_fetch_assoc($resultado)){
    if(!empty($row['Imagen'])){
        $imagen_src = 'data:image/jpeg;base64,' . base64_encode($row['Imagen']);
    } else {
        $imagen_src = 'https://dummyimage.com/600x400/2c3e50/ffffff&text=Sin+Imagen';
    }
?>

<div class="container my-5">
    <a href="/index.php" class="btn btn-secondary mb-4"><i class="bi bi-arrow-left"></i> Volver al catálogo</a>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm">
                <img src="<?php echo $imagen_src; ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($row['Nombre']); ?>" style="width: 100%; object-fit: contain;">
            </div>
        </div>

        <div class="col-md-6">
            <h1 class="display-5 fw-bold text-center"><?php echo htmlspecialchars($row['Nombre']); ?></h1>
            <p class="text-muted fs-5 text-center">Fabricante: <?php echo htmlspecialchars($row['Fabricante']); ?> | Origen: <?php echo htmlspecialchars($row['Origen']); ?></p>
            
            <h2 class="text-primary my-4 text-center">$<?php echo number_format($row['Precio'], 2); ?> MXN</h2>

            <p class="lead">
                <?php echo nl2br(htmlspecialchars($row['Descripcion'])); ?>
            </p>

            <hr>

            <div class="d-flex align-items-center mt-4">
                <div class="me-3">
                    <strong>Disponibles:</strong> <?php echo $row['Cantidad']; ?>
                </div>
            </div>

            <form action="agregar_carrito.php" method="POST" class="mt-4">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label for="cantidad" class="col-form-label">Cantidad:</label>
                    </div>
                    <div class="col-auto">
                        <input type="number" name="cantidad" id="cantidad" class="form-control" value="1" min="1" max="<?php echo $row['Cantidad']; ?>" style="width: 80px;">
                    </div>
                    <div class="col-auto">
                         <input type="hidden" name="id_producto" value="<?php echo $row['ID_Producto']; ?>">
                        <button type="submit" class="btn btn-primary btn-lg px-5">Añadir al Carrito</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php 
} else {
    echo "<div class='container my-5'><div class='alert alert-danger'>El producto no existe.</div></div>";
}

include 'footer.php'; 
?>