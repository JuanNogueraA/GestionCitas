<?php
require_once 'DataBase.php'; // Ajusta la ruta según sea necesario

header('Content-Type: application/json');

try {
    // Crear conexión usando el patrón singleton
    $conn = Database::getInstance()->getConnection();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $opcion = $_POST['opcion'];
        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];
        $valorOpcion = $_POST['valorOpcion'];
        // Consulta para obtener la disponibilidad del médico
        if ($valorOpcion === "optionmedico") {
            $sqlDisponibilidad = "SELECT * FROM disponibilidad WHERE medico_id = (SELECT id FROM medico WHERE nombre = ?) AND dia_semana = DAYNAME(?)";
        } else if ($valorOpcion === "optionpaciente") {
            $sqlDisponibilidad = "SELECT * FROM disponibilidad WHERE medico_id = (SELECT id FROM medico WHERE nombre = ?) AND dia_semana = DAYNAME(?)";
        }


        $stmtDisponibilidad = $conn->prepare($sqlDisponibilidad);
        $stmtDisponibilidad->bind_param("ss", $nombremedico, $fecha);
        $stmtDisponibilidad->execute();
        $resultDisponibilidad = $stmtDisponibilidad->get_result();

        if ($resultDisponibilidad->num_rows > 0) {
            $disponibilidad = $resultDisponibilidad->fetch_assoc();

            // Consulta para verificar si ya hay una cita en la fecha y hora especificadas
            $sqlCitas = "SELECT * FROM citas WHERE medico_id = (SELECT id FROM medico WHERE nombre = ?) AND fecha = ? AND hora = ?";
            $stmtCitas = $conn->prepare($sqlCitas);
            $stmtCitas->bind_param("sss", $nombremedico, $fecha, $hora);
            $stmtCitas->execute();
            $resultCitas = $stmtCitas->get_result();
            // Verificar si el médico está disponible en la fecha y hora especificadas
            if ($resultCitas->num_rows > 0) {
                echo json_encode(['success' => false, 'message' => 'El médico no está disponible en la fecha y hora especificadas']);
            } else {
                echo json_encode(['success' => true, 'message' => 'El médico está disponible']);
            }
            // Cerrar consultas preparadas

            $stmtCitas->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'No se encontró disponibilidad para el médico en la fecha especificada']);
        }

        $stmtDisponibilidad->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Método de solicitud no válido']);
    }
    // Cerrar conexión
    $conn->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Buscar Disponibilidad</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

</html>