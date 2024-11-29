<?php
require_once 'DataBase.php'; // Ajusta la ruta según sea necesario
// Se establece el tipo de contenido a devolver
header('Content-Type: application/json');

try { // Se intenta realizar la conexión a la base de datos
    $conn = DataBase::getInstance()->getConnection();
    // Se comprueba si el método de la petición es POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Se obtienen los datos enviados
        $data = json_decode(file_get_contents('php://input'), true);
        // Se comprueba si los datos requeridos existen
        if(isset($data['patientId']) && isset($data['doctorId']) && isset($data['fecha']) && isset($data['hora'])){
            // Se obtienen los datos enviados
            $consultorio = rand(1, 8);
            $patientId = $data['patientId'];
            $doctorId = $data['doctorId'];
            // Se obtiene la especialidad del médico
            if($data['opcion'] === 'especialidad'){
                $especialidad = $data['valorOpcion']; // Se obtiene la especialidad
            }else{ // Se obtiene la especialidad del médico
                $stmtmedico = $conn->prepare("SELECT especialidad FROM medico WHERE id = ?");
                $stmtmedico->bind_param("i", $data['valorOpcion']);
                $stmtmedico->execute();
                $result = $stmtmedico->get_result();
                $row = $result->fetch_assoc();
                $especialidad = $row['especialidad'];
                $stmtmedico->close();
                
            }
            // Se inserta la cita en la base de datos
            $fecha = $data['fecha'];
            $hora = $data['hora'];
            $estado = 'activa'; // Se establece el estado de la cita
            $sql = "INSERT INTO cita (id_paciente, id_medico, especialidad, num_consultorio, fecha, hora, estado) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql); // Se prepara la consulta
            // Se vincian los parámetros
            $stmt->bind_param("iisssss", $patientId, $doctorId, $especialidad, $consultorio, $fecha, $hora, $estado);
            $stmt->execute(); // Se ejecuta la consulta
            // Se verifica si la consulta se ejecutó correctamente
            echo json_encode(['status' => 'success', 'message' => 'Cita asignada correctamente']);
            }else {
                // Se envía un mensaje de error
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
