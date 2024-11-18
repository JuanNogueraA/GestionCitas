<?php
require_once 'Database.php';

$conn = Database::getInstance()->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $medicoId = $_POST['medicoId'];
    $diaSemana = $_POST['diaSemana'];
    $horaInicio = $_POST['horaInicio'];
    $horaFin = $_POST['horaFin'];

    $sql = "INSERT INTO disponibilidad (id_medico, dia_semana, hora_inicio, hora_fin) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $medicoId, $diaSemana, $horaInicio, $horaFin);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al guardar la disponibilidad']);
    }

    $stmt->close();
    $conn->close();
}
?>