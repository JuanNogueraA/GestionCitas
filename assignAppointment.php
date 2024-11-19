<?php
include 'dbConnection.php'; // Include database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patientId = $_POST['patientId'];
    $doctorId = $_POST['doctorId'];
    $appointmentDate = $_POST['appointmentDate'];
    $appointmentTime = $_POST['appointmentTime'];

    // Validate inputs
    if (empty($patientId) || empty($doctorId) || empty($appointmentDate) || empty($appointmentTime)) {
        echo "All fields are required.";
        exit;
    }

    // Prepare SQL statement
    $sql = "INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $patientId, $doctorId, $appointmentDate, $appointmentTime);

    // Execute SQL statement
    if ($stmt->execute()) {
        echo "Appointment assigned successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
