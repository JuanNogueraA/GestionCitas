<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locations</title>
    <link rel="stylesheet" href="HojasEstilo/index.css">
</head>
<body>
    <!-- Encabezado -->
    <header class="header">
        <div class="logo">
            <h1>Clinica General Mata Sanos</h1>
        </div>
        <nav class="nav-links">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="iniciarsesion.html">Iniciar sesion</a></li>
            </ul>
        </nav>
        <h1>Locations Page</h1>
    </header>
    <!-- Banner -->
    <section class="banner">
        <div class="banner-text">
            <h2>Te enseñamos cómo es el proceso de solicitud de clave para ingresar a Servicios a un clic.</h2>
            <button class="learn-more">Aprende aquí</button>
        </div>
    </section>

    <!-- Contenido principal -->
     <!-- Contenedor del pop-up -->
    <div id="miModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Registro exitoso</h2>
            <p>Su registro ha sido completado con éxito</p>
            <button onclick="closeModal()">Aceptar</button>
        </div>
    </div>
    <main class="main-content">
        <h2>¡Hemos mejorado la experiencia pensando en ti!</h2>
        <p>Ahora vas a poder acceder a todos tus Servicios a un clic en tu nuevo sitio...</p>
        <!-- Más contenido aquí -->
    </main>
    <script>
        function redirectToRegister() {
            window.location.href = "registro.html"; // Cambia "registro.html" a la URL de tu página de registro
        }
        // Función para abrir el pop-up
        function openModal() {
            document.getElementById("miModal").style.display = "flex";
        }

        // Función para cerrar el pop-up
        function closeModal() {
            document.getElementById("miModal").style.display = "none";
        }
        //Función para comprobar el registro exitoso
        function checkRegistration() {
            const params = new URLSearchParams(window.location.search);
            if (params.get("registro") === "exitoso") {
                openModal();
            }
        }
         // Ejecutar la función al cargar la página
         window.onload = checkRegistration;
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