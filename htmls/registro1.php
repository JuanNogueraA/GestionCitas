<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="HojasEstilo/registro.css"> <!-- Updated CSS file path -->
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
            <input type="hidden" id="error" name="error" value="<?php echo isset($_GET['error']) ? $_GET['error'] : ''; ?>">
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
    <?php if (!empty($_GET['error'])): ?>
        <p style="color: red;"><?php echo $_GET['error']; ?></p>
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