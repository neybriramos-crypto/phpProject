<?php
/**
 * username: neybri
 * password: 123456
 */
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM empleados WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['dept_id'] = $user['id_departamento'];
        $_SESSION['nombre'] = $user['nombre'];
        header("Location: dashboard.php");
    } else {
        $error = "Credenciales incorrectas";
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Nómina</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <form method="POST" class="bg-white p-8 rounded shadow-md w-96">
        <h2 class="text-2xl font-bold mb-4">Iniciar Sesión</h2>
        <?php if(isset($error)) echo "<p class='text-red-500'>$error</p>"; ?>
        <input type="text" name="username" placeholder="Usuario" class="w-full p-2 border mb-4" required>
        <input type="password" name="password" placeholder="Contraseña" class="w-full p-2 border mb-4" required>
        <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded">Entrar</button>
</button>
    </form>
</body>
</html>