<?php
require_once 'DataBase.php';
session_start();
$conn = DataBase::getInstance()->getConnection();
$stmt = $conn->prepare("UPDATE usuario SET sesion_abierta = 0 WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
session_unset();
session_destroy();
header("Location: iniciarsesion.php");
exit();
?>