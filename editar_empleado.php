<?php
require 'db.php';
session_start();
if ($_SESSION['dept_id'] != 6) die("Acceso denegado");

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM empleados WHERE id = ?");
$stmt->execute([$id]);
$emp = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "UPDATE empleados SET nombre=?, apellido=?, id_departamento=?, salario_base=? WHERE id=?";
    $pdo->prepare($sql)->execute([
        $_POST['nombre'], $_POST['apellido'], $_POST['depto'], $_POST['salario'], $id
    ]);
    header("Location: gestion_empleados.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Empleado</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Editar Datos de <?php echo $emp['nombre']; ?></h2>
        <form method="POST">
            <input type="text" name="nombre" value="<?php echo $emp['nombre']; ?>" class="w-full border p-2 mb-2">
            <input type="text" name="apellido" value="<?php echo $emp['apellido']; ?>" class="w-full border p-2 mb-2">
            <select name="depto" class="w-full border p-2 mb-2">
                <option value="1" <?php if($emp['id_departamento']==1) echo 'selected'; ?>>Desarrollo</option>
                <option value="6" <?php if($emp['id_departamento']==6) echo 'selected'; ?>>RRHH</option>
                </select>
            <input type="number" name="salario" value="<?php echo $emp['salario_base']; ?>" class="w-full border p-2 mb-4">
            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded">Actualizar Datos</button>
            <a href="gestion_empleados.php" class="block text-center mt-2 text-gray-500">Cancelar</a>
        </form>
    </div>
</body>
</html>