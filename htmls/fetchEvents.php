<?php
require_once 'DataBase.php';

header('Content-Type: application/json');

$conn = DataBase::getInstance()->getConnection();

session_start();
$userId = $_SESSION['user_id']; // Obtener el ID del usuario desde la sesión
$userRole = $_SESSION['user_rol']; // Obtener el rol del usuario desde la sesión

if ($userRole == 'medico') { // Si el usuario es un médico
    $sql = "SELECT id_cita AS id, especialidad AS title, CONCAT(fecha, 'T', hora) AS start FROM cita WHERE id_medico = ? AND estado != 'cancelada'";
} else { // Si el usuario es un paciente
    $sql = "SELECT id_cita AS id, especialidad AS title, CONCAT(fecha, 'T', hora) AS start FROM cita WHERE id_paciente = ? AND estado != 'cancelada'";
}
// Preparar la consulta
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
// Obtener los eventos del día
$events = [];
// Recorrer los resultados y almacenarlos en un array
while ($row = $result->fetch_assoc()) {
    $events[] = [
        'id' => $row['id'],
        'title' => $row['title'],
        'start' => $row['start']
    ];
}

echo json_encode($events);

$stmt->close();
$conn->close();
?>