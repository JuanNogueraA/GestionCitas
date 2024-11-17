<?php
    require_once 'Database.php'; // Asegúrate de ajustar la ruta a Database.php

    // Obtener la instancia de la conexión
    $conexion = Database::getInstance()->getConnection();

    if ($conexion->connect_errno) {
        die("Conexion Fallida" . $conexion->connect_errno);
    } 
    // Inicializar la variable de error
    $error = "";
    
    $id = $_POST["id"];
    $nombres = $_POST["nombres"];
    $apellidos = $_POST["apellidos"];
    $contrasena = $_POST["contrasena"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $direccion = $_POST["direccion"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"]; // Nuevo campo de fecha
    
    // Consulta SQL
    $consulta = "INSERT INTO usuario(id,nombres, apellidos, contrasena, telefono, correo, direccion, f_nacimiento)
    VALUES('$id','$nombres','$apellidos', '$contrasena', '$telefono', '$email', '$direccion', '$fecha_nacimiento')";
    // Consulta adicional
    $consulta2 = "INSERT INTO usuario(rol)
    VALUES('usuario')";
    try {
        $resultado = mysqli_query($conexion, $consulta);
        try {
            if ($resultado) {
                echo "registro con éxito";
                header("Location: index.php?registro=exitoso");
                exit();
            } else {
                ?> <h1>registro fallido</h1> <?php
            }
        } catch (mysqli_sql_exception $e) {
            $error = "Error en el registro";
            echo $error;
        }
    } catch (mysqli_sql_exception $e) {
        // Manejar error de entrada duplicada
        if ($e->getCode() === 1062) {
            $error = "Error: El id ya está registrado. Por favor, use uno diferente.";
            echo $error;
        } else {
            // Manejar otros errores de MySQLi
            $error = "Error al registrar el usuario: " . $e->getMessage();
            echo $error;
        }
    }
?>