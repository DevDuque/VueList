<template>
  <div id="app">
    <HeaderComponent />
  </div>
</template>

<script>
// Importação do HeaderComponent
import HeaderComponent from "./components/HeaderComponent.vue";

export default {
  name: "App",
  components: {
    // Definição do HeaderComponent como uma propriedade do componente App
    HeaderComponent,
  },
};
</script>

<style></style>
