<template>
  <div class="taskContainer">
    <!-- Listas de tarefas -->
    <div class="tasksList">
      <!-- Criando componentes estáticos e definindo as funcionalidades-->
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

    <!-- Sidebar -->
    <div v-if="selectedTask" class="sidebar">
      <div class="sidebarContent">
        <img src="@/assets/Close.png" id="closeButton" @click="closeTaskBar" />
        <p class="createdAt">{{ selectedTask.createdAt }}</p>
        <div class="titleContainer">
          <template v-if="!selectedTask.editMode">
            <p class="titleText">{{ selectedTask.title }}</p>
          </template>
          <template v-else>
            <input type="text" v-model="editedTitle" class="editTitleInput" />
            <button @click="saveEditedTitle(selectedTask)">Save</button>
          </template>
        </div>

        <!-- Footer do Sidedbar -->
        <div class="sidebarOptions">
          <img
            :src="
              require(`@/assets/${
                selectedTask.checked ? 'CheckActive.png' : 'CheckInactive.png'
              }`)
            "
            id="checkBox"
            @click="toggleCheck(selectedTask)"
          />

          <img
            src="@/assets/Edit.png"
            id="editButton"
            class="editButton"
            @click="toggleEditMode(selectedTask)"
          />

          <img
            src="@/assets/Delete.png"
            id="deleteButton"
            @click="deleteTask(selectedTask)"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import TaskIndex from "./TaskIndex.vue";

export default {
  name: "TaskContainer",
  components: {
    TaskIndex,
  },

  data() {
    return {
      // Criando tarefas estáticas
      tasks: [
        {
          title:
            "Lorem ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups. LOREM IPSUM GE",
          checked: false,
          createdAt: "18/07/2024 10:30 AM",
          editMode: false,
        },
        {
          title: "Task 2",
          checked: false,
          createdAt: "18/08/2022 10:30 AM",
          editMode: false,
        },
        {
          title: "Task 3",
          checked: false,
          createdAt: "18/08/2022 10:30 AM",
          editMode: false,
        },
      ],
      selectedTask: null,
      editedTitle: "",
    };
  },

  // Métodos de estado das tarefas
  methods: {
    // Alterna o estado do CheckBox
    toggleCheck(task) {
      task.checked = !task.checked;
    },

    // Abre a barra da tarefa clicada
    openTaskBar(task) {
      this.selectedTask = task;
      this.editedTitle = task.title;
    },

    // Fecha a barra da tarefa
    closeTaskBar() {
      this.selectedTask = null;
    },

    // Edita o título da tarefa
    editTitle(task) {
      this.selectedTask = task;
      this.editedTitle = task.title;
    },

    // Alterna o modo de edição do título da tarefa
    toggleEditMode(task) {
      task.editMode = !task.editMode;
    },

    // Salva o título editado da tarefa
    saveEditedTitle(task) {
      task.title = this.editedTitle;
      task.editMode = false;
    },

    // Deleta a tarefa clicada
    deleteTask(task) {
      const index = this.tasks.indexOf(task);
      if (index !== -1) {
        this.tasks.splice(index, 1);
        this.selectedTask = null;
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

.sidebar {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  width: 40%;
  background-color: #45484d;
  z-index: 999;
  overflow-y: hidden;
}

.sidebarContent {
  padding: 20px;
  display: flex;
  flex-direction: column;
  height: 100%;
}

.createdAt {
  font-weight: bold;
  margin-bottom: 10px;
}

.titleContainer {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
}

.titleText {
  cursor: pointer;
  margin-right: 20px;
}

.editTitleInput {
  flex: 1;
  padding: 5px;
  margin-right: 10px;
}

.editButton {
  width: 20px;
  cursor: pointer;
  margin-left: 10px;
}

.sidebarOptions {
  display: flex;
  justify-content: space-around;
  margin-top: auto;
}

.sidebarOptions img {
  cursor: pointer;
}

#checkBox,
#deleteButton,
#editButton {
  width: 40px;
}

#closeButton {
  position: absolute;
  top: 10px;
  right: 10px;
  cursor: pointer;
}
</style>
