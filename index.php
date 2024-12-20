<?php
session_start();
if (empty($_SESSION['global_token'])) {
    $_SESSION['global_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <h1>jquirarte_21@alu.uabcs.mx</h1>
    <h2>123456804</h2>
    <div class="container-fluid">
        <div class="row no-gutters">
            <div class="col-md-6 d-none d-md-flex justify-content-center align-items-center m-0">
                <img src="descarga.png" alt="Imagen de login" class="img-fluid" style="max-height: 100vh; width: auto;">
            </div>
            <div class="col-md-6 d-flex justify-content-center align-items-center m-0" style="height: 100vh;">
                <form action="controller.php" method="POST">
                    <input type="hidden" name="global_token" value="<?php echo htmlspecialchars($_SESSION['global_token']); ?>">
                    <h2>Iniciar Sesión</h2>
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Introduce tu correo" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Introduce tu contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                </form>
                
                
            </div>
        </div>
    </div>
</body>
</html>
