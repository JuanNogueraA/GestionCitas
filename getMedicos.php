
<?php
header('Content-Type: application/json');
require_once 'DataBase.php';

try {
    // Create database connection
    $connection = Database::connect();
    
    if (!$connection) {
        throw new Exception("Error en la conexión a la base de datos");
    }

    // Prepare the query to get active doctors
    $query = "SELECT id_medico as id, CONCAT(nombre, ' ', apellido) as nombre 
              FROM medicos 
              WHERE estado = 1 
              ORDER BY nombre";

    try {
        $statement = $connection->prepare($query);
        
        if (!$statement) {
            throw new Exception("Error al preparar la consulta");
        }

        // Execute the query
        if (!$statement->execute()) {
            throw new Exception("Error al ejecutar la consulta");
        }

        // Fetch all results
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        if ($result === false) {
            throw new Exception("Error al obtener los resultados");
        }

        // Return the results as JSON
        echo json_encode($result);

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} finally {
    // Close the connection
    if (isset($connection)) {
        $connection = null;
    }
}
?>