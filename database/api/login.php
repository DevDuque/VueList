<?php
// Libera o acesso do Front-End com o servidor
header('Access-Control-Allow-Origin: http://localhost:8081');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Verifica se a requisição é OPTIONS, se for, sai do servidor
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit();
}

// Define o cabeçalho de resposta como JSON & Carrega as funções
header('Content-Type: application/json');
require '../utils/uuid.php';
require '../config/database.php';

// Obtém os dados enviados via POST
$data = json_decode(file_get_contents('php://input'), true);

// Verifica se os dados foram carregados corretamente
if (!isset($data['emailUser'], $data['password'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ERROR: Missing emailUser or password.']);
    exit();
}

// Filtra o email ou username fornecido
$userInput = $data['emailUser'];

// Prepara a consulta para verificar o usuário no banco de dados
$stmt = $conn->prepare("SELECT userID, username, email, password FROM Users WHERE email = ? OR username = ?");
$stmt->bind_param("ss", $userInput, $userInput);
if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'ERROR: Database execution error.']);
    exit();
}

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    // Usuário não encontrado
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'ERROR: User not found.']);
} else {
    // Usuário encontrado, verifica a senha
    $user = $result->fetch_assoc();
    $passwordInput = $data['password'];

    if (password_verify($passwordInput, $user['password'])) {
        // Senha correta, login bem-sucedido

        // Preparando a consulta para obter as tarefas do usuário
        $userId = $user['userID']; // Ensure correct field name
        $tasksStmt = $conn->prepare("SELECT taskID, userID, title, createdAt, checked FROM Tasks WHERE userID = ?");
        $tasksStmt->bind_param("s", $userId);
        if (!$tasksStmt->execute()) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'ERROR: Database execution error fetching tasks.']);
            exit();
        }
        $tasksResult = $tasksStmt->get_result();

        $tasks = [];
        while ($task = $tasksResult->fetch_assoc()) {
            $tasks[] = $task;
        }

        // Fecha a conexão com o banco de dados
        $tasksStmt->close();

        // Envia a resposta com os dados do usuário e suas tarefas
        http_response_code(200);
        echo json_encode(['success' => true, 'user' => $user, 'tasks' => $tasks]);
    } else {
        // Senha incorreta
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'ERROR: Incorrect password.']);
    }
}

// Fecha a conexão com o banco de dados
$stmt->close();
$conn->close();
