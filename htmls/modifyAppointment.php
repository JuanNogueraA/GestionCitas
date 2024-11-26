<?php 
require_once 'DataBase.php'; // Ajusta la ruta según sea necesario

// Obtener la conexión a la base de datos
$conexion = DataBase::getInstance()->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cita = $_POST['id_cita'];
    if (isset($_POST['consultorio'])) {
        $consultorio = $_POST['consultorio'];
        $query = "UPDATE citas SET num_consultorio = ? WHERE id_cita = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('si', $consultorio, $id_cita);
    } else {
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];
        $medico = $_POST['medico'];
        $query = "UPDATE citas SET fecha = ?, hora = ?, medico = ? WHERE id_cita = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('sssi', $fecha, $hora, $medico, $id_cita);
    }

    if ($stmt->execute()) {
        echo "Cita actualizada correctamente.";
    } else {
        echo "Error al actualizar la cita.";
    }
} else if (isset($_GET['id_cita'])) {
    $id_cita = $_GET['id_cita'];
    $query = "SELECT * FROM cita WHERE id_cita = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('i', $id_cita);
    $stmt->execute();
    $result = $stmt->get_result();
    $cita = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Cita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Modificar Cita</h2>
        <button type="button" class="btn btn-primary" style="margin-top: 40px; background-color: #0d6efd;" id="PosponerCita">Posponer cita</button>
        <button type="button" class="btn btn-primary" style="margin-top: 40px;" id="AsignarConsultorio">Asignar consultorio</button>
        <button type="button" class="btn btn-primary" style="margin-top: 40px;" id="EnviarRecordatorio">Enviar recordatorio</button>
        <hr>
        <form method="POST" action="modifyAppointment.php" style="display: none;" id="formConsultorio">
            <input type="hidden" name="id_cita" value="<?php echo $cita['id_cita']; ?>">
            <div class="mb-3">
                <label for="consultorio" class="form-label">Número de consultorio</label>
                <input type="text" class="form-control" id="consultorio" name="consultorio" value="<?php echo $cita['num_consultorio']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>

        <form method="POST" action="modifyAppointment.php" style="display: none;" id="posponercita">
            <input type="hidden" name="id_cita" value="<?php echo $cita['id_cita']; ?>">
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $cita['fecha']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="hora" class="form-label">Hora</label>
                <input type="time" class="form-control" id="hora" name="hora" value="<?php echo $cita['hora']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="medico" class="form-label">Médico</label>
                <input type="text" class="form-control" id="medico" name="medico" value="<?php echo $cita['medico']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>

        <form id="appointmentForm">
            <div class="mb-3">
            <input type="hidden" name="id_cita" value="<?php echo $cita['id_cita']; ?>">
            </div>
            <div class="mb-3">
                <label for="dateSelect" class="form-label">Seleccionar Fecha</label>
                <input type="date" class="form-control" id="dateSelect" required>
            </div>
            <div class="mb-3">
                <label for="timeSelect" class="form-label">Seleccionar Hora</label>
                <input type="time" class="form-control" id="timeSelect" step="3600" required min="07:00" max="18:00">
            </div>
            <button type="submit" class="btn btn-primary">Buscar horarios disponibles</button>
        </form>
        <div id="availableDoctors" class="row mt-4"></div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function (event) {
            document.getElementById('AsignarConsultorio').addEventListener('click', function (event) {
                document.getElementByID('AsignarConsultorio').style.backgroundColor = '#0d6efd';
                document.getElementById("posponercita").style.display = 'none';
                document.getElementById("formConsultorio").style.display = 'block';
            });

            document.getElementById('PosponerCita').addEventListener('click', function (event) {
                document.getElementById("formConsultorio").style.display = 'none';
                document.getElementById("posponercita").style.display = 'block';
            });

            document.getElementById('EnviarRecordatorio').addEventListener('click', function (event) {
                document.getElementById("formConsultorio").style.display = 'none';
                document.getElementById("posponercita").style.display = 'none';
                alert('Recordatorio enviado');
            });
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
            const citaId = params['id_cita'];

            // Manejar el envío del formulario
            document.getElementById('appointmentForm').addEventListener('submit', function (event) {
                event.preventDefault();
                const opcion = document.getElementById('optionSelect').value;
                const valorOpcion = document.getElementById('optionvalue').value;
                const date = document.getElementById('dateSelect').value;
                const time = document.getElementById('timeSelect').value;
                let body = JSON.stringify({
                    opcion: opcion,
                    valorOpcion: valorOpcion,
                    fecha: date,
                    hora: time
                });
                fetch('getAvailableDoctors.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: body
                }).then(response => response.json())
                .then(data => {
                    const availableDoctors = document.getElementById('availableDoctors');
                    availableDoctors.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(doctor => {
                            const card = document.createElement('div');
                            card.className = 'col-md-4';
                            card.innerHTML = `
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title">${doctor.nombres}</h5>
                                        <p class="card-text">Especialidad: ${doctor.especialidad}</p>
                                        <button class="btn btn-primary assign-btn" data-doctor-id="${doctor.id}">Asignar Cita</button>
                                    </div>
                                </div>
                            `;
                            availableDoctors.appendChild(card);
                        });
                        // Asignar eventos de clic a los botones de asignación
                        document.querySelectorAll('.assign-btn').forEach(button => {
                            button.addEventListener('click', function (event) {
                                const patientId = <?php echo $_SESSION['user_id']; ?>;
                                const doctorId = this.getAttribute('data-doctor-id');
                                const correo = "<?php echo $_SESSION['user_correo']; ?>";
                                let body = JSON.stringify({
                                    especialidad: valorOpcion,
                                    patientId: patientId,
                                    doctorId: doctorId,
                                    fecha: date,
                                    hora: time
                                    citaID: citaId
                                });
                                fetch('assignAppointment.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: body
                                }).then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Cita Asignada',
                                            text: `Email de recordatorio enviado a: ${correo}`,
                                            confirmButtonText: 'Aceptar'
                                        });
                                    } else {
                                        alert(data.message);
                                    }
                                });
                            });
                        });
                    } else {
                        availableDoctors.innerHTML = '<p>No hay médicos disponibles para la fecha y hora seleccionadas.</p>';
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    </script>
</body>
</html>
<?php
}
?>