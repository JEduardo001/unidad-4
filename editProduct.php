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
    $name = $_POST['name'] ?? null;
    $slug = $_POST['slug'] ?? null;
    $description = $_POST['description'] ?? null;
    $features = $_POST['features'] ?? null;

    if (!$productId || !$name || !$slug || !$description || !$features) {
        echo json_encode(['error' => 'Datos incompletos.  ',$productId, $name, $slug, $description, $features]);
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

    header("Location: home.php?message=" . urlencode($message));


    
}
?>
