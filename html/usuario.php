<?php 
include 'header.php'; 
include 'db.php';

if (!isset($_SESSION['usuario_id'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit;
}

$id_usuario = $_SESSION['usuario_id'];
$mensaje = "";
$tipo_alerta = "";

//Actualizar los datos
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $tarjeta = $_POST['tarjeta'];
    $direccion = $_POST['direccion'];
    $nueva_password = $_POST['password'];

    if(!empty($nueva_password)){
        $password_hashed = password_hash($nueva_password, PASSWORD_DEFAULT);
        $sql_update = "UPDATE Usuarios SET Nombre=?, Correo=?, password=?, Fecha_nacimiento=?, Numero_tarjeta=?, Direccion=? WHERE ID_Usuario=?";
        $stmt_update = mysqli_prepare($conn, $sql_update);
        mysqli_stmt_bind_param($stmt_update, "ssssssi", $nombre, $correo, $password_hashed, $fecha_nacimiento, $tarjeta, $direccion, $id_usuario);
    } else {
        $sql_update = "UPDATE Usuarios SET Nombre=?, Correo=?, Fecha_nacimiento=?, Numero_tarjeta=?, Direccion=? WHERE ID_Usuario=?";
        $stmt_update = mysqli_prepare($conn, $sql_update);
        mysqli_stmt_bind_param($stmt_update, "sssssi", $nombre, $correo, $fecha_nacimiento, $tarjeta, $direccion, $id_usuario);
    }

    if(mysqli_stmt_execute($stmt_update)){
        $mensaje = "Información actualizada correctamente.";
        $tipo_alerta = "success";
        $_SESSION['usuario_nombre'] = $nombre;
    } else {
        $mensaje = "Error al actualizar: ". mysqli_error($conn);
        $tipo_alerta = "danger";
    }
    mysqli_stmt_close($stmt_update);
}

//Obtener datos actuales 
$sql_user = "SELECT * FROM Usuarios WHERE ID_Usuario = ?";
$stmt_user = mysqli_prepare($conn, $sql_user);
mysqli_stmt_bind_param($stmt_user, "i", $id_usuario);
mysqli_stmt_execute($stmt_user);
$res_user = mysqli_stmt_get_result($stmt_user);
$usuario = mysqli_fetch_assoc($res_user);

$sql_hist = "SELECT h.Fecha_Compra, p.Nombre, p.Precio, p.Imagen, p.Fabricante
             FROM Historial h
             JOIN Productos p ON h.Producto = p.ID_Producto
             WHERE h.Usuario = ?
             ORDER BY h.Fecha_Compra DESC";
$stmt_hist = mysqli_prepare($conn, $sql_hist);
mysqli_stmt_bind_param($stmt_hist, "i", $id_usuario);
mysqli_stmt_execute($stmt_hist);
$res_hist = mysqli_stmt_get_result($stmt_hist);
?>

<div class="container my-5">
    <?php
        if(!empty($mensaje)):
    ?>
    <div class="alert alert-<?php echo $tipo_alerta; ?> alert-dismissible fade show" role="alert">
            <?php echo $mensaje; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-5 mb-5">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-person-gear"></i> Mi Información</h4>
                </div>
                <div class="card-body">
                    <form action="usuario.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" name="nombre" value="<?php echo htmlspecialchars($usuario['Nombre']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" name="correo" value="<?php echo htmlspecialchars($usuario['Correo']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control" name="password" placeholder="Dejar en blanco para no cambiar">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" name="fecha_nacimiento" value="<?php echo $usuario['Fecha_nacimiento']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Número de Tarjeta</label>
                            <input type="text" class="form-control" name="tarjeta" value="<?php echo htmlspecialchars($usuario['Numero_tarjeta']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dirección de Envío</label>
                            <textarea class="form-control" name="direccion" rows="3" required><?php echo htmlspecialchars($usuario['Direccion']); ?></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Actualizar Datos</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <h3 class="mb-4 text-center">Mi Historial de Compras</h3>
            
            <?php if(mysqli_num_rows($res_hist) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle border">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Producto</th>
                                <th>Detalles</th>
                                <th class="text-end">Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($compra = mysqli_fetch_assoc($res_hist)): 
                                // Formatear fecha
                                $fecha_obj = new DateTime($compra['Fecha_Compra']);
                                $fecha_formato = $fecha_obj->format('d/m/Y');
                                
                                // Procesar imagen (igual que en index.php)
                                if(!empty($compra['Imagen'])){
                                    $img_src = 'data:image/jpeg;base64,' . base64_encode($compra['Imagen']);
                                } else {
                                    $img_src = 'https://dummyimage.com/100x100/2c3e50/ffffff&text=X';
                                }
                            ?>
                            <tr>
                                <td class="small text-muted"><?php echo $fecha_formato; ?></td>
                                <td>
                                    <img src="<?php echo $img_src; ?>" alt="Producto" class="rounded" width="50" height="50" style="object-fit: cover;">
                                </td>
                                <td>
                                    <span class="fw-bold d-block"><?php echo htmlspecialchars($compra['Nombre']); ?></span>
                                    <small class="text-muted"><?php echo htmlspecialchars($compra['Fabricante']); ?></small>
                                </td>
                                <td class="text-end fw-bold text-primary">
                                    $<?php echo number_format($compra['Precio'], 2); ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center">
                    <i class="bi bi-bag-x"></i> Aún no has realizado ninguna compra.
                    <br><a href="/index.php" class="mt-2 btn btn-sm btn-outline-info">Ir a comprar</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>