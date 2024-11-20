<?php
require_once 'Database.php';
require_once 'EmailSender.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = Database::getInstance()->getConnection();

    $idPaciente = $_POST['idPaciente'];
    $idMedico = $_POST['idMedico'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    try {
        $conn->begin_transaction();

        // Insert appointment
        $stmt = $conn->prepare("INSERT INTO citas (id_paciente, id_medico, fecha, hora) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $idPaciente, $idMedico, $fecha, $hora);
        $stmt->execute();

        // Get patient and doctor information for email
        $stmt = $conn->prepare("SELECT p.nombres as patient_name, p.correo as patient_email, 
                                     m.nombres as doctor_name 
                              FROM usuario p 
                              JOIN usuario m ON m.id = ? 
                              WHERE p.id = ?");
        $stmt->bind_param("ii", $idMedico, $idPaciente);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        // Send email notification
        $emailSender = new EmailSender('re_VHssSs7B_ZxtvmeCHHUUyMgEGQbzV5vgD');
        $emailSent = $emailSender->sendAppointmentEmail(
            $data['patient_email'],
            $data['patient_name'],
            $data['doctor_name'],
            $fecha,
            $hora
        );

        $conn->commit();

        echo json_encode([
            'status' => 'success',
            'message' => 'Cita asignada correctamente',
            'emailSent' => true,
            'emailAddress' => $data['patient_email']
        ]);

    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

    $conn->close();
}
?>