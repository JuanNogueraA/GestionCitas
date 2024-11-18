<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Perfil del Administrador</title>
    <style>
        /* Add custom styles here */
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Gestionar Citas</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="Administrador.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="GestionPacientes.html">Gestionar Pacientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="GestionDisponibilidad.html">Gestionar Disponibilidad</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="GestionRoles.html">Gestionar roles</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Administrador
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="verPerfil.html">Ver Perfil</a></li>
                            <li><a class="dropdown-item" href="#" id="logout-link">Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br>
    <div class="container">
        <h1>Perfil del Administrador</h1>
        <div class="card">
            <div class="card-body">
                <?php 
                session_start();
                ?>
                <h5 class="card-title">Nombre: <?php echo isset($_SESSION['user_nombres']) ? $_SESSION['user_nombres'] : 'N/A'; ?></h5>
                <p class="card-text">Correo electrónico: <?php echo isset($_SESSION['user_correo']) ? $_SESSION['user_correo'] : 'N/A'; ?></p>
                <p class="card-text">Teléfono: <?php echo isset($_SESSION['user_telefono']) ? $_SESSION['user_telefono'] : 'N/A'; ?></p>
                <a href="editarPerfil.php" class="btn btn-primary">Editar Perfil</a>
            </div>
        </div>
    </div>
    <footer class="bg-light text-center text-lg-start">
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
                            <a href="AdminInicio.html" class="text-dark">Home</a>
                        </li>
                        <li>
                            <a href="GestionPacientes.html" class="text-dark">Gestionar Pacientes</a>
                        </li>
                        <li>
                            <a href="GestionCitas.html" class="text-dark">Gestionar Citas</a>
                        </li>
                        <li>
                            <a href="GestionDisponibilidad.html" class="text-dark">Gestionar Disponibilidad</a>
                        </li>
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
        document.getElementById('logout-link').addEventListener('click', function(event) {
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