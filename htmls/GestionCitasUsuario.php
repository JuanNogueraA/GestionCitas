<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="HojasEstilo/gen.css">
    <link rel="stylesheet" href="HojasEstilo/Administrador.css">
    <style>
    .avatar {
        display: flex;
        justify-content: center;
    }
    /* Estilos para la imagen dentro de .avatar */
    .avatar img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
    }</style>
    <title>Gestionar Citas</title>
    <style>
        /* Add custom styles here */
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Visualizar Citas</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <?php
                if ($_SESSION['user_rol'] == 'paciente') {
                    echo '<li class="nav-item"><a class="nav-link active" aria-current="page" href="PacienteInicio.html">Home</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="Citas.php">Citas</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="GestionCitasUsuario.php">Gestionar Citas</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="Calendario.html">Calendario</a></li>';
                } else if ($_SESSION['user_rol'] == 'medico') {
                    echo '<li class="nav-item"><a class="nav-link active" aria-current="page" href="Medico.html">Home</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="GestionCitasUsuario.php">Visualizar Citas</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="GestionUsuario.html">Gestionar Pacientes</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="Agenda.html">Agenda</a></li>';
                } 
                        ?>
                  </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="avatar">
                                <img src="https://static.vecteezy.com/system/resources/previews/005/005/840/non_2x/user-icon-in-trendy-flat-style-isolated-on-grey-background-user-symbol-for-your-web-site-design-logo-app-ui-illustration-eps10-free-vector.jpg" alt="User Avatar">
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
        <h2>Gestionar Citas</h2>
        <form id="citaSearch">
            <button type="button" class="btn btn-primary" id="searchButton">Ver todas las citas</button>
        </form>
        <div id="citasList" class="mt-4"></div>
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
                        <li>
                            <a href="PacienteInicio.html" class="text-dark">Home</a>
                          </li>
                          <li>
                            <a href="Citas.php" class="text-dark">Citas</a>
                          </li>
                          <li>
                            <a href="Calendario.html" class="text-dark">Calendario</a>
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2023 Gestionar Citas. Todos los derechos reservados.
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        document.getElementById('searchButton').addEventListener('click', function(event) {
            const id = <?php echo $_SESSION['user_id']; ?>;
            try {
                fetch('getCitas.php?id=' + encodeURIComponent(id))
                    .then(response => response.json())
                    .then(data => {
                        const citasList = document.getElementById('citasList');
                        citasList.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(cita => {
                                const citaItem = document.createElement('div');
                                citaItem.className = 'card mb-3';
                                citaItem.innerHTML = `
                                    <div class="card-body">
                                        <h5 class="card-title">Cita ID: ${cita.id_cita}</h5>
                                        <p class="card-text">Fecha: ${cita.fecha}</p>
                                        <p class="card-text">Hora: ${cita.hora}</p>
                                        <p class="card-text">Médico: ${cita.medico}</p>
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

                            document.querySelectorAll('.modify-btn').forEach(button => {
                                button.addEventListener('click', function (event) {
                                    const citaId = this.getAttribute('data-cita-id');
                                    window.location.href = 'modifyAppointment.php?id_cita=' + encodeURIComponent(citaId);
                                });
                            });

                            document.querySelectorAll('.cancel-btn').forEach(button => {
                                button.addEventListener('click', function (event) {
                                    const citaId = this.getAttribute('data-cita-id');
                                    const estado = 'cancelada';
                                    window.location.href = 'modifyAppointment.php?id_cita=' + encodeURIComponent(citaId) + 
                                    '&estado=' + encodeURIComponent(estado);
                                });
                            });
                        } else {
                            citasList.innerHTML = '<p>No se encontraron citas para este paciente.</p>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching citas:', error);
                        alert('Error al obtener las citas. Por favor, inténtelo de nuevo más tarde.');
                    });
            } catch (error) {
                console.error('Error:', error);
                alert('Ocurrió un error inesperado. Por favor, inténtelo de nuevo más tarde.');
            }
        });

        document.getElementById('logout-link').addEventListener('click', function(event) {
            event.preventDefault();
            if (confirm('¿Desea salir de la sesión?')) {
                try {
                    fetch('logout.php', {
                        method: 'POST'
                    }).then(() => {
                        window.location.href = 'iniciarsesion.php';
                    }).catch(error => {
                        console.error('Error logging out:', error);
                        alert('Error logging out. Please try again later.');
                    });
                } catch (error) {
                    console.error('Error:', error);
                    alert('An unexpected error occurred. Please try again later.');
                }
            }
        });

        const createButton = document.getElementById('createButton');
        if (createButton) {
            createButton.addEventListener('click', function () {
                const id = document.getElementById('id').value;
                window.location.href = 'crearCita.html?id=' + encodeURIComponent(id);
            });
        }

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

        // Get the patient ID from the URL
        const params = getQueryParams();
        if (params['mensaje']) {
            alert(params['mensaje']);
        }
    </script>
</body>
</html>