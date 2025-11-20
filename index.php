<?php 
include 'html/header.php';
include 'html/db.php';

//lógica paginación
$productos_por_pagina = 9;
$pagina_actual = isset($_GET['page']) ? (int)$_GET['page'] : 1; //Obtenemos la página actual de la URL
if($pagina_actual < 1){
  $pagina_actual = 1;
}

$offset = ($pagina_actual - 1) * $productos_por_pagina; //desde que producto leer

$sql_total = "SELECT COUNT(*) AS total FROM Productos";
$resultado_total = mysqli_query($conn, $sql_total);
$fila_total = mysqli_fetch_assoc($resultado_total);
$total_productos = $fila_total['total'];
$total_paginas = ceil($total_productos / $productos_por_pagina);

$sql = "SELECT * FROM Productos LIMIT $offset, $productos_por_pagina";
$resultado = mysqli_query($conn, $sql);
?>

<div class="hero-section text-center">
  <div class="container">
    <h1 class="display-4 fw-bold">Cosmos</h1>      
    <p class="lead">Explora las estrellas con la mejor tecnología óptica</p>
    <a href="#productos" class="btn btn-primary btn-lg mt-3">Ver Catálogo</a>
  </div>
</div>

<div class="container mt-5" id="productos">    
  
  <div class="row mb-4">
      <div class="col-12">
          <h3>Catálogo de Telescopios</h3>
          <p class="text-muted">Mostrando página <?php echo $pagina_actual; ?> de <?php echo $total_paginas; ?>
            (Total productos: <?php echo $total_productos; ?>)
          </p>
      </div>
  </div>

  <div class="row row-cols-1 row-cols-md-3 g-4">

    <?php 
    if(mysqli_num_rows($resultado) > 0){
      while($row = mysqli_fetch_assoc($resultado)){
        if(!empty($row['Imagen'])){
          $imagen_src = 'data:image/jpeg;base64,' . base64_encode($row['Imagen']);
        } else {
          $imagen_src = 'https://dummyimage.com/600x400/2c3e50/ffffff&text=Sin+Imagen';
        }
    ?>

    <div class="col">
        <div class="card h-100">
            <img src="<?php echo $imagen_src; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['Nombre']); ?>">

            <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?php echo htmlspecialchars($row['Nombre']); ?></h5>
                <p class="card-text text-muted small">
                  <?php 
                    echo substr(htmlspecialchars($row['Descripcion']), 0, 100) . '...';
                  ?>
                </p>
                <div class="mt-auto">
                  <p class="price-tag">
                    $<?php echo number_format($row['Precio'], 2); ?> MXN
                  </p>
                  <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary">Ver detalles</button>
                    <form action="html/agregar_carrito.php" method="POST">
                      <input type="hidden" name="id_producto" value="<?php echo $row['ID_Producto']; ?>">
                      <button type="submit" class="btn btn-primary w-100">Añadir al carrito</button>
                    </form>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
      }
    } else {
      echo "<div class='col-12'><div class='alert alert-warning'>No hay productos disponibles en este momento</div></div>";
    }
    ?>
  
  <nav aria-label="Navegación de productos" class="mt-5">
    <ul class="pagination justify-content-center">
      <li class="page-item <?php if($pagina_actual <= 1){ echo 'disabled'; } ?>">
        <a class="page-link" href="<?php if($pagina_actual <= 1){ echo '#'; } else { echo "?page=".($pagina_actual - 1)."#productos"; } ?>">
          Anterior
        </a>
      </li>

      <?php for($i = 1; $i <= $total_paginas; $i++): ?>
        <li class="page-item <?php if($pagina_actual == $i) echo 'active'; ?>">
          <a class="page-link" href="?page=<?php echo $i; ?>#productos"><?php echo $i; ?></a>
        </li>
      <?php endfor; ?>

      <li class="page-item <?php if($pagina_actual >= $total_paginas){ echo 'disabled'; } ?>">
        <a class="page-link" href="<?php if($pagina_actual >= $total_paginas){ echo '#'; } else { echo "?page=".($pagina_actual + 1)."#productos"; } ?>">
          Siguiente
        </a>
      </li>
    </ul>
  </nav>
</div>
<br><br>

<?php include 'html/footer.php'; ?>