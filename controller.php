<?php
//esto es para ver los erroes 
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start(); 
/* 123456804 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    file_put_contents('log.txt', "Response: " . $response . "\n", FILE_APPEND);

    if ($response !== FALSE) {
        $result = json_decode($response, true);
        if (isset($result['data']['token'])) {
            $_SESSION['token'] = $result['data']['token'];
            header('Location: home.html'); 
            exit();
        } else {
            $error = "Login fallido: " . htmlspecialchars($result['error']);
            file_put_contents('log.txt', "Error: " . $error . "\n", FILE_APPEND);
            header("Location: index.html?error=" . urlencode($error));
            exit();
        }
    } else {
        $error = "Error en la conexión a la API.";
        file_put_contents('log.txt', "Error: " . $error . "\n", FILE_APPEND); 
        header("Location: index.html?error=" . urlencode($error));
        exit();
    }
}
?>
