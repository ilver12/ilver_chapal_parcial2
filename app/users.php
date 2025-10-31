<?php
header('Content-Type: application/json');

// Configuración de la base de datos desde variables de entorno
$host = getenv('DB_HOST') ?: 'db';
$dbname = getenv('DB_NAME') ?: 'app_db';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASSWORD') ?: 'root';

try {
    // Conexión a MySQL usando PDO
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
    $pdo = new PDO($dsn, $username, $password, $options);
    
    // Determinar el método de la petición
    $method = $_SERVER['REQUEST_METHOD'];
    
    if ($method === 'GET') {
        // GET /users - Listar usuarios
        $stmt = $pdo->query("SELECT id, nombre, email FROM users ORDER BY id DESC");
        $users = $stmt->fetchAll();
        
        echo json_encode([
            'success' => true,
            'data' => $users,
            'count' => count($users)
        ]);
        
    } elseif ($method === 'POST') {
        // POST /users - Agregar nuevo usuario
        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        
        // Validaciones
        if (empty($nombre)) {
            echo json_encode([
                'success' => false,
                'message' => 'El nombre es requerido'
            ]);
            exit;
        }
        
        if (empty($email)) {
            echo json_encode([
                'success' => false,
                'message' => 'El email es requerido'
            ]);
            exit;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode([
                'success' => false,
                'message' => 'El email no es válido'
            ]);
            exit;
        }
        
        // Verificar si el email ya existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetchColumn() > 0) {
            echo json_encode([
                'success' => false,
                'message' => 'El email ya está registrado'
            ]);
            exit;
        }
        
        // Insertar nuevo usuario
        $stmt = $pdo->prepare("INSERT INTO users (nombre, email) VALUES (?, ?)");
        $stmt->execute([$nombre, $email]);
        
        echo json_encode([
            'success' => true,
            'message' => 'Usuario agregado exitosamente',
            'id' => $pdo->lastInsertId()
        ]);
        
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Método no permitido'
        ]);
    }
    
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error de base de datos: ' . $e->getMessage()
    ]);
}
?>
