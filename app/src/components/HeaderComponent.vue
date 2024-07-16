<template>
  <div class="header">
    <img src="@/assets/LogoIcon.png" alt="LogoApp" />
  </div>
</template>

<script>
export default {
  name: "HeaderComponent",
};
</script>

<!-- Estilização apenas do Header -->
<style scoped>
.header {
  margin-top: 16px;

  display: flex;
  justify-content: center;

  width: 100vw;
  height: 140px;
}
</style>
