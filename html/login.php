<?php
    include 'header.php';
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <h2 class="text-center mb-4">Iniciar Sesión</h2>
            <form action="procesar_login.php" method="POST"> <!-- Falta implementar-->
                <div class="mb-3">
                    <label for="correo" class="form-label">Email</label>
                    <input type="email" class="form-control" id="correo" name="correo" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </div>
                <p class="mt-3 text-center">¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>