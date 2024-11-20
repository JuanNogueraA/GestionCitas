<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Gestión Citas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos Personalizados -->
    <link rel="stylesheet" href="HojasEstilo/index.css">
</head>

<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Gestión Citas</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegación">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="Agenda.html">Agenda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="verPerfil.php">Perfil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="iniciarsesion.php">Iniciar Sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="registro.php">Registrar</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="preguntasfrecuentes.php">Preguntas Frecuentes</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Banner -->
    <section class="banner d-flex align-items-center justify-content-center">
        <div class="banner-text text-center">
            <h2>Bienvenido a Gestión Citas</h2>
            <a href="registro.php" class="btn btn-warning btn-lg button-animated">Regístrate Ahora</a>
        </div>
    </section>

    <!-- Contenido Principal -->
    <main class="main-content container my-5">
        <h2>Nuestros Servicios</h2>
        <p>Ofrecemos una plataforma eficiente para gestionar tus citas médicas de manera sencilla y rápida.
            Accede a tus citas, historial médico y más con solo unos clics.</p>

        <!-- Carousel Automático -->
        <section class="carousel-section my-5">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                        class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="https://www.unir.net/wp-content/uploads/sites/22/2021/10/hospitalinreior3.jpg"
                            class="d-block w-100" alt="Imagen Slider 1">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>¿Conoces la importancia de atender una cita?</h5>
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#videoModal">Te
                                Contamos</button>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="https://mexico.unir.net/wp-content/uploads/sites/6/2019/06/administracion-hospitalaria-unir-mexico.jpg"
                            class="d-block w-100" alt="Imagen Slider 2">
                    </div>
                    <div class="carousel-item">
                        <img src="https://ecuador.unir.net/wp-content/uploads/sites/8/2021/03/male-senior-doctor-briefing-his-team-and-colleagues-picture-id1220810742.jpg"
                            class="d-block w-100" alt="Imagen Slider 3">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
        </section>
    </main>

    <!-- Modal de Video -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoModalLabel">Importancia de Sacar una Cita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/VQJfdDl5CyY?t=2s" title="YouTube video"
                            allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie de página -->
    <footer class="footer bg-primary text-white text-center py-4">
        <p>&copy; 2024 Gestión Citas. Todos los derechos reservados.</p>
        <a href="politica_privacidad.php" class="text-white">Política de Privacidad</a> |
        <a href="terminos_servicio.php" class="text-white">Términos de Servicio</a>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>