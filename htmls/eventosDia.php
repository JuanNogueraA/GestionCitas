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
            WHERE c.id_medico = ? AND c.fecha = ? AND c.estado != 'cancelada'";
} else { // Si el usuario es un paciente
    $sql = "SELECT c.id_cita AS id, c.especialidad AS title, c.fecha, c.hora, m.id AS medico_id, m.nombres AS medico_nombre, c.num_consultorio AS consultorio
            FROM cita c
            JOIN usuario m ON c.id_medico = m.id
            WHERE c.id_paciente = ? AND c.fecha = ? AND c.estado != 'cancelada'";
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
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="HojasEstilo/Administrador.css">
        <link rel="stylesheet" href="HojasEstilo/navigator.css">
    <title>Eventos del Día</title>
</head>

<body>

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
        <button type="button" style="margin-right: 400px; margin-top: 20px;" class="btn btn-primary" id="regresarButton">Regresar</button>
    </div>
    
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
            © 2024 Citas. Todos los derechos reservados.
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script>
        // Manejar el evento de cierre de sesión
        document.addEventListener('DOMContentLoaded', function () {
        // Manejar el evento de regresar
        document.getElementById('regresarButton').addEventListener('click', function () {
            if('<?php echo $userRole; ?>' == 'medico')
                window.location.href = 'Agenda.html';
            else{
                window.location.href = 'Calendario.html';
            }
        });
        });
        
    </script>
</body>

</html>