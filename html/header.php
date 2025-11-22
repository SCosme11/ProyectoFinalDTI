<?php
    if(session_status() === PHP_SESSION_NONE){
        session_start(); //Iniciamos la sesión
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cosmos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="/css/index.css"

    <!--Fuentes título -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top py-1">
    <div class="container">
        <a class="navbar-brand" href="/index.php"><img src="/img/Logo.png" alt="Cosmos" height="85"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#miNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="miNavbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="/html/contacto.php">Contacto</a></li>

                <?php
                //Mostrar sólo si es el admin
                if(isset($_SESSION['es_admin']) && $_SESSION['es_admin'] === true): ?>
                    <li class="nav-item"><a class="nav-link" href="/html/admin.php">Admin</a></li>
                <?php endif; ?>
            </ul>

            <ul class="navbar-nav">
                <?php if(isset($_SESSION['usuario_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/html/carrito.php"><i class="bi bi-cart-fill"></i> Carrito</a>
                    </li>
        
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> Hola, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end bg-dark" data-bs-theme="dark">
                            <li><a class="dropdown-item text-light" href="/html/usuario.php">Mi Perfil</a></li>
                            <li><hr class="dropdown-divider bg-secondary"></li>
                            <li><a class="dropdown-item text-danger" href="/html/logout.php">Cerrar Sesión</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="/html/login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="/html/registro.php">Registro</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main> 