<?php
require_once 'DataBase.php'; // Ajusta la ruta según sea necesario

header('Content-Type: application/json');

try {
    $conn = DataBase::getInstance()->getConnection();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        if(isset($data['patientId']) && isset($data['doctorId']) && isset($data['fecha']) && isset($data['hora'])){
            $consultorio = 0;
            $patientId = $data['patientId'];
            $doctorId = $data['doctorId'];
            if($data['opcion'] === 'especialidad'){
                $especialidad = $data['valorOpcion'];
            }else{
                $stmtmedico = $conn->prepare("SELECT especialidad FROM medico WHERE id = ?");
                $stmtmedico->bind_param("i", $data['valorOpcion']);
                $stmtmedico->execute();
                $result = $stmtmedico->get_result();
                $row = $result->fetch_assoc();
                $especialidad = $row['especialidad'];
                $stmtmedico->close();
                
            }
            $fecha = $data['fecha'];
            $hora = $data['hora'];
            $estado = 'activa';
            $sql = "INSERT INTO cita (id_paciente, id_medico, especialidad, num_consultorio, fecha, hora, estado) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iisssss", $patientId, $doctorId, $especialidad, $consultorio, $fecha, $hora, $estado);
            $stmt->execute();
            echo json_encode(['status' => 'success', 'message' => 'Cita asignada correctamente']);
            }else {
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
