<?php include 'header.php'; ?>

<div class="container my-5">
    <h2 class="text-center mb-4">Tu Carrito de Compras</h2>
    
    <div class="alert alert-info text-center" role="alert">
      Tu carrito está vacío. ¡<a href="/index.php" class="alert-link">Mira nuestro catálogo</a>!
    </div>

    <div class="card mb-3 d-none">
        <div class="row g-0">
            <div class="col-md-2">
                <img src="https://dummyimage.com/600x400/2c3e50/ffffff" class="img-fluid rounded-start" alt="Producto">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Nombre del Producto</h5>
                    <p class="card-text"><small class="text-muted">Fabricante</small></p>
                    <input type="number" class="form-control" value="1" style="width: 80px;">
                    <a href="#" class="btn btn-danger btn-sm mt-2">Eliminar</a>
                </div>
            </div>
            <div class="col-md-2 d-flex align-items-center justify-content-center">
                <p class="price-tag fs-4">$150.00</p>
            </div>
        </div>
    </div>

    <div class="row justify-content-end mt-4">
        <div class="col-md-4">
            <h4>Total: <span class="price-tag">$0.00</span></h4>
            <div class="d-grid">
                <button class="btn btn-primary btn-lg">Finalizar Compra</button>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>