<?php
session_start();
require_once 'DataBase.php';

// Habilitar reporte de errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

// Tamaño máximo permitido (5MB)
$maxFileSize = 5 * 1024 * 1024; // 5MB

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['avatar']['tmp_name'];
        $fileName = $_FILES['avatar']['name'];
        $fileSize = $_FILES['avatar']['size'];
        $fileType = $_FILES['avatar']['type'];

        // Verificar que el archivo sea una imagen válida
        $check = getimagesize($fileTmpPath);
        if ($check === false) {
            echo json_encode(['status' => 'error', 'message' => 'El archivo no es una imagen válida.']);
            exit();
        }

        // Verificar si el archivo es una imagen permitida
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp'];
        if (!in_array($fileType, $allowedMimeTypes)) {
            echo json_encode(['status' => 'error', 'message' => 'Tipo de archivo no permitido.']);
            exit();
        }

        if ($fileSize > $maxFileSize) {
            echo json_encode(['status' => 'error', 'message' => 'El archivo es demasiado grande. Máximo 5MB.']);
            exit();
        }

        // Definir el directorio de subida usando ruta absoluta
        $uploadFileDir = __DIR__ . '/uploads/avatars/';
        if (!is_dir($uploadFileDir)) {
            if (!mkdir($uploadFileDir, 0755, true)) {
                echo json_encode(['status' => 'error', 'message' => 'No se pudo crear el directorio de subida.']);
                exit();
            }
        }

        // Obtener la extensión del archivo
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        // Generar un nombre de archivo único
        $newFileName = uniqid('avatar_', true) . '.' . $fileExtension;
        $destPath = $uploadFileDir . $newFileName;

        // Mover el archivo
        if (!move_uploaded_file($fileTmpPath, $destPath)) {
            echo json_encode(['status' => 'error', 'message' => 'Error al mover el archivo al directorio de destino.']);
            exit();
        }

        // Actualizar la ruta del avatar en la base de datos
        $conn = DataBase::getInstance()->getConnection();
        $userId = $_SESSION['user_id'];
        $relativeDestPath = 'uploads/avatars/' . $newFileName; // Ruta relativa para almacenar en la base de datos

        $sql = "UPDATE usuario SET avatar = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("si", $relativeDestPath, $userId);
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'avatar_path' => $relativeDestPath]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al actualizar la base de datos: ' . $stmt->error]);
            }
            $stmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta SQL: ' . $conn->error]);
        }
        $conn->close();
    } else {
        // Manejar diferentes errores de subida
        $errorMessages = [
            UPLOAD_ERR_INI_SIZE => 'El archivo excede el tamaño máximo permitido.',
            UPLOAD_ERR_FORM_SIZE => 'El archivo excede el tamaño máximo permitido en el formulario.',
            UPLOAD_ERR_PARTIAL => 'El archivo se subió parcialmente.',
            UPLOAD_ERR_NO_FILE => 'No se subió ningún archivo.',
            UPLOAD_ERR_NO_TMP_DIR => 'Falta un directorio temporal.',
            UPLOAD_ERR_CANT_WRITE => 'No se pudo escribir el archivo en el disco.',
            UPLOAD_ERR_EXTENSION => 'Una extensión de PHP detuvo la subida del archivo.',
        ];

        $errorCode = $_FILES['avatar']['error'];
        $message = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : 'Error desconocido al subir el archivo.';
        echo json_encode(['status' => 'error', 'message' => $message]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Método de solicitud no válido.']);
}
?>