<?php
header('Content-Type: application/json');
require_once 'DataBase.php'; // Adjust the path as necessary

try {
    if (!isset($_GET['medicoId'])) {
        throw new Exception('ID de médico no proporcionado');
    }

    $medicoId = $_GET['medicoId'];

    // Conexión a la base de datos usando el patrón singleton
    $conn = DataBase::getInstance()->getConnection();

    $sql = "SELECT fecha, hora_inicio, hora_fin FROM disponibilidad WHERE id_medico = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $medicoId);
    $stmt->execute();
    $result = $stmt->get_result();
    $disponibilidad = [];
    while ($row = $result->fetch_assoc()) {
        $disponibilidad[] = $row;
    }

    echo json_encode($disponibilidad);

    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>