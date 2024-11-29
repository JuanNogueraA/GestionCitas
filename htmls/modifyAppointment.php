<?php 
session_start();
require_once 'DataBase.php'; // Ajusta la ruta según sea necesario

// Obtener la conexión a la base de datos
$conexion = DataBase::getInstance()->getConnection();
$stmtauditoria = $conexion->prepare("INSERT INTO auditoria_cita (id_cita, id_admin, fecha, descripcion_accion) VALUES (?, ?, ?, ?)");
date_default_timezone_set('America/Bogota'); // Ajusta la zona horaria a Bogotá, Colombia
$fechaActual = date('Y-m-d H:i:s');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cita = $_POST['id_cita'];
    if (isset($_POST['consultorio'])) {
        $consultorio = $_POST['consultorio'];
        $query = "UPDATE cita SET num_consultorio = ? WHERE id_cita = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('si', $consultorio, $id_cita);
        $descripcion = "Asignación de consultorio";
        $stmtauditoria->bind_param("iiss", $id_cita, $_SESSION['user_id'], $fechaActual, $descripcion);
        
    } else {
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];
        $query = "UPDATE cita SET fecha = ?, hora = ? WHERE id_cita = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('ssi', $fecha, $hora, $id_cita);
        $descripcion = "Posposición de cita";
        $stmtauditoria->bind_param("iiss", $id_cita, $_SESSION['user_id'], $fechaActual, $descripcion);
    }

    if ($stmt->execute()) {
        $stmtauditoria->execute();
        echo json_encode(['status' => 'success', 'message' => 'Cita actualizada correctamente']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar la cita']);
    }

}else if(isset($_GET['id_cita']) && isset($_GET['estado'])){
    $id_cita = $_GET['id_cita'];
    $estado = $_GET['estado'];
    $query = "UPDATE cita SET estado = ? WHERE id_cita = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('si', $estado, $id_cita);
    $descripcion = "Cancelación de cita";
    $stmtauditoria->bind_param("iiss", $id_cita, $_SESSION['user_id'], $fechaActual, $descripcion);
    if ($stmt->execute()) {
        $stmtauditoria->execute();
        header("Location: GestionCitas.html?mensaje=cancelación exitosa de cita");
    } else {
        header("Location: GestionCitas.html?mensaje=error al cancelar cita");
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
    <link rel="stylesheet" href="HojasEstilo/Administrador.css">
    <link rel="stylesheet" href="HojasEstilo/navigator.css">

</head>
<body>
<a id="regresar" href="GestionCitas.html" class="btn btn-primary" style="margin: 30px 0 0 30px;">← Volver</a>
    <div class="container mt-5">
        <h2>Modificar Cita</h2>
        <button type="button" class="btn btn-primary" style="margin-top: 40px; background-color: skyblue;" id="PosponerCita">Posponer cita</button>
        <button type="button" class="btn btn-primary" style="margin-top: 40px;" id="AsignarConsultorio">Asignar consultorio</button>
        <button type="button" class="btn btn-primary" style="margin-top: 40px;" id="EnviarRecordatorio">Enviar recordatorio</button>
        <hr>
        <form style="display: none;" id="formConsultorio">
            <input type="hidden" name="id_cita" id="idcita" value="<?php echo $cita['id_cita']; ?>">
            <div class="mb-3">
                <label for="consultorio" class="form-label">Número de consultorio</label>
                <input type="text" class="form-control" id="consultorio" name="consultorio" value="<?php echo $cita['num_consultorio']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>

        <form id="posponercita">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function (event) {
            const rolusuario = <?php echo json_encode($_SESSION['user_rol']); ?>;
            if(rolusuario === 'paciente'){
                document.getElementById('AsignarConsultorio').style.display = 'none';
                document.getElementById('EnviarRecordatorio').style.display = 'none';
                document.getElementById('regresar').href = 'GestionCitasUsuario.php';

            }
            document.getElementById('timeSelect').addEventListener('change', function (e) {
                let time = e.target.value;
                if (time) {
                // Extrae solo la hora y establece los minutos a 00
                let hour = time.split(':')[0];
                e.target.value = hour + ':00';
                }
            });

            document.getElementById('AsignarConsultorio').addEventListener('click', function (event) {
                document.getElementById('AsignarConsultorio').style.backgroundColor= 'skyblue';
                document.getElementById('PosponerCita').style.backgroundColor= '#0d6efd';
                document.getElementById('EnviarRecordatorio').style.backgroundColor= '#0d6efd';
                document.getElementById("posponercita").style.display = 'none';
                document.getElementById("formConsultorio").style.display = 'block';
            });

            document.getElementById('PosponerCita').addEventListener('click', function (event) {
                document.getElementById('PosponerCita').style.backgroundColor= 'skyblue';
                document.getElementById('EnviarRecordatorio').style.backgroundColor= '#0d6efd';
                document.getElementById('AsignarConsultorio').style.backgroundColor= '#0d6efd';
                document.getElementById("formConsultorio").style.display = 'none';
                document.getElementById("posponercita").style.display = 'block';
            });

            document.getElementById('EnviarRecordatorio').addEventListener('click', function (event) {
                document.getElementById('EnviarRecordatorio').style.backgroundColor= 'skyblue';
                document.getElementById('PosponerCita').style.backgroundColor= '#0d6efd';
                document.getElementById('AsignarConsultorio').style.backgroundColor= '#0d6efd';
                document.getElementById("formConsultorio").style.display = 'none';
                document.getElementById("posponercita").style.display = 'none';
                alert('Recordatorio enviado');
            });

            document.getElementById('formConsultorio').addEventListener('submit', function (event) {
                event.preventDefault();
                const formData = new FormData(event.target);
                fetch('modifyAppointment.php', {
                    method: 'POST',
                    body: formData
                }).then(response => response.json())
                .then(data => {
                    alert(data.message);
                })
                .catch(error => console.error('Error:', error));
            });
            
            // Manejar el envío del formulario
            document.getElementById('posponercita').addEventListener('submit', function (event) {
                event.preventDefault();
                const opcion = 'especialidad';
                <?php 
                try {
                    $stmtespecialidad = $conexion->prepare("SELECT m.especialidad FROM medico m 
                    JOIN cita c ON m.id = c.id_medico WHERE c.id_cita = ?");
                    $stmtespecialidad->bind_param("i", $id_cita);
                    $stmtespecialidad->execute();
                    $result = $stmtespecialidad->get_result();
                    $row = $result->fetch_assoc();
                    $especialidad = $row['especialidad'];

                    $stmtusuario = $conexion->prepare("SELECT correo FROM usuario u 
                    JOIN cita c ON u.id = c.id_paciente WHERE c.id_cita = ?");
                    $stmtusuario->bind_param("i", $id_cita);
                    $stmtusuario->execute();    
                    $resultusuario = $stmtusuario->get_result();
                    $rowusuario = $resultusuario->fetch_assoc();
                    $correo = $rowusuario['correo'];
                    
                } catch (Exception $e) {
                    echo "Error al obtener la especialidad: " . $e->getMessage();
                    exit();
                }
                ?>
                const valorOpcion = '<?php echo $especialidad; ?>';
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
                                const id_cita = <?php echo $cita['id_cita'] ?>;
                                const formData = new FormData();
                                const correo = '<?php echo $correo ?>';
                                formData.append('id_cita', id_cita);
                                formData.append('fecha', date);
                                formData.append('hora', time);
                                fetch('modifyAppointment.php', {
                                    method: 'POST',
                                    body: formData
                                }).then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Cita Pospuesta',
                                            text: `Email de recordatorio enviado a: ${correo}`,
                                            confirmButtonText: 'Aceptar'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                location.reload(); // Recargar la página
                                            }
                                        });
                                    } else {
                                        alert(data.message);
                                    }
                                })
                                .catch(error => console.error('Error:', error));
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
$stmtespecialidad->close();
}
?>