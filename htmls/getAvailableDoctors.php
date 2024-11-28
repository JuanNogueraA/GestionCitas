<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

$opcion = $data['opcion'];
$valorOpcion = $data['valorOpcion'];
$fecha = $data['fecha'];
$hora = $data['hora'];
$estado = 'activa';

require_once 'DataBase.php';

try {
    $conn = DataBase::getInstance()->getConnection();
    if($opcion === 'especialidad'){
        $sql = "SELECT medico.id, medico.especialidad, CONCAT(usuario.nombres, ' ', usuario.apellidos) AS nombres, disponibilidad.fecha
        FROM medico
        JOIN disponibilidad ON medico.id = disponibilidad.id_medico 
        JOIN usuario ON medico.id_usuario = usuario.id  
        LEFT JOIN cita c ON medico.id = c.id_medico AND c.estado != 'cancelada' AND c.fecha = ? AND c.hora = ?
        WHERE medico.especialidad = ? AND disponibilidad.fecha = ? AND (? BETWEEN disponibilidad.hora_inicio AND disponibilidad.hora_fin)
        AND c.id_cita IS NULL";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssss', $fecha, $hora, $valorOpcion, $fecha, $hora);
        $stmt->execute();
        $result = $stmt->get_result();
    }else if($opcion === 'medico'){
        $sql = "SELECT medico.id, medico.especialidad, CONCAT(usuario.nombres, ' ', usuario.apellidos) AS nombres, disponibilidad.fecha
        FROM medico
        JOIN disponibilidad ON medico.id = disponibilidad.id_medico 
        JOIN usuario ON medico.id_usuario = usuario.id
        LEFT JOIN cita c ON medico.id = c.id_medico AND c.estado != 'cancelada' AND c.fecha = ? AND c.hora = ?
        WHERE medico.id = ? AND c.id_cita IS NULL AND disponibilidad.fecha = ? 
        AND ? BETWEEN disponibilidad.hora_inicio AND disponibilidad.hora_fin";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssss', $fecha, $hora, $valorOpcion, $fecha, $hora);
        $stmt->execute();
        $result = $stmt->get_result();
    }

    $doctors = [];
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }

    $stmt->close();
    echo json_encode($doctors);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>