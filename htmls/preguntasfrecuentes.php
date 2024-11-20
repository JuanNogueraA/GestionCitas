<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Preguntas Frecuentes</title>
    <link rel="stylesheet" href="HojasEstilo/preguntasfrecuentes.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- Encabezado -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Gestión Citas</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegación">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="iniciarsesion.php">Iniciar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="registro1.php">Registrar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="preguntasfrecuentes.php">Preguntas Frecuentes</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sección de Preguntas Frecuentes -->
    <div class="container py-5">
        <h1 class="text-center mb-4">Preguntas Frecuentes</h1>
        <div class="accordion" id="faqAccordion">
            <!-- Pregunta 1 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        ¿Cómo puedo registrarme en el sistema?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Para registrarte, haz clic en el botón "Registrar" en la parte superior y llena el formulario
                        con tus datos personales.
                    </div>
                </div>
            </div>
            <!-- Pregunta 2 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        ¿Cómo puedo agendar una cita?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Después de iniciar sesión, ve a la sección de "Agendar Cita" y sigue los pasos para seleccionar
                        el médico y el horario que más te convenga.
                    </div>
                </div>
            </div>
            <!-- Pregunta 3 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        ¿Puedo cancelar o reprogramar una cita?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Sí, puedes cancelar o reprogramar una cita desde la sección "Mis Citas" en tu perfil, siguiendo
                        las instrucciones proporcionadas.
                    </div>
                </div>
            </div>
            <!-- Pregunta 4 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        ¿Cómo puedo contactar al soporte técnico?
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Puedes contactar al soporte técnico enviando un correo electrónico a soporte@gestioncitas.com o
                        llamando al número 123-456-7890.
                    </div>
                </div>
            </div>
            <!-- Pregunta 5 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        ¿Es seguro mi información personal en el sistema?
                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Sí, nos comprometemos a proteger tu privacidad y seguridad. Utilizamos protocolos de seguridad
                        para garantizar que tu información personal esté protegida.
                    </div>
                </div>
            </div>
            <!-- Pregunta 6 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSix">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                        ¿Cómo puedo cambiar mi contraseña?
                    </button>
                </h2>
                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Para cambiar tu contraseña, inicia sesión y ve a "Mi Perfil", luego selecciona "Cambiar
                        Contraseña" y sigue las instrucciones.
                    </div>
                </div>
            </div>
            <!-- Pregunta 7 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSeven">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                        ¿Qué debo hacer si olvido mi contraseña?
                    </button>
                </h2>
                <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        En la página de inicio de sesión, haz clic en "¿Olvidaste tu contraseña?" y sigue los pasos para
                        restablecerla.
                    </div>
                </div>
            </div>
            <!-- Pregunta 8 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingEight">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                        ¿Puedo acceder a mi historial médico en el sistema?
                    </button>
                </h2>
                <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Sí, puedes acceder a tu historial médico desde tu perfil, en la sección "Historial Médico".
                    </div>
                </div>
            </div>
            <!-- Pregunta 9 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingNine">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                        ¿Cómo actualizo mis datos personales?
                    </button>
                </h2>
                <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Para actualizar tus datos, ve a "Mi Perfil" y selecciona "Editar Perfil" para modificar la
                        información necesaria.
                    </div>
                </div>
            </div>
            <!-- Pregunta 10 -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTen">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                        ¿El servicio tiene algún costo?
                    </button>
                </h2>
                <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        No, el uso de nuestra plataforma para agendar citas es completamente gratuito.
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