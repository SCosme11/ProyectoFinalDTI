<?php
    include 'header.php';
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
          <h2 class="text-center mb-4">Crear Nueva Cuenta</h2>
            <form action="procesar_registro.php" method="POST">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre Completo</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="correo" name="correo" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
                </div>
                <div class="mb-3">
                    <label for="tarjeta" class="form-label">Número Tarjeta</label>
                    <input type="text" class="form-control" id="tarjeta" name="tarjeta" required>
                </div>
                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección de Envío</label>
                    <textarea class="form-control" id="direccion" name="direccion" rows="3"></textarea>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Registrarme</button>
                </div>
                <p class="mt-3 text-center">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>