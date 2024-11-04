<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['token'])) {
    echo json_encode(['error' => 'No autenticado.']);
    exit();
}

$apiUrl = 'https://crud.jonathansoto.mx/api/products';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? null;
    $slug = $_POST['slug'] ?? null;
    $description = $_POST['description'] ?? null;
    $features = $_POST['features'] ?? null;
    $image = $_FILES['image'] ?? null;

    if (!$name || !$slug || !$description || !$features || !$image) {
        echo json_encode(['error' => 'Datos incompletos.']);
        exit();
    }

    if ($image['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['error' => 'Error al subir la imagen.']);
        exit();
    }

    $data = [
        'name' => $name,
        'slug' => $slug,
        'description' => $description,
        'features' => $features,
        'cover' => new CURLFile($image['tmp_name'], $image['type'], $image['name']),
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $_SESSION['token'],
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);
    $http_response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($response === FALSE) {
        echo json_encode(['error' => 'No se pudo añadir el producto.']);
        exit();
    }

    if ($http_response_code !== 200) {
        echo json_encode(['error' => 'Error HTTP: ' . $http_response_code]);
        exit();
    }

    $responseData = json_decode($response, true);

    if (isset($responseData['success'])) {
        echo json_encode(['success' => 'Producto añadido exitosamente.']);
    } else {
        echo json_encode(['error' => 'Error al añadir el producto: ' . json_encode($responseData)]);
    }
}
?>
