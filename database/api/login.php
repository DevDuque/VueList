<?php
// Libera o acesso do Front-End com o servidor
header('Access-Control-Allow-Origin: http://localhost:8081');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Verifica se a requisição é OPTIONS, se for, sai do servidor
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

// Definindo o cabeçalho de resposta como JSON
header('Content-Type: application/json');

// Carregando as funções e o banco de dados
require '../utils/uuid.php';
require '../config/database.php';

// Obtém os dados enviados via POST
$data = json_decode(file_get_contents('php://input'), true);

// Verifica se os dados foram carregados corretamente
if (!isset($data['emailUser'], $data['password'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Something went wrong, front-end connection failed!']);
    exit();
}

// Filtrando o email ou username fornecido
$userInput = $data['emailUser'];

// Preparando a consulta para verificar o usuário no banco de dados
$stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE email = ? OR username = ?");
$stmt->bind_param("ss", $userInput, $userInput);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    // Usuário não encontrado
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Something went wrong, user not found!']);
} else {
    // Usuário encontrado, verifica a senha
    $user = $result->fetch_assoc();
    $passwordInput = $data['password'];

    if (password_verify($passwordInput, $user['password'])) {
        // Senha correta, login bem-sucedido
        http_response_code(200);
        echo json_encode(['success' => true, 'user' => $user]);
    } else {
        // Senha incorreta
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Something went wrong, password incorrect!']);
    }
}

// Fecha a conexão com o banco de dados
$stmt->close();
$conn->close();
