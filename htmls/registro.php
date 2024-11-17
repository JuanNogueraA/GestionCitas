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
    $rol = "usuario"; // Nuevo campo de rol
    // Consulta SQL
    $consulta = "INSERT INTO usuario(id, nombres, apellidos, contrasena, telefono, correo, direccion, f_nacimiento, rol)
    VALUES('$id', '$nombres', '$apellidos', '$contrasena', '$telefono', '$email', '$direccion', '$fecha_nacimiento', '$rol')";
    
    try {
        $resultado = mysqli_query($conexion, $consulta);
        if ($resultado) {
            echo "registro con éxito";
            header("Location: index.php?registro=exitoso");
            exit();
        } else {
            header("Location: registro1.php?error=Registro fallido");
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        // Manejar error de entrada duplicada
        if ($e->getCode() === 1062) {
            $error = "Error: El id ya está registrado. Por favor, use uno diferente.";
            header("Location: registro1.php?error=" . urlencode($error));
            exit();
        } else {
            // Manejar otros errores de MySQLi
            $error = "Error al registrar el usuario: " . $e->getMessage();
            header("Location: registro1.php?error=" . urlencode($error));
            exit();
        }
    }
?>