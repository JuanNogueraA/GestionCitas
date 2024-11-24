<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

$opcion = $data['opcion'];
$valorOpcion = $data['valorOpcion'];
$fecha = $data['fecha'];
$hora = $data['hora'];

require_once 'DataBase.php';

try {
    $conn = DataBase::getInstance()->getConnection();
    if($opcion === 'especialidad'){
        $sql = "SELECT medico.id, medico.especialidad, CONCAT(usuario.nombres, ' ', usuario.apellidos) AS nombres FROM medico
        JOIN disponibilidad ON medico.id = disponibilidad.id_medico 
        JOIN usuario ON medico.id_usuario = usuario.id
        WHERE medico.especialidad = ? AND disponibilidad.fecha = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $valorOpcion, $fecha);
        $stmt->execute();
        $result = $stmt->get_result();
    }else if($opcion === 'medico'){
        $sql = "SELECT medico.id, medico.especialidad, CONCAT(usuario.nombres, ' ', usuario.apellidos) AS nombres FROM medico
        JOIN disponibilidad ON medico.id = disponibilidad.id_medico 
        JOIN usuario ON medico.id_usuario = usuario.id
        WHERE medico.id = ? AND disponibilidad.fecha = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $valorOpcion, $fecha);
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