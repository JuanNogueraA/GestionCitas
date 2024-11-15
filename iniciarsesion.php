<?php
session_start();
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
    $contrasena = $_POST["contrasena"];

    $consulta = "SELECT * FROM usuario WHERE id = '$id' AND contrasena = '$contrasena'";;
    try{
        $resultado = mysqli_query($conexion, $consulta);
        try{
            if($resultado){
                if($resultado->num_rows > 0){
                    $user = $resultado->fetch_assoc();
                    // Agrega esta línea para ver todos los datos recuperados
                    var_dump($user); // Eliminar esta línea una vez confirmado el contenido

                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_email'] = $user['email'];
                    $_SESSION['user_nombres'] = $user['nombres'];
                    $_SESSION['user_apellidos'] = $user['apellidos'];
                    $_SESSION['user_direccion'] = $user['direccion'];
                    header("Location: Calendario.html");
                    exit();
                }else{
                    echo "Id o Contraseña incorrectos";
                }
                
        }else{
            ?> <h1>Inicio de sesión fallido</h1> <?php
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