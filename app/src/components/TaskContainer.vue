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
            <textarea type="text" v-model="editedTitle" class="editTitleInput">
            </textarea>
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
  font-size: 24px;
  font-weight: bold;
  margin-bottom: 10px;
}

.titleContainer {
  display: flex;
  flex-direction: column;

  align-items: center;

  height: auto;
}

.editTitleInput {
  color: #eeedf0;
  background-color: #45484d;
  width: 100%;
  height: auto;
  padding: 10px;
  margin-top: 30px;
  border: 3px solid #2cda9d;
  border-radius: 12px;
  overflow-y: auto;
}

.titleContainer button {
  width: 30%;

  padding: 12px;
  border-radius: 8px;
  margin-top: 20px;

  align-self: end;
  cursor: pointer;
  outline: none;

  background-color: #2cda9d;
  color: #1a181b;

  font-size: 16px;
  font-weight: bold;
  text-transform: uppercase;
}

.titleContainer button:hover {
  background-color: #1f996e;
  color: #eeedf0;
  transition: background-color 250ms cubic-bezier(0.4, 0, 0.2, 1),
    color 350ms cubic-bezier(0.4, 0, 0.2, 1);
}

.titleText {
  cursor: pointer;

  margin-top: 20px;

  text-align: left;
  word-wrap: break-word;
  overflow-wrap: break-word;
  white-space: pre-line;
}

.editTitleInput {
  width: 100%;
  height: 60%;

  min-height: 150px;

  padding: 24px;
  margin-right: 10px;
  font-size: 16px;
  font-weight: 900;
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
