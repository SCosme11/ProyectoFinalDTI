<?php include 'html/header.php'; ?>

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
          <p class="text-muted">Mostrando 6 de 30 productos</p>
      </div>
  </div>

  <div class="row row-cols-1 row-cols-md-3 g-4">
    
    <div class="col">
      <div class="card h-100">
        <div class="position-absolute top-0 start-0 m-2 badge bg-danger">OFERTA</div>
        <img src="https://dummyimage.com/600x400/2c3e50/ffffff&text=Telescopio+Reflector" class="card-img-top" alt="Telescopio">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">Celestron PowerSeeker</h5>
          <p class="card-text text-muted small">Ideal para principiantes. Apertura de 127mm.</p>
          <div class="mt-auto">
              <p class="price-tag">$150.00 USD</p>
              <div class="d-grid gap-2">
                  <button class="btn btn-outline-primary">Ver detalles</button>
                  <button class="btn btn-primary">Añadir al carrito</button>
              </div>
          </div>
        </div>
      </div>
    </div>
    </div> 
  <nav aria-label="Navegación de productos" class="mt-5">
    </nav>

</div>
<br><br>

<?php include 'html/footer.php'; ?>