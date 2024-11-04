<?php
session_start();

if (empty($_SESSION['global_token'])) {
    $_SESSION['global_token'] = bin2hex(random_bytes(32));
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['global_token'] ?? null;
    echo "Token enviado ",$token;

    if (!isset($_SESSION['global_token']) || $token !== $_SESSION['global_token']) {
        echo "Token inválido.";
        echo "  de la session ",$_SESSION['global_token'];

        exit();
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    $url = "https://crud.jonathansoto.mx/api/login";

    $data = [
        'email' => $email,
        'password' => $password
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ],
    ];

    $context  = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    if ($response !== FALSE) {
        $result = json_decode($response, true);
        if (isset($result['data']['token'])) {
            $_SESSION['token'] = $result['data']['token'];
            header('Location: home.php');
            exit();
        } else {
            $error = "Login fallido: " . htmlspecialchars($result['error']);
            echo $error;
        }
    } else {
        $error = "Error en la conexión a la API.";
        echo $error;
    }
} elseif (isset($_SESSION['token'])) {
    $apiUrl = 'https://crud.jonathansoto.mx/api/products';
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
        echo json_encode(['error' => 'No se pudo obtener los productos.']);
        exit();
    }

    $responseData = json_decode($response, true);

    if (isset($responseData['data']) && is_array($responseData['data'])) {
        foreach ($responseData['data'] as $product) {
           /*  echo "<div>{$product['name']}</div>";  */
        }
    } else {
        echo json_encode([]);
    }
} else {
    header("Location: index.php");
    exit();
}
?>
