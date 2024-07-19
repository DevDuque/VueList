<template>
  <div class="addDiv">
    <div class="addContainer">
      <!-- Textarea para inserir nova tarefa -->
      <textarea
        v-model="newTaskTitle"
        type="text"
        class="addInput"
        placeholder="Adicione um novo item"
      ></textarea>

      <!-- Botão para adicionar nova tarefa -->
      <button id="addButton" @click="addNewTask">
        Add
        <img src="../assets/AddIcon.png" alt="AddButton" />
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "AddTaskSection",
  props: {
    value: String,
  },
  data() {
    return {
      newTaskTitle: "",
    };
  },
  methods: {
    addNewTask() {
      // Método para adicionar nova tarefa
      // Emite evento "add" com o título da nova tarefa
      this.$emit("add", this.newTaskTitle);

      // Limpa o título da nova tarefa após emitir o evento
      this.newTaskTitle = "";
    },
  },
};
</script>

<style scoped>
.addDiv {
  display: flex;
  align-items: center;
  justify-content: space-between;

  padding: 16px;
  margin-top: 20px;
  border-radius: 12px;
  border-left: 32px solid #2cda9d;

  width: 100%;
  max-width: 800px;
  background-color: #45484d;
}

.addContainer {
  display: flex;
  flex: 1;

  align-items: center;
  justify-content: space-between;
}

.addInput {
  width: 60%;
  max-height: 50px;

  padding: 12px;
  color: #eeedf0;
  font-size: 20px;

  background-color: transparent;

  outline: none;
  resize: vertical;
  overflow-y: hidden;
}

#addButton {
  display: flex;
  align-items: center;
  align-self: flex-end;
  justify-content: space-between;

  width: 16%;
  padding: 12px;
  border-radius: 12px;
  border: 4px solid #2cda9d;

  color: #eeedf0;
  font-size: 20px;
  font-weight: 900;
  text-transform: uppercase;

  background-color: transparent;
  cursor: pointer;
}

#addButton img {
  align-self: flex-end;
  vertical-align: middle;
}
</style>
