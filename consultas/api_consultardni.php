<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Permitir solicitudes de cualquier origen

// Obtener los parámetros del GET
$dni = isset($_GET['dni']) ? $_GET['dni'] : '';

// Verifica que se haya proporcionado el DNI
if (empty($dni)) {
    echo json_encode(["error" => "Faltan parámetros."]);
    exit;
}

// Configura la URL de la API
$apiUrl = 'https://www.munichiclayo.gob.pe/Pide/Reniec/' . $dni;

// Verifica si la URL es válida
if (filter_var($apiUrl, FILTER_VALIDATE_URL) === FALSE) {
    echo json_encode(["error" => "URL de la API no válida."]);
    exit;
}

// Haz la solicitud a la API usando file_get_contents
$response = @file_get_contents($apiUrl);

// Verifica si la solicitud fue exitosa
if ($response === false) {
    echo json_encode(["error" => "Error en la solicitud a la API."]);
    exit;
}

// Devuelve la respuesta de la API al cliente
echo $response;
?>
