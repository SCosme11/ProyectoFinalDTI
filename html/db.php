<?php
   $servidor = "db";
   $usuario = "root";
   $password = "root_password";
   $basedatos = "tienda";
   
   $conn = mysqli_connect($servidor, $usuario, $password, $basedatos);

   if(!$conn) {
    die("Conexión fallida: ".mysqli_connect_error());
   }
?>
