<?php 
// Iniciar la sesión para mantener la información del usuario
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Metadatos para configuración de caracteres y diseño responsivo -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Enlace a hojas de estilo de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Enlace a hojas de estilo de Font Awesome para íconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Hojas de estilo personalizadas -->
    <link rel="stylesheet" href="HojasEstilo/Administrador.css">
    <link rel="stylesheet" href="HojasEstilo/navigator.css">
    
    
    <!-- Estilos en línea para el avatar -->
    <style>
        
    /* Contenedor del avatar centrado */
    .avatar {
        display: flex;
        justify-content: center;
    }
    /* Estilos para la imagen del avatar */
    .avatar img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
    }</style>
    
    <title>Gestionar Citas</title>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
        <?php
            // Generar menú de navegación basado en el rol del usuario
            
            if ($_SESSION['user_rol'] == 'paciente') {
                echo '<a class="navbar-brand" href=""><i class="fas fa-user-injured me-2"></i>Portal Paciente</a>';
            } else if ($_SESSION['user_rol'] == 'medico') {
                echo '<a class="navbar-brand" href=""><i class="fas fa-user-md me-2"></i>Portal Médico</a>';
            } 
            ?>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Menú de navegación dinámico según el rol del usuario -->
                <ul class="navbar-nav">
                    <?php
                    // Generar menú de navegación basado en el rol del usuario
                    if ($_SESSION['user_rol'] == 'paciente') {
                        echo '<li class="nav-item"><a class="nav-link" aria-current="page" href="PacienteInicio.html"><i class="fas fa-home me-2"></i>Home</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="Citas.php"><i class="fas fa-calendar-alt me-2"></i>Citas</a></li>';
                        echo '<li class="nav-item"><a class="nav-link active" href="GestionCitasUsuario.php"><i class="fas fa-calendar-check me-2"></i>Gestionar Citas</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="Calendario.html"><i class="fas fa-calendar me-2"></i>Calendario</a></li>';
                    } else if ($_SESSION['user_rol'] == 'medico') {
                        echo '<li class="nav-item"><a class="nav-link" aria-current="page" href="Medico.html"><i class="fas fa-home me-2"></i>Home</a></li>';
                        echo '<li class="nav-item"><a class="nav-link active" href="GestionCitasUsuario.php"><i class="fas fa-calendar-alt me-2"></i>Visualizar Citas</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="GestionUsuario.php"><i class="fas fa-users me-2"></i>Gestionar Pacientes</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="Agenda.html"><i class="fas fa-calendar me-2"></i>Agenda</a></li>';
                    } 
                    ?>
                </ul>
                
                <!-- Menú de avatar y opciones de usuario -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="avatar">
                                <img src="https://static.vecteezy.com/system/resources/previews/005/005/840/non_2x/user-icon-in-trendy-flat-style-isolated-on-grey-background-user-symbol-for-your-web-site-design-logo-app-ui-illustration-eps10-free-vector.jpg" alt="Avatar de Usuario">
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
    
    <!-- Contenedor principal para gestión de citas -->
    <div class="container mt-5">
        <h2>Gestionar Citas</h2>
        <!-- Formulario de búsqueda de citas -->
        <form id="citaSearch">
            <button type="button" class="btn btn-primary" id="searchButton">Visualizar Citas</button>
        </form>
        <!-- Contenedor para mostrar la lista de citas -->
        <div id="citasList" class="mt-4"></div>
    </div>
    
    <!-- Pie de página -->
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
                            if ($_SESSION['user_rol'] == 'paciente') {
                            echo '<li><a class="text-dark" active" aria-current="page" href="PacienteInicio.html"><i class="fas fa-home me-2"></i>Home</a></li>';
                            echo '<li><a class="text-dark" href="Citas.php"><i class="fas fa-calendar-alt me-2"></i>Citas</a></li>';
                            echo '<li><a class="text-dark" href="GestionCitasUsuario.php"><i class="fas fa-calendar-check me-2"></i>Gestionar Citas</a></li>';
                            echo '<li><a class="text-dark" href="Calendario.html"><i class="fas fa-calendar me-2"></i>Calendario</a></li>';
                        } else if ($_SESSION['user_rol'] == 'medico') {
                            echo '<li><a class="text-dark" active" aria-current="page" href="Medico.html"><i class="fas fa-home me-2"></i>Home</a></li>';
                            echo '<li><a class="text-dark" href="GestionCitasUsuario.php"><i class="fas fa-calendar-alt me-2"></i>Visualizar Citas</a></li>';
                            echo '<li><a class="text-dark" href="GestionUsuario.php"><i class="fas fa-users me-2"></i>Gestionar Pacientes</a></li>';
                            echo '<li><a class="text-dark" href="Agenda.html"><i class="fas fa-calendar me-2"></i>Agenda</a></li>';
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

    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <script>
        // Evento para buscar citas al hacer clic en el botón
        document.getElementById('searchButton').addEventListener('click', function(event) {
            // Obtener el ID del usuario de la sesión actual
            const id = <?php echo $_SESSION['user_id']; ?>;
            try {
                // Realizar una solicitud fetch para obtener las citas
                fetch('getCitas.php?id=' + encodeURIComponent(id))
                    .then(response => response.json())
                    .then(data => {
                        const citasList = document.getElementById('citasList');
                        citasList.innerHTML = '';
                        if (data.length > 0) {
                            // Crear tarjetas para cada cita
                            data.forEach(cita => {
                                const citaItem = document.createElement('div');
                                citaItem.className = 'card mb-3';
                                citaItem.innerHTML = `
                                    <div class="card-body">
                                        <h5 class="card-title">Cita ID: ${cita.id_cita}</h5>
                                        <p class="card-text">Fecha: ${cita.fecha}</p>
                                        <p class="card-text">Hora: ${cita.hora}</p>
                                        <p class="card-text">Médico: ${cita.medico}</p>
                                        <p class="card-text">Consultorio: ${cita.num_consultorio}</p>
                                        <?php if ($_SESSION['user_rol'] === 'paciente' || $_SESSION['user_rol'] === 'administrador') {
                                        ?> 
                                        <button class="btn btn-primary modify-btn" data-cita-id="${cita.id_cita}">Modificar cita</button>
                                        <button class="btn btn-primary cancel-btn" data-cita-id="${cita.id_cita}">Cancelar cita</button>
                                        <?php
                                        } ?>
                                    </div>
                                `;
                                
                                citasList.appendChild(citaItem);
                            });

                            // Agregar eventos para modificar citas
                            document.querySelectorAll('.modify-btn').forEach(button => {
                                button.addEventListener('click', function (event) {
                                    const citaId = this.getAttribute('data-cita-id');
                                    window.location.href = 'modifyAppointment.php?id_cita=' + encodeURIComponent(citaId);
                                });
                            });

                            // Agregar eventos para cancelar citas
                            document.querySelectorAll('.cancel-btn').forEach(button => {
                                button.addEventListener('click', function (event) {
                                    const citaId = this.getAttribute('data-cita-id');
                                    const estado = 'cancelada';
                                    window.location.href = 'modifyAppointment.php?id_cita=' + encodeURIComponent(citaId) + 
                                    '&estado=' + encodeURIComponent(estado);
                                });
                            });
                        } else {
                            // Mensaje si no hay citas
                            citasList.innerHTML = '<p>No se encontraron citas para este paciente.</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Error al obtener las citas:', error);
                        alert('Error al obtener las citas. Por favor, inténtelo de nuevo más tarde.');
                    });
            } catch (error) {
                console.error('Error:', error);
                alert('Ocurrió un error inesperado. Por favor, inténtelo de nuevo más tarde.');
            }
        });

        // Evento para cerrar sesión
        document.getElementById('logout-link').addEventListener('click', function(event) {
            event.preventDefault();
            if (confirm('¿Desea salir de la sesión?')) {
                try {
                    // Solicitud fetch para cerrar sesión
                    fetch('logout.php', {
                        method: 'POST'
                    }).then(() => {
                        // Redirigir a la página de inicio de sesión
                        window.location.href = 'iniciarsesion.php';
                    }).catch(error => {
                        console.error('Error al cerrar sesión:', error);
                        alert('Error al cerrar sesión. Por favor, inténtelo de nuevo más tarde.');
                    });
                } catch (error) {
                    console.error('Error:', error);
                    alert('Ocurrió un error inesperado. Por favor, inténtelo de nuevo más tarde.');
                }
            }
        });

        // Evento para crear cita (si existe el botón)
        const createButton = document.getElementById('createButton');
        if (createButton) {
            createButton.addEventListener('click', function () {
                const id = document.getElementById('id').value;
                window.location.href = 'crearCita.html?id=' + encodeURIComponent(id);
            });
        }
        
        // Función para obtener parámetros de la URL
        function getQueryParams() {
            const params = {};
            const queryString = window.location.search.substring(1);
            const regex = /([^&=]+)=([^&]*)/g;
            let m;
            while (m = regex.exec(queryString)) {
                params[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
            }
            return params;
        }

        // Obtener parámetros de la URL y mostrar mensajes si existen
        const params = getQueryParams();
        if (params['mensaje']) {
            alert(params['mensaje']);
        }
    </script>
</body>
</html>