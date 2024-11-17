<?php
// ...existing code...
require_once '../path/to/DataBase.php'; // Ajusta la ruta según sea necesario

// Obtener la instancia de la base de datos
$db = DataBase::getInstance();
$connection = $db->getConnection();

// ...existing code...
// Usa $connection para realizar operaciones en la base de datos
// ...existing code...
?>
