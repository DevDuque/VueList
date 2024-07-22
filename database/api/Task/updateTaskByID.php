<?php
// Libera o acesso do Front-End com o servidor
header('Access-Control-Allow-Origin: http://localhost:8081');
header('Access-Control-Allow-Methods: PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Verifica se a requisição é OPTIONS, se for, sai do servidor
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}
// Define o cabeçalho de resposta como JSON & Carrega as funções
header('Content-Type: application/json');
require '../../config/database.php';

$data = json_decode(file_get_contents('php://input'), true);

// Verifica se os dados foram carregados corretamente
if (!isset($data['taskID'], $data['title'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ERROR: Missing data']);
    exit();
}

// Adiciona os dados para as variáveis 
$taskID = $data['taskID'];
$title = $data['title'];
$checked = $data['checked'];

// Prepara a requisição para o banco de dados & A executa
$stmt = $conn->prepare("UPDATE tasks SET title = ?, checked = ? WHERE taskID = ?");
$stmt->bind_param("sss", $title, $checked, $taskID);


// Se a execução STMT foi executada, a requisição PUT foi um sucesso
if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'ERROR: Failed to update task']);
}

$stmt->close();
$conn->close();
