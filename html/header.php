<?php
    session_start(); //Iniciamos la sesión
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda de Telescopios - Cosmos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="../css/index.css"
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top py-3">
    <div class="container">
        <a class="navbar-brand" href="/index.php">Cosmos</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#miNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="miNavbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/index.php">Inicio (Catálogo)</a></li>
                <li class="nav-item"><a class="nav-link" href="/html/contacto.php">Contacto</a></li>
                <li class="nav-item"><a class="nav-link" href="/html/admin.php">Admin</a></li> 
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="/html/usuario.php"><i class="bi bi-person-circle"></i> Mi Cuenta</a></li>
                <li class="nav-item"><a class="nav-link" href="/html/carrito.php"><i class="bi bi-cart-fill"></i> Carrito (0)</a></li>
                <li class="nav-item"><a class="nav-link" href="/html/login.php">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="/html/registro.php">Registro</a></li>
            </ul>
        </div>
    </div>
</nav>

<main> 