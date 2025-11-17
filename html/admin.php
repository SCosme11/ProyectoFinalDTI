<?php include 'header.php'; ?>

<div class="container my-5">
    <h2 class="text-center mb-4">Panel de Administración</h2>
    <p class="text-center">Bienvenido, Admin. Aquí puedes gestionar la tienda.</p>
    
    <div class="accordion" id="adminAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                    Inventario (Reporte de Productos)
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show">
                <div class="accordion-body">
                    Tabla de productos...
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
                    Formulario...
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
                    Historial de todas las compras...
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>