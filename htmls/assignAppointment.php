<?php
require_once 'DataBase.php';  // Include singleton database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patientId = $_POST['patientId'];
    $doctorId = $_POST['doctorId'];
    $appointmentDate = $_POST['fecha'];
    $appointmentTime = $_POST['hora'];

    // Validate inputs
    if (empty($patientId) || empty($doctorId) || empty($appointmentDate) || empty($appointmentTime)) {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
        exit;
    }

    try {
        // Get the singleton instance of the database connection
        $conn = DataBase::getInstance()->getConnection();

        // Prepare SQL statement
        $sql = "INSERT INTO cita(id_paciente, id_medico, fecha, hora) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiss", $patientId, $doctorId, $appointmentDate, $appointmentTime);

        // Execute SQL statement
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Appointment assigned successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
        }       
        // Close statement
        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
