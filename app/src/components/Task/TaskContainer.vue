<template>
  <div class="taskContainer">
    <!-- Componente para adicionar uma nova tarefa -->
    <AddTaskSection v-model="newTaskTitle" @add="addTask" />

    <div class="tasksList">
      <!-- Componente para exibir cada tarefa na lista -->
      <TaskIndex
        v-for="task in tasks"
        :key="task.taskID"
        :task="task"
        @toggle-check="toggleCheck(task)"
        @open-taskbar="openTaskBar(task)"
        @delete-task="deleteTask(task)"
        @edit-title="editTitle(task)"
        :close-taskBar="closeTaskBar"
      />
    </div>

    <!-- Barra lateral para detalhes/editar uma tarefa selecionada -->
    <TaskSidebar
      v-if="selectedTask"
      :task="selectedTask"
      @toggle-check="toggleCheck(selectedTask)"
      @toggle-edit-mode="toggleEditMode(selectedTask)"
      @save-edited-title="saveEditedTitle(selectedTask, $event)"
      @delete-task="deleteTask(selectedTask)"
      @close="closeTaskBar"
    />
  </div>
</template>

<script>
import TaskIndex from "./TaskIndex.vue";
import AddTaskSection from "./AddTextSection.vue";
import TaskSidebar from "./TaskSidebar.vue";

export default {
  name: "TaskContainer",
  components: {
    TaskIndex,
    AddTaskSection,
    TaskSidebar,
  },

  data() {
    return {
      // Array para armazenar todas as tarefas
      tasks: [],
      selectedTask: null,
      newTaskTitle: "",
    };
  },

  mounted() {
    // Carrega as tarefas salvas do banco de dados
    this.loadTasks();
  },

  methods: {
    // Define a tarefa selecionada para exibir na barra lateral
    openTaskBar(task) {
      this.selectedTask = task;
    },

    // Limpa a seleção da tarefa na barra lateral
    closeTaskBar() {
      this.selectedTask = null;
    },

    // Alterna o modo de edição da tarefa selecionada
    toggleEditMode(task) {
      task.editMode = !task.editMode;
      if (task.editMode) {
        this.selectedTask.editedTitle = task.title;
      }
    },

    // Carrega as tarefas salvas do usuário logado
    async loadTasks() {
      const userID = localStorage.getItem("userID");
      if (!userID) return;

      try {
        const response = await fetch(
          `http://localhost:8080/database/api/Task/getTasksByUserID.php?userID=${userID}`
        );
        const result = await response.json();

        if (result.success) {
          this.tasks = result.tasks;
        } else {
          alert("ERROR: Não consegui carregar as tarefas");
        }
      } catch (error) {
        alert("ERROR: Não consegui carregar as tarefas");
      }
    },

    // Adiciona uma nova tarefa com o título fornecido
    async addTask(taskTitle) {
      if (taskTitle.trim() !== "") {
        const userID = localStorage.getItem("userID");

        try {
          const response = await fetch(
            "http://localhost:8080/database/api/Task/createTask.php",
            {
              method: "POST",
              headers: {
                "Content-Type": "application/json",
              },
              body: JSON.stringify({ title: taskTitle, userID: userID }),
            }
          );

          const result = await response.json();

          if (result.success) {
            this.loadTasks();
            this.newTaskTitle = "";
          } else {
            alert("ERROR: Não consegui criar tarefa.");
          }
        } catch (error) {
          alert("ERROR: Não consegui salvar tarefa.");
        }
      }
    },

    // Alterna o estado de checkbox (concluído/não concluído) da tarefa fornecida
    async toggleCheck(task) {
      task.checked = !task.checked; // Atualiza o estado localmente

      try {
        const response = await fetch(
          `http://localhost:8080/database/api/Task/updateTaskByID.php?taskID=${task.taskID}`,
          {
            method: "PUT",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              taskID: task.taskID,
              title: task.title,
              checked: task.checked,
            }),
          }
        );

        const result = await response.json();

        if (!result.success) {
          alert("ERROR: Não consegui trocar o check no banco de dados");
        }
      } catch (error) {
        alert("ERROR: Não consegui trocar o check no banco de dados");
      }
    },

    // Salva o título editado da tarefa
    async saveEditedTitle(task, editedTitle) {
      if (editedTitle.trim() !== "") {
        task.title = editedTitle;
        task.editMode = false;

        try {
          await fetch(
            `http://localhost:8080/database/api/Task/updateTaskByID.php?taskID=${task.taskID}`,
            {
              method: "PUT",
              headers: {
                "Content-Type": "application/json",
              },
              body: JSON.stringify({ taskID: task.taskID, title: editedTitle }),
            }
          );
        } catch (error) {
          alert("ERROR: Não consegui editar a tarefa.");
        }
      } else {
        alert("ERROR: Não consegui editar a tarefa");
      }
    },

    // Exclui a tarefa selecionada
    async deleteTask(task) {
      try {
        const response = await fetch(
          `http://localhost:8080/database/api/Task/deleteTaskByID.php?taskID=${task.taskID}`,
          {
            method: "DELETE",
            headers: {
              "Content-Type": "application/json",
            },
          }
        );
        const result = await response.json();

        if (result.success) {
          const index = this.tasks.indexOf(task);
          if (index !== -1) {
            this.tasks.splice(index, 1);
          }
          this.selectedTask = null;
        } else {
          alert("ERROR: Não consegui deletar a tarefa");
        }
      } catch (error) {
        alert("ERROR: Não consegui deletar a tarefa");
      }
    },
  },
};
</script>

<style scoped>
.taskContainer {
  display: flex;
  align-items: center;
  flex-direction: column;
  justify-content: center;

  width: 100%;
  margin-bottom: 50px;
}

.tasksList {
  display: flex;
  align-items: center;
  flex-direction: column;

  width: 100%;
}
</style>
