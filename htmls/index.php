<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinica General Mata Sanos</title>
    <link rel="stylesheet" href="HojasEstilo/index.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
                <li><a href="iniciarsesion.php">Sign-isn / Sign-up</a></li>
                <li><a href="preguntasfrecuentes.php">Preguntas Frecuentes</a></li>
            </ul>
        </nav>
        <h1>Iniciar Sesión</h1>
    </header>
    <!-- Carrusel -->
    <section id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://static.vecteezy.com/system/resources/previews/010/503/718/non_2x/therapist-examining-old-patient-in-hospital-2d-isolated-illustration-treatment-flat-characters-on-cartoon-background-health-colourful-editable-scene-for-mobile-website-presentation-vector.jpg" class="d-block w-100" alt="Imagen 1">
            </div>
            <div class="carousel-item">
                <img src="https://www.unir.net/wp-content/uploads/2023/01/el-gerente-del-hospital-mostrando-un-documento-al-mC3A9dico-y-al-enfermero-sonriendo-1.jpg_s1024x1024wisk20cRz_RN_tmX8hZnEmx4_I46yqkBQ_hsTmzgEJRyaWzryI-1.jpg" class="d-block w-100" alt="Imagen 2">
            </div>
            <div class="carousel-item">
                <img src="https://static.vecteezy.com/system/resources/previews/010/503/718/non_2x/therapist-examining-old-patient-in-hospital-2d-isolated-illustration-treatment-flat-characters-on-cartoon-background-health-colourful-editable-scene-for-mobile-website-presentation-vector.jpg" class="d-block w-100" alt="Imagen 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Conoces la importancia de atender una cita médica</h5>
                    <button class="btn btn-primary" onclick="window.open('https://www.youtube.com/watch?v=VQJfdDl5CyY', '_blank')">Te contamos</button>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
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
        <!-- Mensaje de espera para asignación de rol -->
        <?php if (isset($_GET['registro']) && $_GET['registro'] === 'exitoso'): ?>
            <div class="role-assignment-message">
                <h3>¡Registro Exitoso!</h3>
                <p>Espere a que un rol se le sea asignado por uno de los administradores para iniciar sesión.</p>
            </div>
        <?php endif; ?>
        <!-- Más contenido aquí -->
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
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