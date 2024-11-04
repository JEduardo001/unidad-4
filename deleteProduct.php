<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['token'])) {
    echo json_encode(['error' => 'No autenticado.']);
    exit();
}

$apiUrl = 'https://crud.jonathansoto.mx/api/products';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_SESSION['global_token']) || $token !== $_SESSION['global_token']) {
        echo "Token inválido.";
        exit();
    }

    $productId = $_POST['product_id'] ?? null;

    if (!$productId) {
        echo json_encode(['error' => 'ID de producto no proporcionado.']);
        exit();
    }

    $options = [
        'http' => [
            'header'  => "Authorization: Bearer " . $_SESSION['token'] . "\r\n" .
                         "Content-type: application/json\r\n",
            'method'  => 'DELETE', 
        ],
    ];

    $context = stream_context_create($options);
    $response = @file_get_contents("$apiUrl/$productId", false, $context);
    $http_response_code = $http_response_header[0];


    header("Location: home.php?message=" . urlencode($message));
}
?>
