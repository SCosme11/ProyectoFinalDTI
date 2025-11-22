<?php 
include 'header.php'; 
include 'db.php';

// Seguridad
if (!isset($_SESSION['usuario_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$id_usuario = $_SESSION['usuario_id'];

// Lógica de Eliminar Todo el producto (Botón Eliminar)
if(isset($_GET['eliminar_todo'])){
    $id_prod_eliminar = $_GET['eliminar_todo'];
    $sql_del = "DELETE FROM Carrito WHERE Usuario = ? AND Producto = ?";
    $stmt_del = mysqli_prepare($conn, $sql_del);
    mysqli_stmt_bind_param($stmt_del, "ii", $id_usuario, $id_prod_eliminar);
    mysqli_stmt_execute($stmt_del);
    echo "<script>window.location.href='carrito.php';</script>";
}

// Consulta Agrupada
$sql = "SELECT p.ID_Producto, p.Nombre, p.Precio, p.Fabricante, p.Imagen, COUNT(*) as cantidad_en_carrito
        FROM Carrito c 
        JOIN Productos p ON c.Producto = p.ID_Producto 
        WHERE c.Usuario = ?
        GROUP BY p.ID_Producto";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_usuario);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

$total_compra = 0;
?>

<div class="container my-5">
    <h2 class="text-center mb-4">Tu Carrito de Compras</h2>
    
    <?php if(mysqli_num_rows($resultado) == 0): ?>
        <div class="alert alert-info text-center">
          Tu carrito está vacío. ¡<a href="/index.php" class="alert-link">Ver catálogo</a>!
        </div>
    <?php else: ?>

        <?php while($row = mysqli_fetch_assoc($resultado)): 
            $subtotal = $row['Precio'] * $row['cantidad_en_carrito'];
            $total_compra += $subtotal;
            
            if(!empty($row['Imagen'])){
                $img = 'data:image/jpeg;base64,' . base64_encode($row['Imagen']);
            } else {
                $img = 'https://dummyimage.com/600x400/2c3e50/ffffff&text=Sin+Imagen';
            }
        ?>
        <div class="card mb-3 shadow-sm">
            <div class="row g-0">
                <div class="col-md-2">
                    <img src="<?php echo $img; ?>" class="img-fluid rounded-start" style="height:100%; object-fit:cover;" alt="Producto">
                </div>
                <div class="col-md-7">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['Nombre']); ?></h5>
                        <p class="card-text text-muted small"><?php echo htmlspecialchars($row['Fabricante']); ?></p>
                        
                        <form action="actualizar_carrito.php" method="POST" class="row g-3 align-items-center mt-2">
                            <div class="col-auto">
                                <label class="col-form-label">Cantidad:</label>
                            </div>
                            <div class="col-auto">
                                <input type="hidden" name="id_producto" value="<?php echo $row['ID_Producto']; ?>">
                                <input type="number" name="cantidad" class="form-control text-center" value="<?php echo $row['cantidad_en_carrito']; ?>" min="1" style="width: 80px;">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-outline-primary btn-sm">Actualizar</button>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="col-md-3 d-flex flex-column align-items-center justify-content-center p-3 bg-light border-start">
                    <span class="text-muted small">Unitario: $<?php echo number_format($row['Precio'], 2); ?></span>
                    <span class="price-tag fs-5 my-2 text-primary fw-bold">$<?php echo number_format($subtotal, 2); ?></span>
                    
                    <a href="carrito.php?eliminar_todo=<?php echo $row['ID_Producto']; ?>" class="btn btn-danger btn-sm mt-2" onclick="return confirm('¿Seguro que quieres eliminar este producto?')">
                        <i class="bi bi-trash"></i> Eliminar
                    </a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>

        <div class="row justify-content-end mt-4">
            <div class="col-md-4">
                <div class="card p-3">
                    <h4 class="d-flex justify-content-between align-items-center">
                        <span>Total:</span> 
                        <span class="text-success fw-bold">$<?php echo number_format($total_compra, 2); ?></span>
                    </h4>
                    <div class="d-grid mt-3">
                        <form action="finalizar_compra.php" method="POST">
                            <button type="submit" class="btn btn-success btn-lg w-100">Finalizar Compra</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>