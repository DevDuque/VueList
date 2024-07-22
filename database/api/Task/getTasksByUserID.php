<?php
// Libera o acesso do Front-End com o servidor
header('Access-Control-Allow-Origin: http://localhost:8081');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Verifica se a requisição é OPTIONS, se for, sai do servidor
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

// Define o cabeçalho de resposta como JSON & Carrega as funções
header('Content-Type: application/json');
require '../../config/database.php';

// Obtém o taskID da URL
$userID = $_GET['userID'] ?? null;

// Verifica se os dados foram carregados corretamente
if (empty($userID)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ERROR: UserID is required.']);
    exit();
}

// Prepara a requisição para o banco de dados & A executa
$stmt = $conn->prepare("SELECT taskID, title, createdAt, checked FROM tasks WHERE userID = ?");

// Se a execução STMT foi executada, a requisição GET foi um sucesso
if (!$stmt) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'ERROR: Database preparation error.']);
    exit();
}

// Se a execução STMT com userID foi executada, a requisição GET foi um sucesso
$stmt->bind_param("s", $userID);
if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'ERROR: Database execution error.']);
    exit();
}


// Se a execução STMT foi executada, a requisição GET foi um sucesso
$result = $stmt->get_result();
if (!$result) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'ERROR: Fetching results.']);
    exit();
}

// Converte o resultado da consulta para um array & Armazena em $tasks
$tasks = [];
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

// Se nenhuma tarefa for encontrada, retorna uma resposta apropriada
if (empty($tasks)) {
    echo json_encode(['success' => true, 'message' => 'ERROR: No tasks found for this user.']);
} else {
    echo json_encode(['success' => true, 'tasks' => $tasks]);
}

// Fecha a conexão com o banco de dados 
$stmt->close();
$conn->close();
