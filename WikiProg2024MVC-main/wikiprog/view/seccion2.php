<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['stop'])) {
    $_SESSION['stop'] = 0;
}
if ($_SESSION['stop'] < 3) {
    $_SESSION['stop'] += 1;
}

if (isset($_GET['estado']) && $_GET['estado'] == "ok") {
    $_SESSION['stop'] = 0;
}

if ($_SESSION['stop'] >= 3 && !isset($_SESSION['verification_code'])) {
    // Generar un código aleatorio de 6 dígitos y almacenarlo en la sesión
    $_SESSION['verification_code'] = rand(100000, 999999);
}

// Verificar el código ingresado
if (isset($_POST['verification_code'])) {
    if ($_POST['verification_code'] == $_SESSION['verification_code']) {
        $_SESSION['stop'] = 0;
        unset($_SESSION['verification_code']);
    } else {
        $error_message = "Código de verificación incorrecto.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <!-- Incluye los enlaces a Bootstrap u otros CSS si es necesario -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-body">
                        <h3 class="card-title text-center">Inicio de Sesión</h3>
                        <?php if ($_SESSION['stop'] >= 3): ?>
                            <div class="alert alert-danger" role="alert">
                                Demasiados Intentos Fallidos. Usa el código de verificación:
                                <strong><?php echo $_SESSION['verification_code']; ?></strong>
                            </div>
                            <?php if (isset($error_message)): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $error_message; ?>
                                </div>
                            <?php endif; ?>
                            <form method="post" id="formulario-verificacion">
                                <div class="mb-3">
                                    <label for="verification_code" class="form-label">Código de Verificación</label>
                                    <input type="text" class="form-control" id="verification_code" name="verification_code"
                                        placeholder="Ingresa el código de verificación" required
                                        aria-label="Código de Verificación">
                                </div>
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-warning">Verificar</button>
                                </div>
                            </form>
                        <?php endif; ?>
                        <form action="../controller/iniciar.php" method="post" id="formulario-login">
                            <div class="mb-3">
                                <label for="username" class="form-label">Nombre de Usuario</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Ingresa tu nombre de usuario" required aria-label="Nombre de Usuario">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Ingresa tu contraseña" required aria-label="Contraseña">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary" <?php echo ($_SESSION['stop'] >= 3) ? 'disabled' : ''; ?>>Iniciar Sesión</button>
                            </div>
                            <div class="mt-3 text-center">
                                <a href="controlador.php?seccion=seccion5" class="btn btn-link">Registrarse</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Incluye los enlaces a JavaScript si es necesario -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="../js/verificacion.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>