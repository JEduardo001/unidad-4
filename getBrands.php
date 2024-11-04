<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['token'])) {
    echo json_encode(['error' => 'No autenticado.']);
    exit();
}

$brandsUrl = 'https://crud.jonathansoto.mx/api/brands';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $brandsUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer " . $_SESSION['token'],
]);
$brandsResponse = curl_exec($ch);
$brandsHttpResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($brandsHttpResponseCode === 200) {
    echo $brandsResponse; 
} else {
    echo json_encode(['error' => 'No se pudieron obtener las marcas.']);
}
?>
