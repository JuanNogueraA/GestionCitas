<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <!-- Enlace a la hoja de estilos -->
    <link rel="stylesheet" href="HojasEstilo/registro.css">
</head>
<body>
    <!-- Contenedor principal -->
    <div class="container forgotpassword">
        <h2>Recuperar Contraseña</h2>
        <!-- Formulario para recuperar la contraseña -->
        <form action="forgotpassword.php" method="post">
            <label for="id">Digite su id de usuario:</label>
            <input type="text" id="id" name="id" required>
            <button type="submit">Enviar</button>
        </form>
    </div>
    <!-- Enlace para volver a la página de inicio de sesión -->
    <a href="iniciarsesion.php" class="back-button">← Volver</a>

    <!-- Modal para mostrar mensajes -->
    <div id="messageModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle"></h2>
            <p id="modalMessage"></p>
            <button onclick="closeModal()">Aceptar</button>
        </div>
    </div>

    <script>
        // Función para abrir el modal con un título y mensaje específico
        function openModal(title, message) {
            document.getElementById("modalTitle").innerText = title;
            document.getElementById("modalMessage").innerText = message;
            document.getElementById("messageModal").style.display = "flex";
        }
        // Función para cerrar el modal
        function closeModal() {
            document.getElementById("messageModal").style.display = "none";
        }
        // Cerrar el modal si el usuario hace clic fuera de él
        window.onclick = function(event) {
            var modal = document.getElementById("messageModal");
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
    <div class="message">
    <?php
    // Verificar si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        // Incluir el archivo DataBase.php
        require_once 'DataBase.php';

        // Obtener la instancia de la conexión
        $conn = DataBase::getInstance()->getConnection();

        // Consulta a la base de datos
        $sql = "SELECT contrasena as password FROM usuario WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->store_result();
        // Verificar si se encontró un resultado
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($password);
            $stmt->fetch(); 
            echo "<script>openModal('Contraseña Recuperada', 'Su contraseña es: $password');</script>";
        } else {
            echo "<script>openModal('Error', 'El id de usuario es incorrecto');</script>";
        }
        // Cerrar la consulta y la conexión
        $stmt->close();
        $conn->close();
    }
    ?>
    </div>    

    <!-- ...existing code... -->
</body>
</html>
