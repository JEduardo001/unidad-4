<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['token'])) {
    echo json_encode(['error' => 'No autenticado.']);
    exit();
}

$apiUrl = 'https://crud.jonathansoto.mx/api/products';

if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];
    $apiUrl = "https://crud.jonathansoto.mx/api/products/slug/$slug";

    $options = [
        'http' => [
            'header'  => "Authorization: Bearer " . $_SESSION['token'] . "\r\n" .
                         "Content-type: application/json\r\n",
            'method'  => 'GET',
        ],
    ];

    $context  = stream_context_create($options);
    $response = file_get_contents($apiUrl, false, $context);

    if ($response === FALSE) {
        echo json_encode(['error' => 'No se pudo obtener el producto.']);
        exit();
    }

    $responseData = json_decode($response, true);

    if (isset($responseData['data'])) {
        echo json_encode($responseData['data']);
    } else {
        echo json_encode(['error' => 'Producto no encontrado.']);
    }
} else {
    echo json_encode(['error' => 'Slug no especificado.']);
}
?>
