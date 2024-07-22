<template>
  <div class="taskIndex" @click="handleTaskClick">
    <img
      :src="getCheckIconSrc()"
      class="checkBox"
      :alt="isChecked ? 'Checked' : 'Unchecked'"
      @click.stop="toggleCheck"
    />

    <p class="taskTitle">{{ task.title }}</p>

    <img
      src="../../assets/Delete.png"
      class="deleteButton"
      alt="Delete"
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
  computed: {
    isChecked() {
      return this.task.checked;
    },
  },
  methods: {
    // Emite eventos para o componente pai
    toggleCheck() {
      this.$emit("toggle-check", this.task);
    },
    handleTaskClick() {
      this.$emit("open-taskbar", this.task);
    },
    deleteTask() {
      this.$emit("delete-task", this.task);
    },
    getCheckIconSrc() {
      return require(`../../assets/${
        this.isChecked ? "CheckActive.png" : "CheckInactive.png"
      }`);
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
