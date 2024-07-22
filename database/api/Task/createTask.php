<?php
// Libera o acesso do Front-End com o servidor
header('Access-Control-Allow-Origin: http://localhost:8081');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Verifica se a requisição é OPTIONS, se for, sai do servidor
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

// Define o cabeçalho de resposta como JSON & Carrega a função
header('Content-Type: application/json');
require '../../config/database.php';
require '../../utils/uuid.php';

// Pega os dados enviados
$data = json_decode(file_get_contents('php://input'), true);

// Verifica se os dados foram carregados corretamente
if (!isset($data['title'], $data['userID'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ERROR: Missing data']);
    exit();
}

$taskID = generateUUID();
$title = $data['title'];
$userID = $data['userID'];
$createdAt = date('Y-m-d H:i:s');

// Prepara a requisição POST para o banco de dados & A executa
$stmt = $conn->prepare("INSERT INTO tasks (taskID, userID, title, createdAt) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $taskID, $userID, $title, $createdAt);

// Se a execução STMT foi executada, a requisição POST foi um sucesso
if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(['success' => true, 'taskID' => $taskID]);
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ERROR: Failed to create task!']);
}

// Fecha a conexão com o banco de dados 
$stmt->close();
$conn->close();
