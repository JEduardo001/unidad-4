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

    header("Location: home.php?message=" . urlencode($message));



}
?>
