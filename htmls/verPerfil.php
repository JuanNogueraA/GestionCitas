<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadatos y enlaces a hojas de estilo -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="HojasEstilo/Administrador.css">
    <link rel="stylesheet" href="HojasEstilo/navigator.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <title>Perfil del Usuario</title>
    <style>
        /* Estilos para el avatar */
        .avatar {
            display: flex;
            justify-content: center;
        }

        .avatar img {
            width: 30px;
            height: 30px;
        }
    </style>
</head>

<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="height: 94px;">
        <div class="container-fluid">
            <a class="navbar-brand" href="">
                <?php 
                // Iniciar sesión y verificar el rol del usuario
                session_start();
                if ($_SESSION['user_rol'] == 'administrador') {
                ?><i class="fas fa-user-shield me-2"></i>
                Administrador
                <?php
                }elseif ($_SESSION['user_rol'] == 'medico') {
                ?><i class="fas fa-user-md me-2"></i>
                Portal Médico
                <?php
                }elseif ($_SESSION['user_rol'] == 'paciente') {
                ?><i class="fas fa-user-injured me-2"></i>
                Portal Paciente
                <?php
                }
                ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <?php
                    
                    if (isset($_SESSION['user_rol'])) {
                        // Mostrar opciones de navegación según el rol del usuario
                        if ($_SESSION['user_rol'] == 'administrador') {
                            echo '<li class="nav-item"><a class="nav-link" href="Administrador.php"><i class="fas fa-home me-2"></i>Home</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="GestionUsuario.php"><i class="fas fa-users me-2"></i>Gestionar Usuarios</a></a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="GestionCitas.html"><i class="fas fa-calendar-alt me-2"></i>Gestionar Citas</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="GestionDisponibilidad.html"><i class="fas fa-clock me-2"></i>Gestionar Disponibilidad</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="GestionRoles.html"><i class="fas fa-user-tag me-2"></i>Gestionar Roles</a></li>';
                        } elseif ($_SESSION['user_rol'] == 'medico') {
                            echo '<li class="nav-item"><a class="nav-link" aria-current="page" href="Medico.html"><i class="fas fa-home me-2"></i>Home</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="GestionCitasUsuario.php"><i class="fas fa-calendar-alt me-2"></i>Visualizar Citas</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="GestionUsuario.php"><i class="fas fa-users me-2"></i>Gestionar Pacientes</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="Agenda.html"><i class="fas fa-calendar me-2"></i>Agenda</a></li>';
                        } elseif ($_SESSION['user_rol'] == 'paciente') {
                            echo '<li class="nav-item"><a class="nav-link active" aria-current="page" href="PacienteInicio.html">Home</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="Citas.php">Citas</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="GestionCitasUsuario.php">Gestionar Citas</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="Calendario.html">Calendario</a></li>';
                        }
                    }
                    ?>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="avatar">
                                <img src="https://static.vecteezy.com/system/resources/previews/005/005/840/non_2x/user-icon-in-trendy-flat-style-isolated-on-grey-background-user-symbol-for-your-web-site-design-logo-app-ui-illustration-eps10-free-vector.jpg"
                                    alt="User Avatar">
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="verPerfil.php">Ver Perfil</a></li>
                            <li><a class="dropdown-item" href="#" id="logout-link">Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br>
    <div class="container mt-5">
        <h2>Perfil del Usuario</h2>
        <?php
        // Mostrar mensaje de éxito si existe
        if (isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success" role="alert">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']);
        }
        ?>
        <div class="card" style="margin-top: 40px;">
            <div class="card-body">
                <h5 class="card-title">Nombre:
                    <?php echo isset($_SESSION['user_nombres']) ? $_SESSION['user_nombres'] : 'N/A'; ?>
                </h5>
                <p class="card-text">Apellidos:
                    <?php echo isset( $_SESSION['user_apellidos']) ?  $_SESSION['user_apellidos'] : 'N/A'; ?>
                </p>
                <p class="card-text">Correo electrónico:
                    <?php echo isset($_SESSION['user_correo']) ? $_SESSION['user_correo'] : 'N/A'; ?>
                </p>
                <p class="card-text">Teléfono:
                    <?php echo isset($_SESSION['user_telefono']) ? $_SESSION['user_telefono'] : 'N/A'; ?>
                </p>
                <a href="editarPerfil.php" class="btn btn-primary">Editar Perfil</a>
            </div>
        </div>
    </div>
    <footer class="footer text-center text-lg-start">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Gestionar Citas</h5>
                    <p>
                        Aquí puedes gestionar las citas de los pacientes de manera fácil y rápida.
                    </p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Enlaces</h5>
                    <ul class="list-unstyled mb-0">
                    <?php
                    if ($_SESSION['user_rol'] == 'administrador') {
                        echo '<li class="mb-2">
                                <a href="Administrador.php" class="text-dark">
                                    <i class="fas fa-home me-2"></i>Inicio
                                </a>
                            </li>';
                        echo '<li class="mb-2">
                                <a href="GestionUsuario.php" class="text-dark">
                                    <i class="fas fa-users me-2"></i>Usuarios
                                </a>
                            </li>';
                        echo '<li class="mb-2">
                                <a href="GestionCitas.html" class="text-dark">
                                    <i class="fas fa-calendar-alt me-2"></i>Citas
                                </a>
                            </li>';
                        echo '<li class="mb-2">
                                <a href="GestionDisponibilidad.html" class="text-dark">
                                    <i class="fas fa-clock me-2"></i>Disponibilidad
                                </a>
                            </li>';
                        echo '<li class="mb-2"><a href="GestionRoles.html" class="text-dark"><i class="fas fa-user-tag me-2"></i>Roles</a></li>';
                    } else if ($_SESSION['user_rol'] == 'medico') {
                        echo '<li><a class="text-dark" href="Medico.html"><i class="fas fa-home me-2"></i>Home</a></li>';
                        echo '<li><a class="text-dark" href="GestionCitasUsuario.php"><i class="fas fa-calendar-alt me-2"></i>Visualizar Citas</a></li>';
                        echo '<li><a class="text-dark" href="GestionUsuario.php"><i class="fas fa-users me-2"></i>Gestionar Pacientes</a></li>';
                        echo '<li><a class="text-dark" href="Agenda.html"><i class="fas fa-calendar me-2"></i>Agenda</a></li>';
                    }else if($_SESSION['user_rol'] == 'paciente'){
                        echo '<li><a class="text-dark" href="PacienteInicio.html"><i class="fas fa-home me-2"></i>Home</a></li>';
                        echo '<li><a class="text-dark" href="Citas.php"><i class="fas fa-calendar-alt me-2"></i>Citas</a></li>';
                        echo '<li><a class="text-dark" href="GestionCitasUsuario.php"><i class="fas fa-calendar-check me-2"></i>Gestionar Citas</a></li>';
                        echo '<li><a class="text-dark" href="Calendario.html"><i class="fas fa-calendar me-2"></i>Calendario</a></li>';
                    }
                    ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2024 Gestionar Citas. Todos los derechos reservados.
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script>
        // Manejar el evento de cierre de sesión
        document.getElementById('logout-link').addEventListener('click', function (event) {
            event.preventDefault();
            if (confirm('¿Desea salir de la sesión?')) {
                fetch('logout.php', {
                    method: 'POST'
                }).then(() => {
                    window.location.href = 'iniciarsesion.php';
                });
            }
        });
    </script>
</body>

</html>