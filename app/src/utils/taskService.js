// Define a URL base para as requisições API
const API_URL = "http://localhost:8080/database/api/Task/";

// Função para criar uma nova tarefa
export async function createTask(taskTitle, userID) {
  try {
    // Faz uma requisição POST para criar uma nova tarefa
    const response = await fetch(`${API_URL}createTask.php`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json", // Define o tipo de conteúdo como JSON
      },
      // Envia os dados da tarefa como JSON
      body: JSON.stringify({ title: taskTitle, userID: userID }),
    });
    // Retorna a resposta da requisição convertida para JSON
    return await response.json();
  } catch (error) {
    // Captura e lança um erro se a requisição falhar
    throw new Error(
      "ERROR: Não consegui salvar tarefa, algo ocorreu no Back-End!"
    );
  }
}

// Função para obter tarefas associadas a um usuário específico
export async function getTasksByUserID(userID) {
  try {
    // Faz uma requisição GET para obter as tarefas do usuário
    const response = await fetch(
      `${API_URL}getTasksByUserID.php?userID=${userID}`
    );
    // Retorna a resposta da requisição convertida para JSON
    return await response.json();
  } catch (error) {
    // Captura e lança um erro se a requisição falhar
    throw new Error(
      "ERROR: Não consegui carregar as tarefas, algo ocorreu no Back-End!"
    );
  }
}

// Função para atualizar uma tarefa existente
export async function updateTask(task) {
  try {
    // Faz uma requisição PUT para atualizar uma tarefa específica
    const response = await fetch(
      `${API_URL}updateTaskByID.php?taskID=${task.taskID}`,
      {
        method: "PUT",
        headers: {
          "Content-Type": "application/json", // Define o tipo de conteúdo como JSON
        },

        // Envia os dados da tarefa editada como JSON
        body: JSON.stringify({
          taskID: task.taskID,
          title: task.title,
          checked: task.checked,
        }),
      }
    );
    return await response.json(); // Retorna a resposta da requisição convertida para JSON
  } catch (error) {
    // Captura e lança um erro se a requisição falhar
    throw new Error(
      "ERROR: Não consegui atualizar a tarefa, algo ocorreu no Back-End!"
    );
  }
}

// Função para salvar o título editado de uma tarefa
export async function saveEditedTitle(taskID, editedTitle) {
  try {
    // Faz uma requisição PUT para atualizar o título de uma tarefa
    await fetch(`${API_URL}updateTaskByID.php?taskID=${taskID}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json", // Define o tipo de conteúdo como JSON
      },

      // Envia os dados da tarefa editada como JSON
      body: JSON.stringify({ taskID: taskID, title: editedTitle }),
    });
  } catch (error) {
    // Captura e lança um erro se a requisição falhar
    throw new Error(
      "ERROR: Não consegui editar a tarefa, algo ocorreu no Back-End!"
    );
  }
}

// Função para deletar uma tarefa
export async function deleteTask(taskID) {
  try {
    // Faz uma requisição DELETE para remover uma tarefa específica
    const response = await fetch(
      `${API_URL}deleteTaskByID.php?taskID=${taskID}`,
      {
        method: "DELETE",
        headers: {
          "Content-Type": "application/json", // Define o tipo de conteúdo como JSON
        },
      }
    );
    // Retorna a resposta da requisição convertida para JSON
    return await response.json();
  } catch (error) {
    // Captura e lança um erro se a requisição falhar
    throw new Error("ERROR: Não consegui deletar, algo ocorreu no Back-End!");
  }
}
