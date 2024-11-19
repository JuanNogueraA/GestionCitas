<?php
require_once 'DataBase.php'; // Ajusta la ruta según sea necesario

try {
    // Crear conexión usando el patrón singleton
    $conn = DataBase::getInstance()->getConnection();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_GET['action']) && $_GET['action'] == 'search') {
            if (isset($_POST['fileId'])) {
                $fileId = $_POST['fileId'];

                // Buscar el archivo en la base de datos
                $sql = "SELECT id, descripcion FROM historial_clinico WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $fileId);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $files = [];
                    while ($row = $result->fetch_assoc()) {
                        $files[] = $row;
                    }
                    echo json_encode(['status' => 'success', 'files' => $files]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'No se encontraron archivos para este ID']);
                }

                $stmt->close();
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
            }
        }
    } elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['action']) && $_GET['action'] == 'download' && isset($_GET['id'])) {
            $fileId = $_GET['id'];

            // Buscar el archivo en la base de datos
            $sql = "SELECT descripcion, archivo FROM historial_clinico WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $fileId);
            $stmt->execute();
            $stmt->bind_result($fileName, $fileContent);
            $stmt->fetch();

            if ($fileName) {
                // Enviar el archivo al navegador para su descarga
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . $fileName . '.docx"');
                header('Content-Length: ' . strlen($fileContent));
                echo $fileContent;
            } else {
                echo 'Archivo no encontrado';
            }

            $stmt->close();
        } else {
            echo 'ID de archivo no proporcionado';
        }
    }

    $conn->close();
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>