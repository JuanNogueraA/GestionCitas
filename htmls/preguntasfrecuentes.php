<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preguntas Frecuentes - Gestión Citas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos Personalizados -->
    <link rel="stylesheet" href="HojasEstilo/preguntasfrecuentes.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Estilos adicionales para la barra de navegación */
        .navbar {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            color: white !important;
            font-size: 1.5rem;
            transition: transform 0.3s ease;
        }

        .navbar-nav .nav-link {
            color: white !important;
            position: relative;
            font-weight: 500;
            border-radius: 20px;
            padding: 8px 15px;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            background-color: rgba(255,255,255,0.2);
            transform: translateY(-3px);
        }

        /* Estilo para el banner de preguntas frecuentes */
        .faq-banner {
            background: linear-gradient(135deg, rgba(59,130,246,0.8), rgba(99,102,241,0.8)), 
                        url('https://img.freepik.com/vector-premium/fondo-preguntas-frecuentes-diseno-plano_23-2148763178.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 4rem 0;
            text-align: center;
            margin-bottom: 2rem;
        }

        .faq-banner h1 {
            font-size: 3rem;
            font-weight: 700;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .faq-banner p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 1rem auto;
            color: rgba(255,255,255,0.9);
        }

        /* Estilos para los iconos de preguntas */
        .accordion-button {
            display: flex;
            align-items: center;
            color: #333 !important;
            font-weight: 600;
        }
        .accordion-button i {
            margin-right: 15px;
            color: var(--primary-color);
            font-size: 1.5rem;
        }
        .accordion-button:not(.collapsed) i {
            color: white;
        }
    </style>
</head>

<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark">
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

    <!-- Banner de Preguntas Frecuentes -->
    <div class="faq-banner">
        <div class="container">
            <h1>Preguntas Frecuentes</h1>
            <p>Encuentra respuestas rápidas a las consultas más comunes sobre nuestro sistema de gestión de citas médicas.</p>
        </div>
    </div>

    <!-- Sección de Preguntas Frecuentes -->
    <div class="container py-5">
        <h1 class="text-center mb-4">Preguntas Frecuentes</h1>
        <div class="accordion" id="faqAccordion">
            <!-- Pregunta 1: Registro -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        <i class="fas fa-user-plus"></i> ¿Cómo puedo registrarme en el sistema?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Para registrarte, haz clic en el botón "Registrar" en la parte superior y llena el formulario
                        con tus datos personales. Es un proceso simple y rápido.
                    </div>
                </div>
            </div>

            <!-- Pregunta 2: Agendar Cita -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <i class="fas fa-calendar-check"></i> ¿Cómo puedo agendar una cita?
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

            <!-- Pregunta 3: Cancelar/Reprogramar Cita -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <i class="fas fa-calendar-times"></i> ¿Puedo cancelar o reprogramar una cita?
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

            <!-- Pregunta 4: Soporte Técnico -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        <i class="fas fa-headset"></i> ¿Cómo puedo contactar al soporte técnico?
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

            <!-- Pregunta 5: Seguridad de Información -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        <i class="fas fa-lock"></i> ¿Es seguro mi información personal en el sistema?
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

            <!-- Pregunta 6: Cambiar Contraseña -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSix">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                        <i class="fas fa-key"></i> ¿Cómo puedo cambiar mi contraseña?
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

            <!-- Pregunta 7: Olvidar Contraseña -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSeven">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                        <i class="fas fa-question-circle"></i> ¿Qué debo hacer si olvido mi contraseña?
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

            <!-- Pregunta 8: Historial Médico -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingEight">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                        <i class="fas fa-notes-medical"></i> ¿Puedo acceder a mi historial médico en el sistema?
                    </button>
                </h2>
                <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Sí, puedes acceder a tu historial médico desde tu perfil, en la sección "Historial Médico".
                    </div>
                </div>
            </div>

            <!-- Pregunta 9: Actualizar Datos -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingNine">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                        <i class="fas fa-user-edit"></i> ¿Cómo actualizo mis datos personales?
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

            <!-- Pregunta 10: Costo del Servicio -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTen">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                        <i class="fas fa-money-bill-wave"></i> ¿El servicio tiene algún costo?
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</body>

</html>