<?php
require_once 'DataBase.php'; // Ajusta la ruta según sea necesario

header('Content-Type: application/json');

try {
    $conn = DataBase::getInstance()->getConnection();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['patientId']) && isset($data['doctorId']) && isset($data['fecha']) && isset($data['hora'])) {
            $consultorio = 0;
            $especialidad = $data['especialidad'];
            $patientId = $data['patientId'];
            $doctorId = $data['doctorId'];
            $fecha = $data['fecha'];
            $hora = $data['hora'];
            $sql = "INSERT INTO cita (id_paciente, id_medico, especialidad, num_consultorio, fecha, hora) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iissss", $patientId, $doctorId, $especialidad, $consultorio, $fecha, $hora);

            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Cita asignada con éxito']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al asignar la cita']);
            }

            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Método de solicitud no válido']);
    }

    $conn->close();
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
