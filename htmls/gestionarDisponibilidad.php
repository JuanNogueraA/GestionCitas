<?php
require_once 'DataBase.php';
// Crear conexión usando el patrón singleton
$conn = Database::getInstance()->getConnection();
// Establecer el tipo de contenido de la respuesta
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos enviados por el cliente
    $medicoId = $_POST['medicoId'];
    $fecha = $_POST['fecha'];
    $horaInicio = $_POST['horaInicio'];
    $horaFin = $_POST['horaFin'];
    // Insertar la disponibilidad en la base de datos
    try { // Preparar la consulta
        $sql = "INSERT INTO disponibilidad (id_medico, fecha, hora_inicio, hora_fin) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $medicoId, $fecha, $horaInicio, $horaFin);
        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            throw new Exception('Error al guardar la disponibilidad');
        }
        // Cerrar la consulta preparada
        $stmt->close();
        $conn->close();
        // Manejar cualquier excepción que pueda ocurrir
    } catch (Exception $e) {
        if ($e->getCode() === 1062) {
            $error = "La fecha ingresada ya se encuentra registrada. Por favor, use una diferente.";
            echo json_encode(['status' => 'error', 'message' => $error]);
        } else {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
?>