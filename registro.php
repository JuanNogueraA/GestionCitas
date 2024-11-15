<?php
    $server = "localhost";
    $user = "root";
    $pass = "";
    $db = "gestiondecitas";
    $conexion = new mysqli($server, $user, $pass, $db);
    if ($conexion->connect_errno) {
    die("Conexion Fallida" .
    $conexion->connect_errno);
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
    // Consulta SQL
    $consulta = "INSERT INTO usuario(id,nombres, apellidos, contrasena, telefono, correo, direccion)
    VALUES('$id','$nombres','$apellidos', '$contrasena', '$telefono', '$email', '$direccion')";
    try{
        $resultado = mysqli_query($conexion, $consulta);
        try{
            if($resultado){
                echo "registro con éxito";
        }else{
            ?> <h1>registro fallido</h1> <?php
        }
        
        }catch(mysqli_sql_exception $e){
            $error = "Error en el registro";
            echo $error;
        }
    }catch(mysqli_sql_exception $e) {
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