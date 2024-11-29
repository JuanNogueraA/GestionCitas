<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head> 
    
    <?php $titulo = '' ; // Variable para el título de la página
        if ($_SESSION['user_rol'] == 'medico') { // Verificar el rol del usuario
            $tituloactive = 'Portal Médico'; // Título de la página
            $titulo = 'Gestionar Pacientes'; // Título de la página
            $icono = "fas fa-user-md me-2"; // Icono para el título
        } else {
            $tituloactive = 'Administrador'; // Título de la página
            $titulo = 'Gestionar Usuarios'; // Título de la página
            $icono = "fas fa-user-shield me-2"; // Icono para el título
        }
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="HojasEstilo/Administrador.css">
        <link rel="stylesheet" href="HojasEstilo/navigator.css">

    <title>
        <?php
        echo $titulo;
        ?>
    </title>
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
        }
    </style>
</head>

<body>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" id="titulo" href="#">
            <i class="<?php echo $icono ?>"></i><?php echo $tituloactive ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <?php
                    if ($_SESSION['user_rol'] == 'administrador') {
                        echo '<li class="nav-item"><a class="nav-link" href="Administrador.php"><i class="fas fa-home me-2"></i>Home</a></li>';
                        echo '<li class="nav-item"><a class="nav-link active" href="GestionUsuario.php"><i class="fas fa-users me-2"></i>Gestionar Usuarios</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="GestionCitas.html"><i class="fas fa-calendar-alt me-2"></i>Gestionar Citas</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="GestionDisponibilidad.html"><i class="fas fa-clock me-2"></i>Gestionar Disponibilidad</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="GestionRoles.html"><i class="fas fa-user-tag me-2"></i>Gestionar Roles</a></li>';
                    } else if ($_SESSION['user_rol'] == 'medico') {
                        echo '<li class="nav-item"><a class="nav-link" aria-current="page" href="Medico.html"><i class="fas fa-home me-2"></i>Home</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="GestionCitasUsuario.php"><i class="fas fa-calendar-alt me-2"></i>Visualizar Citas</a></li>';
                        echo '<li class="nav-item"><a class="nav-link active" href="GestionUsuario.php"><i class="fas fa-users me-2"></i>Gestionar Pacientes</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="Agenda.html"><i class="fas fa-calendar me-2"></i>Agenda</a></li>';
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
    <div class="container mt-5">
        <h2>
        <?php echo $titulo ?>

        </h2>
        <form id="searchUserForm">
            <div class="mb-3">
                <label for="id" class="form-label">Buscar Usuario</label>
                <input type="text" class="form-control" id="id" placeholder="Ingrese el ID de usuario">
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
        
        <div class="card mb-4" id="cardUser" style="display: none; max-width: 600px; margin-left: 0px;">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4" id="imagenPaciente" style="display: none; margin-top: 30px;">
                        <img src="https://cdn-icons-png.flaticon.com/512/1430/1430402.png" alt="Logo" class="img-fluid">
                    </div>
                    <div class="col-md-4" id="imagenMedico" style="display: none; margin-top: 30px;">
                        <img src="https://e7.pngegg.com/pngimages/494/374/png-clipart-physician-assistant-medicine-clinic-health-care-doctor-logo-medicine.png" alt="Logo" class="img-fluid">
                    </div>
                    <div class="col-md-4" id="imagenAdmin" style="display: none; margin-top: 30px;">
                        <img src="https://cdn-icons-png.flaticon.com/512/2942/2942813.png" alt="Logo" class="img-fluid">
                    </div>
                    <div class="col-md-8">
                        <div id="userDetails" class="mt-4">
                            <h3>Detalles del Usuario</h3>
                            <p><strong>Nombre:</strong> <span id="displayname"></span></p>
                            <p><strong>Apellido:</strong> <span id="lastName"></span></p>
                            <p><strong>Rol:</strong> <span id="roleUser"></span></p>
                            <p><strong>Dirección:</strong> <span id="AddressUser"></span></p>
                            <p><strong>Número:</strong> <span id="userNumber"></span></p>
                            <p><strong>Correo electrónico:</strong> <span id="email"></span></p>
                            <button id="showUpdateFormBtn" class="btn btn-primary mt-3" style="display: none;">Actualizar Usuario</button>
                            <button id="uploadHistoryBtn" class="btn btn-primary mt-3" style="display: none;">Historial Clínico</button>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container mt-5">
            <form id="updateUserForm" style="display: none;">
                <h2>Actualizar Datos del Usuario</h2>
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="name" placeholder="Ingrese el nombre" required>
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">Apellido</label>
                    <input type="text" class="form-control" id="lastname" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Dirección</label>
                    <input type="text" class="form-control" id="address" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Número</label>
                    <input type="text" class="form-control" id="phone" required>
                </div>
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" class="form-control" id="correo" required>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
        </div>
    </div>
    
    <footer class="footer text-center text-lg-start mt-5">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Administrador</h5>
                    <p>
                        Aquí puedes Gestionar Usuarios, citas y disponibilidad de manera fácil y rápida.
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
                    } 

                    ?>

                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2024 Administrador. Todos los derechos reservados.
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

        document.getElementById('searchUserForm').addEventListener('submit', function (event) {
            event.preventDefault();
            const id = document.getElementById('id').value;

            fetch('searchUser.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id=' + encodeURIComponent(id)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById('displayname').innerText = data.user.name;
                        document.getElementById('lastName').innerText = data.user.lastname;
                        document.getElementById('roleUser').innerText = data.user.role;
                        document.getElementById('AddressUser').innerText = data.user.address;
                        document.getElementById('userNumber').innerText = data.user.phone;
                        document.getElementById('email').innerText = data.user.email;
                        document.getElementById('cardUser').style.display = 'block';
                        document.getElementById('imagenPaciente').style.display = 'none';
                        document.getElementById('imagenMedico').style.display = 'none';
                        document.getElementById('imagenAdmin').style.display = 'none';
                        document.getElementById('updateUserForm').style.display = 'none';
                        document.getElementById('showUpdateFormBtn').style.display = 'block';
                        <?php
                        if ($_SESSION['user_rol'] == 'medico') {
                            ?> document.getElementById('showUpdateFormBtn').style.display = 'none'; <?php
                        }
                        ?>
                        if (data.user.role === 'paciente') {
                            document.getElementById('uploadHistoryBtn').style.display = 'block';
                            document.getElementById('imagenPaciente').style.display = 'block';
                        }else if (data.user.role === 'medico') {
                            document.getElementById('imagenMedico').style.display = 'block';
                            document.getElementById('uploadHistoryBtn').style.display = 'none';
                        }else if (data.user.role === 'administrador') {
                            document.getElementById('imagenAdmin').style.display = 'block';
                            document.getElementById('uploadHistoryBtn').style.display = 'none';
                        } 
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        });

        document.getElementById('showUpdateFormBtn').addEventListener('click', function () {
            document.getElementById('name').value = document.getElementById('displayname').innerText;
            document.getElementById('lastname').value = document.getElementById('lastName').innerText;
            document.getElementById('address').value = document.getElementById('AddressUser').innerText;
            document.getElementById('phone').value = document.getElementById('userNumber').innerText;
            document.getElementById('correo').value = document.getElementById('email').innerText;

            document.getElementById('updateUserForm').style.display = 'block';
        });

        document.getElementById('updateUserForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const id = document.getElementById('id').value;
            const name = document.getElementById('name').value;
            const lastname = document.getElementById('lastname').value;
            const address = document.getElementById('address').value;
            const phone = document.getElementById('phone').value;
            const correo = document.getElementById('correo').value;
            const body = `id=${encodeURIComponent(id)}&name=${encodeURIComponent(name)}&lastname=${encodeURIComponent(lastname)}&address=${encodeURIComponent(address)}&phone=${encodeURIComponent(phone)}&correo=${encodeURIComponent(correo)}`;


            fetch('ActualizarUser.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: body
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('displayname').innerText = name;
                    document.getElementById('lastName').innerText = lastname;
                    document.getElementById('AddressUser').innerText = address;
                    document.getElementById('userNumber').innerText = phone;
                    document.getElementById('email').innerText = correo;
                    alert('Datos actualizados correctamente');
                    document.getElementById('updateUserForm').style.display = 'none';
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });

        document.getElementById('uploadHistoryBtn').addEventListener('click', function () {
            const id = document.getElementById('id').value;
            window.location.href = 'subirHistorial.html?id=' + encodeURIComponent(id);
        });
    });
    </script>
</body>

</html>