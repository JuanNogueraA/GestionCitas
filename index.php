<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locations</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    color: #333;
}

/* Estilos del encabezado */
.header {
    background-color: #0078D4;
    color: #fff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
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
.logo h1 {
    font-size: 1.5em;
}

.nav-links a {
    color: #fff;
    margin: 0 10px;
    text-decoration: none;
}

.login-button {
    background-color: #005A9E;
    color: #fff;
    padding: 8px 15px;
    border: none;
    cursor: pointer;
}

.login-button:hover {
    background-color: #004080;
}

/* Banner */
.banner {
    background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQSNciM97pw8zXmKxO_9xGJvhFNZe6-ZscWIQ&s'); /* Cambia a tu imagen */
    background-size: cover;
    background-position: center;
    color: white;
    text-align: center;
    padding: 50px 20px;
}

.banner-text h2 {
    font-size: 1.8em;
    margin-bottom: 15px;
}

.learn-more {
    background-color: #FFD700;
    color: #333;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
}

/* Contenido principal */
.main-content {
    padding: 20px;
    text-align: center;
}

.main-content h2 {
    font-size: 1.5em;
    color: #333;
}

.main-content p {
    margin-top: 15px;
    font-size: 1em;
    color: #666;
}
ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}
li {
    display: inline-block;
    margin-right: 20px;
}
    </style>
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