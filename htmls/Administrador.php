<?php
session_start();
require_once 'DataBase.php';

// Verificar si el usuario está logueado como administrador
if (!isset($_SESSION['user_id'])) {
    header('Location: iniciarsesion.php');
    exit();
}

$userId = $_SESSION['user_id'];

$conn = DataBase::getInstance()->getConnection();

$sql = "SELECT avatar FROM usuario WHERE id = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($avatar_path);
    $stmt->fetch();
    $stmt->close();
} else {
    // En caso de error, usa una imagen por defecto
    $avatar_path = 'https://blogs.ucontinental.edu.pe/wp-content/uploads/2022/09/funciones-de-un-administrador-scaled.jpg';
}

$conn->close();

// Si no hay un avatar personalizado, usa la imagen predeterminada
if (empty($avatar_path)) {
    $avatar_path = 'https://blogs.ucontinental.edu.pe/wp-content/uploads/2022/09/funciones-de-un-administrador-scaled.jpg';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Panel de administración para gestión de usuarios, citas y disponibilidad">
    <title>Panel Administrador</title>

    <!-- Hojas de estilo -->
    <link rel="stylesheet" href="HojasEstilo/gen.css">
    <link rel="stylesheet" href="HojasEstilo/Administrador.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid var(--primary-color);
            transition: transform 0.3s;
        }

        .profile-avatar:hover {
            transform: scale(1.05);
        }

        #avatar-input {
            display: none;
        }
    </style>
</head>

<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <!-- Logo y título -->
            <a class="navbar-brand" href="Administrador.php">
                <i class="fas fa-user-shield me-2"></i>
                Administrador
            </a>

            <!-- Botón hamburguesa para móvil -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menú principal -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="Administrador.php">
                            <i class="fas fa-home me-2"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="GestionUsuario.php">
                            <i class="fas fa-users me-2"></i>Gestionar Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="GestionCitas.html">
                            <i class="fas fa-calendar-alt me-2"></i>Gestionar Citas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="GestionDisponibilidad.html">
                            <i class="fas fa-clock me-2"></i>Gestionar Disponibilidad
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="GestionRoles.html">
                            <i class="fas fa-user-tag me-2"></i>Gestionar Roles
                        </a>
                    </li>
                </ul>

                <!-- Menú de usuario -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="avatar">
                                <img src="<?php echo $avatar_path; ?>" alt="Perfil" id="admin-avatar"
                                    style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
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

    <!-- Contenido principal -->
    <main>
        <header class="py-5">
            <div class="container">
                <div class="text-center">
                    <div class="imagenadmin mb-4">
                        <img src="<?php echo $avatar_path; ?>" alt="Imagen de Perfil del Administrador"
                            class="profile-avatar" id="profile-avatar">
                        <input type="file" id="avatar-input" accept="image/*">
                    </div>
                    <h1 class="h3 mb-0">Bienvenido Administrador</h1>
                    <p class="text-muted">Panel de Control</p>
                </div>
            </div>
        </header>

        <!-- Área de contenido dashboard -->
        <div class="container mb-5">
            <div class="row g-4">
                <!-- Aquí puedes agregar widgets o tarjetas de resumen -->
            </div>
        </div>
    </main>

    <!-- Pie de página -->
    <footer class="footer text-center text-lg-start bg-light">
        <div class="container p-4">
            <div class="row">
                <!-- Información del sitio -->
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">
                        <i class="fas fa-user-shield me-2"></i>Panel Administrativo
                    </h5>
                    <p>
                        Sistema integral para la gestión de pacientes, citas y disponibilidad
                        de manera eficiente y organizada.
                    </p>
                </div>

                <!-- Enlaces rápidos -->
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Enlaces Rápidos</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <a href="Administrador.php" class="text-dark">
                                <i class="fas fa-home me-2"></i>Inicio
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="GestionUsuario.php" class="text-dark">
                                <i class="fas fa-users me-2"></i>Usuarios
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="GestionCitas.html" class="text-dark">
                                <i class="fas fa-calendar-alt me-2"></i>Citas
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="GestionDisponibilidad.html" class="text-dark">
                                <i class="fas fa-clock me-2"></i>Disponibilidad
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="text-center p-3 bg-light border-top">
            © 2024 Panel Administrativo. Todos los derechos reservados.
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Manejador de eventos para subir un avatar
        const profileAvatar = document.getElementById('profile-avatar');
        const avatarInput = document.getElementById('avatar-input');

        profileAvatar.addEventListener('click', () => {
            avatarInput.click();
        });
        // Subir el avatar
        avatarInput.addEventListener('change', () => {
            const file = avatarInput.files[0];
            if (file) { // Verificar si se seleccionó un archivo
                const formData = new FormData();
                // Agregar el archivo al formulario
                formData.append('avatar', file);
                // Enviar el archivo al servidor
                fetch('upload_avatar.php', {
                    method: 'POST',
                    body: formData
                })  // Procesar la respuesta del servidor
                    .then(response => response.json())
                    .then(data => { // Mostrar mensaje de éxito o error
                        if (data.status === 'success') {
                            profileAvatar.src = data.avatar_path + '?' + new Date().getTime(); // Evita caché
                            alert('Avatar actualizado correctamente.');
                        } else {
                            alert('Error al subir el avatar: ' + data.message);
                        }
                    }) // Capturar errores de red
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Ocurrió un error al subir el avatar.');
                    });
            }
        });

        // Manejador de cierre de sesión
        document.getElementById('logout-link').addEventListener('click', function (event) {
            event.preventDefault();
            if (confirm('¿Está seguro que desea cerrar la sesión?')) {
                fetch('logout.php', {
                    method: 'POST',
                    credentials: 'same-origin'
                })
                    .then(response => {
                        if (response.ok) {
                            window.location.href = 'iniciarsesion.php';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        });
    </script>
</body>

</html>