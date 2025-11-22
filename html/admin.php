<?php 
include 'header.php'; 
include 'db.php';

// Verificar seguridad
if (!isset($_SESSION['es_admin']) || $_SESSION['es_admin'] !== true) {
    echo "<script>alert('Acceso denegado'); window.location.href='/index.php';</script>";
    exit;
}
?>

<div class="container my-5">
    <h2 class="text-center mb-4">Panel de Administración</h2>
    <p class="text-center">Bienvenido, Admin. Aquí puedes gestionar la tienda.</p>
    
    <div class="accordion" id="adminAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                    Inventario (Reporte de Productos)
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse">
                <div class="accordion-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr class='text-center'>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Imagen</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Fabricante</th>
                                    <th>Origen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM productos";
                                    $result = mysqli_query($conn, $sql);

                                    if(mysqli_num_rows($result) > 0){
                                        while($row = mysqli_fetch_assoc($result)){
                                            echo "<tr>";
                                            echo "<td class='text-center align-middle'>".$row['ID_Producto']."</td>";
                                            echo "<td class='text-center align-middle'>".$row['Nombre']."</td>";
                                            echo "<td>".$row['Descripcion']."</td>";
                                            echo "<td class='text-center align-middle'>";
                                            if(!empty($row['Imagen'])){
                                                $imagen_base64 = base64_encode($row['Imagen']); //decodifica BLOB a base64
                                                echo '<img src="data:image/jpeg;base64,' . $imagen_base64 . '" alt="Imagen de ' . htmlspecialchars($row['Nombre']) . '" width="100" class="img-thumbnail">';
                                            }else{
                                                echo "Sin imagen";
                                            }
                                            echo "</td>";
                                            echo "<td class='text-center align-middle'>$".$row['Precio']."</td>";
                                            echo "<td class='text-center align-middle'>".$row['Cantidad']."</td>";
                                            echo "<td class='text-center align-middle'>".$row['Fabricante']."</td>";
                                            echo "<td class='text-center align-middle'>".$row['Origen']."</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6' class='text-center'>No hay productos registrados</td></tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                    Agregar Nuevo Producto
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse">
                <div class="accordion-body">
                    <form action="procesar_producto.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" name="descripcion" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Imagen del Producto</label>
                            <input type="file" class="form-control" name="imagen" accept="image/*" required>
                        </div>
                        <div class="col-md-6 mb-3">
                                <label class="form-label">Precio (MXN)</label>
                                <input type="number" step="0.5" class="form-control" name="precio" required>
                        </div>
                        <div class="col-md-6 mb-3">
                                <label class="form-label">Cantidad</label>
                                <input type="number" step="1" class="form-control" name="cantidad" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fabricante</label>
                            <input type="text" class="form-control" name="fabricante" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Origen</label>
                            <input type="text" class="form-control" name="origen" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Guardar Producto</button>
                        </div>                                                                    
                    </form>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                    Historial de Compras (Global)
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse">
                <div class="accordion-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>ID Venta</th>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Producto Vendido</th>
                                    <th>Precio de Venta</th>
                                    <th>Imagen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $sql_hist = "SELECT h.ID_Historial, h.Fecha_Compra, u.Nombre as Cliente, u.Correo,
                                                 p.Nombre as Producto, p.Precio, p.Imagen
                                                 FROM Historial h
                                                 JOIN Usuarios u ON h.Usuario = u.ID_Usuario
                                                 JOIN Productos p ON h.Producto = p.ID_Producto
                                                 ORDER BY h.Fecha_Compra DESC";
                                    
                                    $res_hist = mysqli_query($conn, $sql_hist);

                                    if(mysqli_num_rows($res_hist) > 0){
                                      while($venta = mysqli_fetch_assoc($res_hist)){
                                            echo "<tr>";
                                            echo "<td class='fw-bold'>#".$venta['ID_Historial']."</td>";
                                            $fecha_obj = new DateTime($venta['Fecha_Compra'], new DateTimeZone('UTC'));
                                            $fecha_obj->setTimezone(new DateTimeZone('America/Mexico_City'));
                                            $fecha = $fecha_obj->format('d/m/Y H:i');
                                            echo "<td>".$fecha."</td>";
                                            echo "<td>";
                                            echo "<span class='fw-bold'>".htmlspecialchars($venta['Cliente'])."</span><br>";
                                            echo "<small class='text-muted'>".htmlspecialchars($venta['Correo'])."</small>";
                                            echo "</td>";
                                            echo "<td>".htmlspecialchars($venta['Producto'])."</td>";
                                            echo "<td class='text-success fw-bold'>$".number_format($venta['Precio'], 2)."</td>";
                                            
                                            echo "<td>";
                                            if(!empty($venta['Imagen'])){
                                                $img_b64 = base64_encode($venta['Imagen']);
                                                echo '<img src="data:image/jpeg;base64,' . $img_b64 . '" width="50" height="50" style="object-fit:cover;" class="rounded">';
                                            } else {
                                                echo "<span class='text-muted small'>Sin img</span>";
                                            }
                                            echo "</td>";
                                            echo "</tr>";
                                        }  
                                    } else {
                                        echo "<tr><td colspan='5' class='text-center py-3'>Aún no se han realizado ventas.</td></tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>