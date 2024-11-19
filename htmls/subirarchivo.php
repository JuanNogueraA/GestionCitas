<?php
require_once 'DataBase.php'; // Ajusta la ruta según sea necesario

try {
    // Crear conexión usando el patrón singleton
    $conn = DataBase::getInstance()->getConnection();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['descripcion']) && isset($_FILES['file'])) {
            $descripcion = $_POST['descripcion'];
            $file = $_FILES['file'];

            // Verificar si el archivo se subió sin errores
            if ($file['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $file['tmp_name'];
                $fileContent = file_get_contents($fileTmpPath);
                $id = 1041771424;
                // Insertar la información del archivo en la base de datos
                $sql = "INSERT INTO historial_clinico (id, descripcion, archivo) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("isb", $id, $descripcion, $fileContent);
                $stmt->send_long_data(2, $fileContent);

                if ($stmt->execute()) {
                    echo json_encode(['status' => 'success', 'message' => 'Archivo subido correctamente']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Error al registrar el archivo en la base de datos']);
                }

                $stmt->close();
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al subir el archivo']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
        }
    }

    $conn->close();
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>