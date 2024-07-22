<?php

// Define o cabeçalho de resposta como JSON & Carregando as funções
header('Content-Type: application/json');
require '../utils/uuid.php';
require './database.php';

// Cria a tabela de usuários
$createUsersTable = "
CREATE TABLE IF NOT EXISTS Users (
    userID CHAR(36) NOT NULL PRIMARY KEY,
    email VARCHAR(191) NOT NULL UNIQUE,
    username VARCHAR(191) NOT NULL UNIQUE,
    password VARCHAR(191) NOT NULL
)";

// Verifica se os dados foram enviados corretamente
if ($conn->query($createUsersTable) === TRUE) {
    echo "Users table created successfully.<br>";
} else {
    echo "Error creating Users table: " . $conn->error . "<br>";
}

// Cria a tabela de tarefas
$createTasksTable = "
CREATE TABLE IF NOT EXISTS Tasks (
    taskID CHAR(36) NOT NULL PRIMARY KEY,
    userID CHAR(36) NOT NULL,
    title VARCHAR(191) NOT NULL,
    checked BOOLEAN NOT NULL DEFAULT FALSE,
    createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userID) REFERENCES Users(userID)
)";

// Verifica se os dados foram enviados corretamente
if ($conn->query($createTasksTable) === TRUE) {
    echo "Tasks table created successfully.<br>";
} else {
    echo "Error creating Tasks table: " . $conn->error . "<br>";
}

// Fecha a conexão com o banco de dados
$conn->close();
