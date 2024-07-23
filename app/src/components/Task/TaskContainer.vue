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
import {
  createTask,
  getTasksByUserID,
  updateTask,
  saveEditedTitle,
  deleteTask,
} from "../../utils/taskService";

export default {
  name: "TaskContainer",
  components: {
    TaskIndex,
    AddTaskSection,
    TaskSidebar,
  },

  data() {
    return {
      tasks: [],
      selectedTask: null,
      newTaskTitle: "",
    };
  },

  mounted() {
    this.loadTasks();
  },

  methods: {
    openTaskBar(task) {
      this.selectedTask = task;
    },

    closeTaskBar() {
      this.selectedTask = null;
    },

    toggleEditMode(task) {
      task.editMode = !task.editMode;
      if (task.editMode) {
        this.selectedTask.editedTitle = task.title;
      }
    },

    async loadTasks() {
      const userID = localStorage.getItem("userID");
      if (!userID) return;

      try {
        const result = await getTasksByUserID(userID);
        if (result.success) {
          this.tasks = result.tasks;
        } else {
          alert("ERROR: Não consegui carregar as tarefas");
        }
      } catch (error) {
        alert(error.message);
      }
    },

    async addTask(taskTitle) {
      if (taskTitle.trim() !== "") {
        const userID = localStorage.getItem("userID");

        try {
          const result = await createTask(taskTitle, userID);
          if (result.success) {
            this.loadTasks();
            this.newTaskTitle = "";
          } else {
            alert("ERROR: Não consegui criar tarefa.");
          }
        } catch (error) {
          alert(error.message);
        }
      }
    },

    async toggleCheck(task) {
      task.checked = !task.checked;

      try {
        const result = await updateTask(task);
        if (!result.success) {
          alert("ERROR: Não consegui trocar o check no banco de dados");
        }
      } catch (error) {
        alert(error.message);
      }
    },

    async saveEditedTitle(task, editedTitle) {
      if (editedTitle.trim() !== "") {
        task.title = editedTitle;
        task.editMode = false;

        try {
          await saveEditedTitle(task.taskID, editedTitle);
        } catch (error) {
          alert(error.message);
        }
      } else {
        alert("ERROR: Não consegui editar a tarefa");
      }
    },

    async deleteTask(task) {
      try {
        const result = await deleteTask(task.taskID);
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
        alert(error.message);
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
