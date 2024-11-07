<?php
// Configuración de cabeceras para permitir el acceso desde cualquier origen y recibir JSON
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require('./config/Database.php');
require('./controllers/AuthController.php');
require('./controllers/PostController.php');

// Inicializar conexión a la base de datos
$database = new Database();
$db = $database->connect();

// Obtener método y URL solicitada
$method = $_SERVER['REQUEST_METHOD'];
$requestPath = $_SERVER['PATH_INFO'] ?? ''; // Si no existe, se establece como una cadena vacía
$request = explode('/', trim($requestPath, '/'));
$endpoint = $request[0];
$data = json_decode(file_get_contents("php://input"), true);
switch ($endpoint) {
    case 'register':
        if ($method == 'POST') {
            $authController = new AuthController($db);
            echo $authController->register($data);
        } else {
            echo json_encode(['message' => 'Método no permitido']);
        }
        break;

    case 'login':
        if ($method == 'POST') {
            $authController = new AuthController($db);
            echo $authController->login($data);
        } else {
            echo json_encode(['message' => 'Método no permitido']);
        }
        break;

    case 'createpost':
        $postController = new PostController($db);

        // Validar token de autenticación (simple, basado en token en cabecera)
        $headers = getallheaders();
        $token = isset($headers['Authorization']) ? base64_decode($headers['Authorization']) : null;
        if ($method == 'POST' && $data['userid']) {
            echo $postController->create($data, $data['userid']);
        } elseif ($method == 'GET' && isset($request[1])) {
            $categoryId = intval($request[1]);
            echo $postController->getByCategory($categoryId);
        } else {
            echo json_encode(['message' => 'Método o token inválido']);
        }
        break;

        case 'postlist':
            $postController = new PostController($db);
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if (isset($request[1]) && is_numeric($request[1])) {
                    // GET /api/posts/{categoryid}
                    $categoryId = intval($request[1]);
                    $postController->getPostsByCategory($categoryId);
                }else{
                    // GET /api/posts
                    $postController->getAllPosts();
                }
            }
            break;

    default:
        echo json_encode(['message' => 'Endpoint no encontrado']);
}
?>
