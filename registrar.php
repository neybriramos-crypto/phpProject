<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $user = $_POST['username'];
    // Aquí el servidor genera el hash compatible con su propia librería
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $depto = $_POST['id_departamento']; 
    $fecha = date('Y-m-d');

    try {
        $sql = "INSERT INTO empleados (nombre, apellido, fecha_ingreso, username, password, id_departamento, salario_base) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $pdo->prepare($sql)->execute([$nombre, $apellido, $fecha, $user, $pass, $depto, 1500.00]);
        echo "<script>alert('Usuario creado con éxito'); window.location='login.php';</script>";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro Temporal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200 flex items-center justify-center h-screen">
    <form method="POST" class="bg-white p-8 rounded shadow-lg w-96">
        <h2 class="text-xl font-bold mb-4">Registro de Emergencia</h2>
        <input type="text" name="nombre" placeholder="Nombre" class="w-full p-2 border mb-2" required>
        <input type="text" name="apellido" placeholder="Apellido" class="w-full p-2 border mb-2" required>
        <input type="text" name="username" placeholder="Usuario" class="w-full p-2 border mb-2" required>
        <input type="password" name="password" placeholder="Contraseña" class="w-full p-2 border mb-2" required>
        
        <label class="block text-sm mb-1">Departamento:</label>
        <select name="id_departamento" class="w-full p-2 border mb-4">
            <option value="6">RRHH (Admin)</option>
            <option value="1">Desarrollo</option>
        </select>
        
        <button type="submit" class="w-full bg-green-600 text-white p-2 rounded">GUARDAR Y PROBAR</button>
        <a href="login.php" class="block text-center mt-2 text-sm text-blue-600">Volver</a>
    </form>
</body>
</html>