<?php
require 'db.php';
session_start();

if (!isset($_SESSION['dept_id']) || $_SESSION['dept_id'] != 6) {
    die("Acceso restringido: Solo personal de RRHH puede gestionar empleados.");
}

if (isset($_GET['eliminar'])) {
    $id_a_eliminar = $_GET['eliminar'];
    
    if ($id_a_eliminar == $_SESSION['user_id']) {
        echo "<script>alert('¡Error! No puedes eliminar tu propia cuenta de administrador.'); window.location='gestion_empleados.php';</script>";
        exit();
    } else {
        $stmt = $pdo->prepare("DELETE FROM empleados WHERE id = ?");
        $stmt->execute([$id_a_eliminar]);
        header("Location: gestion_empleados.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['crear'])) {
    $pass = password_hash('12345', PASSWORD_DEFAULT);
    $sql = "INSERT INTO empleados (nombre, apellido, fecha_ingreso, username, password, id_departamento, salario_base) VALUES (?,?,?,?,?,?,?)";
    $pdo->prepare($sql)->execute([
        $_POST['nombre'], $_POST['apellido'], $_POST['fecha'], 
        $_POST['user'], $pass, $_POST['depto'], $_POST['salario']
    ]);
    header("Location: gestion_empleados.php");
    exit();
}
$empleados = $pdo->query("SELECT e.*, d.nombre as depto FROM empleados e JOIN departamentos d ON e.id_departamento = d.id ORDER BY e.id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Personal - LEXPIN</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-6 md:p-10">

    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-blue-900 italic">Administración de Personal</h1>
            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">Sesión: <?php echo $_SESSION['user_id']; ?></span>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-sm mb-10 border-t-4 border-green-500">
            <h2 class="text-lg font-semibold mb-4 text-gray-700">Registrar Nuevo Trabajador</h2>
            <form method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" name="nombre" placeholder="Nombre" class="border p-2 rounded focus:ring-2 focus:ring-green-400 outline-none" required>
                <input type="text" name="apellido" placeholder="Apellido" class="border p-2 rounded focus:ring-2 focus:ring-green-400 outline-none" required>
                <input type="date" name="fecha" class="border p-2 rounded focus:ring-2 focus:ring-green-400 outline-none" required>
                <input type="text" name="user" placeholder="Nombre de Usuario" class="border p-2 rounded focus:ring-2 focus:ring-green-400 outline-none" required>
                
                <select name="depto" class="border p-2 rounded bg-white focus:ring-2 focus:ring-green-400 outline-none">
                    <option value="1">Desarrollo</option>
                    <option value="2">Diseño</option>
                    <option value="3">QA (Calidad)</option>
                    <option value="4">Marketing</option>
                    <option value="5">Contabilidad</option>
                    <option value="6" selected>Recursos Humanos</option>
                </select>
                
                <input type="number" step="0.01" name="salario" placeholder="Salario Base" class="border p-2 rounded focus:ring-2 focus:ring-green-400 outline-none" required>
                
                <button type="submit" name="crear" class="bg-green-600 hover:bg-green-700 text-white p-3 rounded col-span-1 md:col-span-3 font-bold transition-all shadow-md">
                    + Agregar a la Nómina
                </button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="p-4 uppercase text-xs font-bold">Empleado</th>
                        <th class="p-4 uppercase text-xs font-bold">Departamento</th>
                        <th class="p-4 uppercase text-xs font-bold">Fecha Ingreso</th>
                        <th class="p-4 uppercase text-xs font-bold text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach($empleados as $emp): ?>
                    <tr class="hover:bg-blue-50 transition-colors">
                        <td class="p-4">
                            <div class="font-bold text-gray-800"><?php echo $emp['nombre']." ".$emp['apellido']; ?></div>
                            <div class="text-xs text-gray-400">@<?php echo $emp['username']; ?></div>
                        </td>
                        <td class="p-4">
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">
                                <?php echo $emp['depto']; ?>
                            </span>
                        </td>
                        <td class="p-4 text-gray-600 text-sm italic"><?php echo $emp['fecha_ingreso']; ?></td>
                        <td class="p-4 text-center">
                            <a href="editar_empleado.php?id=<?php echo $emp['id']; ?>" class="text-blue-600 hover:text-blue-800 font-bold mr-4 transition">Editar</a>
                            
                            <?php if ($emp['id'] != $_SESSION['user_id']): ?>
                                <button onclick="openModal(<?php echo $emp['id']; ?>, '<?php echo $emp['nombre'].' '.$emp['apellido']; ?>')" 
                                        class="text-red-500 hover:text-red-700 font-bold transition">
                                    Eliminar
                                </button>
                            <?php else: ?>
                                <span class="text-gray-400 text-xs italic font-semibold underline decoration-dotted">Tú (Admin)</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-8">
            <a href="dashboard.php" class="inline-flex items-center text-blue-600 hover:text-blue-900 font-bold">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Regresar al Panel Principal
            </a>
        </div>
    </div>

    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 transform transition-all">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6">
                    <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 14c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-2 italic">¿CONFIRMAR BAJA?</h3>
                <p id="deleteMessage" class="text-gray-500 mb-8 leading-relaxed">
                    Estás a punto de eliminar a este trabajador del sistema. Esta acción es irreversible.
                </p>
            </div>
            <div class="flex flex-col md:flex-row space-y-3 md:space-y-0 md:space-x-4">
                <button onclick="closeModal()" class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 font-bold transition">
                    No, Cancelar
                </button>
                <a id="confirmDeleteBtn" href="#" class="flex-1 px-4 py-3 bg-red-600 text-white text-center rounded-xl hover:bg-red-700 font-bold transition shadow-lg shadow-red-200">
                    SÍ, ELIMINAR
                </a>
            </div>
        </div>
    </div>

    <script>
        function openModal(id, nombreCompleto) {
            const modal = document.getElementById('deleteModal');
            const btn = document.getElementById('confirmDeleteBtn');
            const msg = document.getElementById('deleteMessage');
            
            btn.href = 'gestion_empleados.php?eliminar=' + id;
            msg.innerHTML = '¿Estás 100% segura de que deseas eliminar a <b>' + nombreCompleto + '</b> de la base de datos de Ruta Larga?';
            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
        window.onclick = function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target == modal) closeModal();
        }
    </script>
</body>
</html>