<?php
require_once 'DataBase.php';

session_start();
$userId = $_SESSION['user_id']; // Obtener el ID del usuario desde la sesión
$userRole = $_SESSION['user_rol']; // Obtener el rol del usuario desde la sesión
$date = $_GET['date']; // Obtener la fecha desde la URL

$conn = DataBase::getInstance()->getConnection();
// Consulta para obtener los eventos del día
if ($userRole == 'medico') {
    $sql = "SELECT c.id_cita AS id, c.especialidad AS title, c.fecha, c.hora, p.id AS paciente_id, p.nombres AS paciente_nombre, c.num_consultorio AS consultorio
            FROM cita c
            JOIN usuario p ON c.id_paciente = p.id
            WHERE c.id_medico = ? AND c.fecha = ?";
} else { // Si el usuario es un paciente
    $sql = "SELECT c.id_cita AS id, c.especialidad AS title, c.fecha, c.hora, m.id AS medico_id, m.nombres AS medico_nombre, c.num_consultorio AS consultorio
            FROM cita c
            JOIN usuario m ON c.id_medico = m.id
            WHERE c.id_paciente = ? AND c.fecha = ?";
}
// Preparar la consulta
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}
$stmt->bind_param("is", $userId, $date);
$stmt->execute();
$result = $stmt->get_result(); //   Ejecutar la consulta
// Obtener los eventos del día
$events = [];
// Recorrer los resultados y almacenarlos en un array
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}
// Cerrar la consulta y la conexión
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="HojasEstilo/gen.css">
    <title>Eventos del Día</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Eventos del Día</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                <?php
                // Iniciar sesión y verificar el rol del usuario
                if (isset($_SESSION['user_rol'])) {
                        if ($_SESSION['user_rol'] == 'medico') {
                            echo '<li class="nav-item"><a class="nav-link active" aria-current="page" href="Medico.html">Home</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="Citas.php">Citas</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="Agenda.html">Agenda</a></li>';
                        } elseif ($_SESSION['user_rol'] == 'paciente') {
                            echo '<li class="nav-item"><a class="nav-link active" aria-current="page" href="PacienteInicio.html">Home</a></li>';
                            echo '<li class="nav-item"><a class="nav-link" href="Citas.php">Citas</a></li>';
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
                        <!-- Menú desplegable para el logout de usuario -->
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
        <h2>Eventos para el día: <?php echo $date; ?></h2>
        <?php if (count($events) > 0): ?>
            <ul class="list-group">
                <?php foreach ($events as $event): ?>
                    <li class="list-group-item">
                        <strong><?php echo $event['title']; ?></strong><br>
                        Fecha: <?php echo $event['fecha']; ?><br>
                        Hora: <?php echo $event['hora']; ?><br>
                        <?php if ($userRole == 'medico'): ?>
                            <!-- Mostrar información del paciente -->
                            ID del Paciente: <?php echo $event['paciente_id']; ?><br>
                            Nombre del Paciente: <?php echo $event['paciente_nombre']; ?><br>
                        <?php else: ?>
                            <!-- Mostrar información del médico -->
                            ID del Médico: <?php echo $event['medico_id']; ?><br>
                            Nombre del Médico: <?php echo $event['medico_nombre']; ?><br>
                        <?php endif; ?>
                        Consultorio: <?php echo $event['consultorio']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?> <!-- No hay eventos para el día -->
            <p>No tiene eventos para este día.</p>
        <?php endif; ?>
    </div>
    <button type="button" style="margin-left: 175px;" class="btn btn-primary" id="regresarButton">Regresar</button>
    <footer class="footer text-center text-lg-start mt-5">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Citas</h5>
                    <p>Aquí puedes gestionar todas tus citas de manera fácil y rápida.</p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Enlaces</h5>
                    <ul class="list-unstyled mb-0">
                        <li><a href="PacienteInicio.html" class="text-dark">Home</a></li>
                        <li><a href="Citas.html" class="text-dark">Citas</a></li>
                        <li><a href="Calendario.html" class="text-dark">Calendario</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2023 Citas. Todos los derechos reservados.
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
        // Manejar el evento de regresar
        document.getElementById('regresarButton').addEventListener('click', function () {
            if('<?php echo $userRole; ?>' == 'medico')
                window.location.href = 'Agenda.html';
            else{
                window.location.href = 'Calendario.html';
            }
        });
    </script>
</body>

</html>