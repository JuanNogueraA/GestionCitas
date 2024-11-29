<?php
header('Content-Type: application/json');
session_start();

try {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Include the existing database connection
        require_once 'DataBase.php';

        $conn = DataBase::getInstance()->getConnection(); // Using singleton pattern

        if ($conn->connect_error) {
            throw new Exception('Database connection failed');
        }

        $sql = "SELECT c.id_cita, c.id_medico, c.id_paciente, c.fecha, c.hora, c.num_consultorio, CONCAT(u.nombres, ' ', u.apellidos) AS medico
        FROM cita c 
        JOIN usuario u ON c.id_medico = u.id
        WHERE (id_medico = ? OR id_paciente = ?) AND c.estado != 'cancelada'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $id,$id);
        $stmt->execute();
        $result = $stmt->get_result();

        $citas = [];
        while ($row = $result->fetch_assoc()) {
            $citas[] = $row;
        }

        $stmt->close();
        $conn->close();

        echo json_encode($citas);
    } else {
        echo json_encode(['error' => 'No se suministró el id del paciente o médico']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>