<?php
require_once 'Database.php';
require_once 'EmailSender.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = Database::getInstance()->getConnection();

    $idCita = $_POST['citaID'];

    // Get patient email from database
    $stmt = $conn->prepare("SELECT p.correo, CONCAT(p.nombres, ' ', p.apellidos) AS nombrePaciente, 
    CONCAT(m.nombres, ' ', m.apellidos) AS nombreMedico, c.fecha, c.hora 
    FROM usuario p INNER JOIN cita c ON p.id = c.id_paciente 
    INNER JOIN usuario m ON c.id_medico = m.id
    WHERE c.id_cita = ?");
    $stmt->bind_param("i", $idCita);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $emailDestino = $data['correo'];


    $nombrePaciente = $data['nombrePaciente'];
    $nombreDoctor = 'Nombre del Doctor: ' . $data['nombreMedico']; // Reemplaza con el nombre real del doctor
    $fechaCita = 'Fecha de la Cita' . $data['fecha']; // Reemplaza con la fecha real de la cita
    $horaCita = 'Hora de la Cita' . $data['hora']; // Reemplaza con la hora real de la cita

    $apiKey = 're_VHssSs7B_ZxtvmeCHHUUyMgEGQbzV5vgD';
    $emailSender = new EmailSender($apiKey);
    $emailSender->sendAppointmentEmail(
        $emailDestino,
        $nombrePaciente,
        $nombreDoctor,
        $fechaCita,
        $horaCita
        );
    echo "El recordatorio de la cita ha sido enviado a $emailDestino.";
}
?>