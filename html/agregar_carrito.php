<?php 
session_start();
include 'db.php';

if(!isset($_SESSION['usuario_id'])){
    echo "<script>alert('Debes iniciar sesión para comprar.'); window.location.href='login.php';</script>";
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_usuario = $_SESSION['usuario_id'];
    $id_producto = $_POST['id_producto'];
    $cantidad_solicitada = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 1;

    //Consultar Stock en la Base de Datos
    $sql_prod = "SELECT Cantidad, Nombre FROM Productos WHERE ID_Producto = ?";
    $stmt_prod = mysqli_prepare($conn, $sql_prod);
    mysqli_stmt_bind_param($stmt_prod, "i", $id_producto);
    mysqli_stmt_execute($stmt_prod);
    $res_prod = mysqli_stmt_get_result($stmt_prod);
    $producto = mysqli_fetch_assoc($res_prod);
    
    $stock_maximo = $producto['Cantidad'];
    $nombre_prod = $producto['Nombre'];

    //Consultar cuántos ya tiene este usuario en el carrito
    $sql_cart = "SELECT COUNT(*) as total FROM Carrito WHERE Usuario = ? AND Producto = ?";
    $stmt_cart = mysqli_prepare($conn, $sql_cart);
    mysqli_stmt_bind_param($stmt_cart, "ii", $id_usuario, $id_producto);
    mysqli_stmt_execute($stmt_cart);
    $res_cart = mysqli_stmt_get_result($stmt_cart);
    $row_cart = mysqli_fetch_assoc($res_cart);
    
    $ya_en_carrito = $row_cart['total'];

    //Calcular si es posible agregar
    $total_final = $ya_en_carrito + $cantidad_solicitada;

    if($total_final > $stock_maximo){
        // Calculamos cuántos más puede agregar
        $disponibles_para_agregar = $stock_maximo - $ya_en_carrito;
        if($disponibles_para_agregar < 0) $disponibles_para_agregar = 0;

        echo "<script>
            alert('Stock insuficiente para \"$nombre_prod\".\\nTotal en inventario: $stock_maximo.\\nYa tienes: $ya_en_carrito en el carrito.\\nSolo puedes agregar $disponibles_para_agregar más.'); 
            window.history.back();
        </script>";
        exit; 
    }

    //Si pasamos la validación, procedemos a insertar
    $sql = "INSERT INTO Carrito (Usuario, Producto) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    $exito = true;
    for($i = 0; $i < $cantidad_solicitada; $i++){
        mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_producto);
        if(!mysqli_stmt_execute($stmt)){
            $exito = false;
        }
    }

    if($exito){
        header("Location: carrito.php");
    } else {
        echo "Error al agregar al carrito: ".mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

} else {
    header("Location: /index.php");
}
?>