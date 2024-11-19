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
    $sql = "SELECT id, especialidad FROM doctors WHERE especialidad = ? AND fecha = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $valorOpcion, $fecha);
    $stmt->execute();
    $result = $stmt->get_result();

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