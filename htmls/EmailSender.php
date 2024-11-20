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

    $apiKey = 're_VHssSs7B_ZxtvmeCHHUUyMgEGQbzV5vgD';
    $emailSender = new EmailSender($apiKey);
    $emailSender->sendAppointmentEmail(
        $emailDestino,
        'Nombre del Paciente',
        'Nombre del Doctor',
        'Fecha de la Cita',
        'Hora de la Cita'
    );
    echo "El recordatorio de la cita ha sido enviado a $emailDestino.";
}
?>