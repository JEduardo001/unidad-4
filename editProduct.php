<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['token'])) {
    echo json_encode(['error' => 'No autenticado.']);
    exit();
}

$apiUrl = 'https://crud.jonathansoto.mx/api/products';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'] ?? null;
    $name = $_POST['name'] ?? null;
    $slug = $_POST['slug'] ?? null;
    $description = $_POST['description'] ?? null;
    $features = $_POST['features'] ?? null;

    if (!$productId || !$name || !$slug || !$description || !$features) {
        echo json_encode(['error' => 'Datos incompletos.']);
        exit();
    }

    $data = [
        'id' => $productId,  
        'name' => $name,
        'slug' => $slug,
        'description' => $description,
        'features' => $features,
    ];

    $options = [
        'http' => [
            'header'  => "Authorization: Bearer " . $_SESSION['token'] . "\r\n" .
                         "Content-type: application/json\r\n",
            'method'  => 'PUT',
            'content' => json_encode($data),
        ],
    ];

    $context = stream_context_create($options);
    $response = @file_get_contents($apiUrl, false, $context);
    $http_response_code = $http_response_header[0];

    header("Location: home.html?message=" . urlencode($message));


    /* if ($response === FALSE) {
        echo json_encode(['error' => 'No se pudo actualizar el producto.', 'headers' => $http_response_header]);
        exit();
    }

    if (strpos($http_response_code, '200') === false) {
        echo json_encode(['error' => 'Error HTTP: ' . $http_response_code]);
        exit();
    }

    $responseData = json_decode($response, true);

    if (isset($responseData['success'])) {
        echo json_encode(['success' => 'Producto actualizado exitosamente.']);
    } else {
        echo json_encode(['error' => 'Error al actualizar el producto: ' . json_encode($responseData)]);
    } */
}
?>