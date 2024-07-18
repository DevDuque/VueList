<template>
  <div class="homePage">
    <div class="header">
      <img src="@/assets/LogoIcon.png" alt="LogoApp" />
    </div>

    <!-- Chama o component de Tarefas -->
    <TaskContainer />

    <FooterContainer />
  </div>
</template>

<script>
import TaskContainer from "@/components/TaskContainer.vue";
import FooterContainer from "@/components/FooterContainer.vue";

export default {
  name: "HomePage",
  components: {
    TaskContainer,
    FooterContainer,
  },
};
</script>

<style scoped>
.homePage {
  margin-top: 16px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
</style>
