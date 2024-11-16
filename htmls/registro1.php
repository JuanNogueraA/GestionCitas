<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        /* Estilos para el fondo del pop-up */
        .modal {
            display: none; /* Oculto por defecto */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Fondo oscuro semi-transparente */
            justify-content: center;
            align-items: center;
        }
        
        /* Estilos para el contenido del pop-up */
        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            text-align: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Botón para cerrar el pop-up */
        .close-btn {
            color: #333;
            font-size: 18px;
            cursor: pointer;
            position: absolute;
            top: 10px;
            right: 10px;
            font-weight: bold;
        }
        .container {
            background-color: #fff;
            padding: 20px 40px;
            margin-top: 100px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registro de Usuario</h2>
        <form action="registro.php" method="POST">
            <label for="id">Id:</label>
            <input type="text" id="id" name="id" required>

            <label for="nombres">Nombres:</label>
            <input type="text" id="nombres" name="nombres" required>

            <label for="apellidos">Apellidos:</label>
            <input type="text" id="apellidos" name="apellidos" required>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required>

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" required>

            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>

            <button type="submit">Registrarse</button>
        </form>
    </div>

     <!-- Contenedor del pop-up -->
     <div id="miModal" class="modal">
         <div class="modal-content">
             <span class="close-btn" onclick="closeModal()">&times;</span>
             <h2>Registro exitoso</h2>
             <p>Su registro ha sido completado con éxito</p>
             <button onclick="closeModal()">Aceptar</button>
         </div>
     </div>
     <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <script>
        // Función para abrir el pop-up
        function openModal() {
            document.getElementById("miModal").style.display = "flex";
        }

        // Función para cerrar el pop-up
        function closeModal() {
            document.getElementById("miModal").style.display = "none";
        }

        // Cerrar el pop-up al hacer clic fuera del contenido
        window.onclick = function(event) {
            var modal = document.getElementById("miModal");
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>