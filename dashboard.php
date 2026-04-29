<?php
require 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) header("Location: login.php");

$stmt = $pdo->prepare("SELECT e.*, d.nombre as depto FROM empleados e 
                       JOIN departamentos d ON e.id_departamento = d.id 
                       WHERE e.id = ?");
$stmt->execute([$_SESSION['user_id']]);
$u = $stmt->fetch();

$total = $u['salario_base'] + $u['bonos'] + $u['pago_festivos'] + $u['pago_horas_extras'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-10">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Bienvenido, <?php echo $u['nombre']; ?></h1>
            <a href="logout.php" class="text-red-500">Cerrar Sesión</a>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div class="border p-4 rounded">
                <h3 class="font-bold border-b mb-2">Información Personal</h3>
                <p><strong>Apellido:</strong> <?php echo $u['apellido']; ?></p>
                <p><strong>Ingreso:</strong> <?php echo $u['fecha_ingreso']; ?></p>
            </div>
            <div class="border p-4 rounded">
                <h3 class="font-bold border-b mb-2">Información Laboral</h3>
                <p><strong>Departamento:</strong> <?php echo $u['depto']; ?></p>
                <p><strong>Salario Base:</strong> $<?php echo $u['salario_base']; ?></p>
                <p><strong>Bonos/Extras:</strong> $<?php echo $u['bonos'] + $u['pago_festivos'] + $u['pago_horas_extras']; ?></p>
                <p class="text-xl mt-2 font-bold text-green-600">Total: $<?php echo $total; ?></p>
            </div>
        </div>

        <?php if ($_SESSION['dept_id'] == 6):  ?>
            <div class="mt-10">
                <h2 class="text-xl font-bold mb-4">Panel de Control RRHH</h2>
                <a href="gestion_empleados.php" class="bg-blue-600 text-white px-4 py-2 rounded">Gestionar Empleados</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>