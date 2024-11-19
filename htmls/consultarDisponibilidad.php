
<?php
header('Content-Type: application/json');

if (isset($_GET['medicoId'])) {
    $medicoId = $_GET['medicoId'];

    // Conexión a la base de datos
    $conn = new mysqli('localhost', 'root', '', 'gestion_citas');

    if ($conn->connect_error) {
        die(json_encode(['status' => 'error', 'message' => 'Error de conexión a la base de datos']));
    }

    $sql = "SELECT fecha, hora_inicio, hora_fin FROM disponibilidad WHERE id_medico = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $medicoId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $disponibilidad = [];
    while ($row = $result->fetch_assoc()) {
        $disponibilidad[] = $row;
    }

    echo json_encode($disponibilidad);

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID de médico no proporcionado']);
}
?>