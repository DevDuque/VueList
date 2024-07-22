<?php
// Libera o acesso do Front-End com o servidor
header('Access-Control-Allow-Origin: http://localhost:8081');
header('Access-Control-Allow-Methods: DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Verifica se a requisição é OPTIONS, se for, sai do servidor
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

// Define o cabeçalho de resposta como JSON & Carrega as funções
header('Content-Type: application/json');
require '../../config/database.php';

// Obtém o taskID da URL
$taskID = $_GET['taskID'] ?? null;

// Verifica se o taskID foi fornecido
if (!$taskID) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ERROR: TaskID is required']);
    error_log('TaskID is required');
    exit();
}

// Prepara a requisição para o banco de dados & A executa
$stmt = $conn->prepare("DELETE FROM tasks WHERE taskID = ?");
$stmt->bind_param("s", $taskID);

if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'ERROR: Failed to delete task']);
    error_log('Failed to delete task: ' . $stmt->error);
}


$stmt->close();
$conn->close();
