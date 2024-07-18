<template>
  <div class="taskIndex" @click="openTaskBar">
    <!-- Alterna o checkBox -->
    <img
      :src="
        require(`../assets/${
          task.checked ? 'CheckActive.png' : 'CheckInactive.png'
        }`)
      "
      class="checkBox"
      @click.stop="toggleCheck"
    />

    <!-- Titulo da Tarefa -->
    <p class="taskTitle">{{ task.title }}</p>

    <!-- Botão de delete -->
    <img
      src="../assets/Delete.png"
      class="deleteButton"
      @click.stop="deleteTask"
    />
  </div>
</template>

<script>
export default {
  name: "TaskIndex",
  props: {
    task: {
      type: Object,
      required: true,
    },
  },

  // Métodos de estado da tarefa
  methods: {
    toggleCheck() {
      this.$emit("toggle-check", this.task);
    },
    openTaskBar() {
      this.$emit("open-taskbar", this.task);
    },
    deleteTask() {
      this.$emit("delete-task", this.task);
    },
  },
};
</script>

<style scoped>
.taskIndex {
  display: flex;
  align-items: center;
  justify-content: space-between;

  padding: 16px;
  margin-top: 20px;
  border-radius: 12px;

  background-color: #45484d;

  width: 100%;
  max-width: 800px;
}

.checkBox,
.deleteButton {
  cursor: pointer;
}

.taskTitle {
  flex: 1;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  margin: 0 20px;
  color: #ffffff;
  cursor: pointer;
}
</style>
