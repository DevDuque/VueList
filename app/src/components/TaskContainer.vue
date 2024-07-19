<template>
  <div class="taskContainer">
    <!-- Componente para adicionar uma nova tarefa -->
    <AddTaskSection v-model="newTaskTitle" @add="addTask" />

    <div class="tasksList">
      <!-- Componente para exibir cada tarefa na lista -->
      <TaskIndex
        v-for="(task, index) in tasks"
        :key="index"
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
    // Carrega as tarefas salvas do localStorage ao montar o componente
    this.loadTasks();
  },

  methods: {
    // Carrega as tarefas salvas do localStorage
    loadTasks() {
      const savedTasks = localStorage.getItem("tasks");
      this.tasks = savedTasks ? JSON.parse(savedTasks) : [];
    },

    // Salva as tarefas no localStorage
    saveTasks() {
      localStorage.setItem("tasks", JSON.stringify(this.tasks));
    },

    // Adiciona uma nova tarefa com o título fornecido
    addTask(taskTitle) {
      if (taskTitle.trim() !== "") {
        const newTask = {
          title: taskTitle,
          checked: false,
          createdAt: new Date().toLocaleString("pt-BR"),
          editMode: false,
        };
        this.tasks.push(newTask);
        this.saveTasks();
        this.newTaskTitle = "";
      }
    },

    // Alterna o estado de checkbox (concluído/não concluído) da tarefa fornecida
    toggleCheck(task) {
      task.checked = !task.checked;
      this.saveTasks();
    },

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
      // Alterna o modo de edição para a tarefa selecionada
      task.editMode = !task.editMode;
      // Se entrar no modo de edição, inicializa editedTitle com o título atual da tarefa
      if (task.editMode) {
        this.selectedTask.editedTitle = task.title;
      }
    },

    // Salva o título editado da tarefa
    saveEditedTitle(task, editedTitle) {
      // Salva o título editado na tarefa
      if (editedTitle.trim() !== "") {
        task.title = editedTitle;
      } else {
        // Cancela a operação de salvamento se o título estiver vazio
        alert("O título não pode estar vazio!");
        return;
      }
      // Sai do modo de edição
      task.editMode = false;
      // Salva as tarefas atualizadas no localStorage
      this.saveTasks();
    },

    // Exclui a tarefa fornecida
    deleteTask(task) {
      const index = this.tasks.indexOf(task);
      if (index !== -1) {
        this.tasks.splice(index, 1);
        this.selectedTask = null;
        this.saveTasks();
      }
    },
  },
};
</script>
<style scoped>
.taskContainer {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  margin-bottom: 50px;
  width: 100%;
}

.tasksList {
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
}
</style>
