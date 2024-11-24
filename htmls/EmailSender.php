<?php
require_once 'Database.php';
require_once 'EmailSender.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = Database::getInstance()->getConnection();

    $idPaciente = $_POST['idPaciente'];

    // Get patient email from database
    $stmt = $conn->prepare("SELECT correo FROM usuario WHERE id = ?");
    $stmt->bind_param("i", $idPaciente);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $emailDestino = $data['correo'];


    $nombrePaciente = $data['nombrePaciente'];
    $nombreDoctor = 'Nombre del Doctor: '+$_POST['nombreMedico']; // Reemplaza con el nombre real del doctor
    $fechaCita = 'Fecha de la Cita'; // Reemplaza con la fecha real de la cita
    $horaCita = 'Hora de la Cita'; // Reemplaza con la hora real de la cita

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