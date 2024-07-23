<template>
  <div class="sidebar">
    <div class="sidebarContent">
      <!-- Botão para fechar a barra lateral -->
      <img src="@/assets/Close.png" id="closeButton" @click="closeTaskBar" />

      <!-- Exibição da data de criação da tarefa -->
      <p class="createdAt">{{ task.createdAt }}</p>

      <!-- Container do título da tarefa -->
      <div class="titleContainer">
        <!-- Exibição do título da tarefa (modo de visualização) -->
        <template v-if="!task.editMode">
          <p class="titleText">{{ task.title }}</p>
        </template>

        <!-- Edição do título da tarefa (modo de edição) -->
        <template v-else>
          <textarea
            :value="task.title"
            class="editTitleInput"
            @input="updateEditedTitle($event.target.value)"
          ></textarea>
          <button @click="saveEditedTitle">Salvar</button>
        </template>
      </div>

      <!-- Opções da barra lateral (checkbox, editar, deletar) -->
      <div class="sidebarOptions">
        <img :src="getCheckIconSrc()" id="checkBox" @click="toggleCheck" />
        <img
          src="@/assets/Edit.png"
          id="editButton"
          class="editButton"
          @click="toggleEditMode"
        />
        <img src="@/assets/Delete.png" id="deleteButton" @click="deleteTask" />
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "TaskSidebar",
  props: {
    task: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      // Mantém temporariamente o título editado
      editedTitle: "",
    };
  },
  methods: {
    // Emite eventos para o componente pai
    toggleCheck() {
      this.$emit("toggle-check");
    },
    toggleEditMode() {
      this.$emit("toggle-edit-mode");
    },
    saveEditedTitle() {
      this.$emit("save-edited-title", this.editedTitle);
    },
    deleteTask() {
      this.$emit("delete-task");
    },
    closeTaskBar() {
      this.$emit("close");
    },

    // Retorna o caminho da imagem do ícone de checkbox baseado no estado da tarefa
    getCheckIconSrc() {
      return require(`@/assets/${
        this.task.checked ? "CheckActive.png" : "CheckInactive.png"
      }`);
    },

    // Atualiza o título editado conforme o usuário digita no textarea
    updateEditedTitle(value) {
      this.editedTitle = value;
    },
  },
};
</script>
<style scoped>
/* Estilos de Sidebar */
.sidebar {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;

  width: 40%;

  z-index: 999;
  overflow-y: hidden;

  background-color: #45484d;

  border-left: 20px solid #2cda9d;
}

.sidebarContent {
  display: flex;
  flex-direction: column;

  height: 100%;
  padding: 20px;
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

  color: #1a181b;
  background-color: #2cda9d;

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

  max-width: 100%;
  margin-top: 20px;

  text-align: left;
  white-space: normal;
  word-wrap: break-word;
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

/* Estilos para os botões específicos da barra lateral */
#checkBox,
#deleteButton,
#editButton {
  width: 40px;
}

/* Estilo específico para o botão de fechar */
#closeButton {
  position: absolute;

  top: 10px;
  right: 10px;
  cursor: pointer;
}
</style>
