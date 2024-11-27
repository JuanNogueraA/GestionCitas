<?php
require_once 'DataBase.php';

header('Content-Type: application/json');

$conn = DataBase::getInstance()->getConnection();

session_start();
$userId = $_SESSION['user_id']; // Obtener el ID del usuario desde la sesión
$userRole = $_SESSION['user_rol']; // Obtener el rol del usuario desde la sesión

if ($userRole == 'medico') {
    $sql = "SELECT id_cita AS id, especialidad AS title, CONCAT(fecha, 'T', hora) AS start FROM cita WHERE id_medico = ? AND estado != 'cancelada'";
} else {
    $sql = "SELECT id_cita AS id, especialidad AS title, CONCAT(fecha, 'T', hora) AS start FROM cita WHERE id_paciente = ? AND estado != 'cancelada'";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$events = [];
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