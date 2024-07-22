<?php

// Define o cabeçalho de resposta como JSON & Carregando as funções
header('Content-Type: application/json');
require '../utils/uuid.php';
require './database.php';

// Insere um usuário exemplo para tabela de usuários
$userID = generateUUID();
$email = "john.doe@gmail.com";
$username = "JohnDoe";
$password = password_hash("Mockup", PASSWORD_BCRYPT);

$insertUser = $conn->prepare("INSERT INTO Users (userID, email, username, password) VALUES (?, ?, ?, ?)");
$insertUser->bind_param("ssss", $userID, $email, $username, $password);

if ($insertUser->execute() === TRUE) {
    echo "John Doe inserted successfully. {MOCKUP} <br>";
} else {
    echo "Error inserting John Doe: " . $conn->error . "{MOCKUP}";
}

// Insere uma tarefa exemplo para tabela de tarefas
$taskID = generateUUID();
$title = "Drink more water";

$insertTask = $conn->prepare("INSERT INTO Tasks (taskID, userID, title, createdAt) VALUES (?, ?, ?, NOW())");
$insertTask->bind_param("sss", $taskID, $userID, $title);

if ($insertTask->execute() === TRUE) {
    echo "Water inserted successfully. {MOCKUP} <br>";
} else {
    echo "Error inserting example task: " . $conn->error . "{MOCKUP}";
}

$conn->close();
