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
                } else { // Si no se encuentran archivos para el ID proporcionado
                    echo json_encode(['status' => 'error', 'message' => 'No se encontraron archivos para este ID']);
                }

                $stmt->close();
            } else { // Si no se proporciona el ID del archivo
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
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="' . $fileName . '.pdf');
                header('Content-Length: ' . strlen($fileContent));
                echo $fileContent;
            } else {
                echo 'Archivo no encontrado';
            }
            // Cerrar la consulta preparada
            $stmt->close();
        } else {
            $fileId = $_GET['id'];

            // Buscar el archivo en la base de datos
            $sql = "SELECT archivo FROM historial_clinico WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $fileId);
            $stmt->execute();
            $stmt->bind_result($fileContent);
            $stmt->fetch();

            if ($fileContent) {
                header('Content-Type: application/pdf');
                echo $fileContent;
            } else {
                echo "Archivo no encontrado.";
            }

            $stmt->close();
        }
    }

    $conn->close(); // Cerrar conexión
} catch (Exception $e) { // Capturar excepciones
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>