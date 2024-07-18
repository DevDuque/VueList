<?php
// Libera o acesso do Front-End com o servidor
header('Access-Control-Allow-Origin: http://localhost:8081');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Verifica se a requisição é OPTIONS, se for, sai do servidor
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

// Definindo o cabeçalho de resposta como JSON e carregando as funções
header('Content-Type: application/json');
require '../utils/uuid.php';
require '../config/database.php';

// Pega os dados enviados
$data = json_decode(file_get_contents('php://input'), true);

// Verifica se os dados foram carregados corretamente
if (!isset($data['emailUser'], $data['username'], $data['password'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit();
}

// Adicionando os dados para as variáveis 
$email = $data['emailUser'];
$username = $data['username'];

// Encriptografando a senha com Hash BCRYPT
$password = password_hash($data['password'], PASSWORD_BCRYPT);

// Gerando o UUID
$uuid = generateUUID();

// Preparando a requisição POST para o banco de dados e executando-a
$stmt = $conn->prepare("INSERT INTO users (id, username, email, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $uuid, $username, $email, $password);

// Se a execução STMT foi executada, a requisição POST foi um sucesso
if ($stmt->execute()) {
    http_response_code(201);
    echo json_encode(['success' => true]);
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Error: ' . $stmt->error]);
}

// Fecha a conexão com o banco de dados 
$stmt->close();
$conn->close();
