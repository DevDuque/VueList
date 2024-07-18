<template>
  <div class="footerContainer">
    <p>
      Criado com
      <img
        src="@/assets/Heart.png"
        alt="IconeCoração"
        class="heartIcon"
        @mouseover="startRotate"
        @mouseleave="stopRotate"
      />
      por <a href="https://github.com/DevDuque">DevDuque</a>
    </p>
  </div>
</template>

<script>
export default {
  name: "FooterContainer",
  // Metódos para rotacionar o coração quando colocar o mouse
  methods: {
    startRotate(event) {
      event.target.classList.add("rotate");
    },
    stopRotate(event) {
      event.target.classList.remove("rotate");
    },
  },
};
</script>

<style scoped>
.footerContainer {
  position: fixed;
  bottom: 0;
  left: 0;

  display: flex;
  justify-content: center;
  align-items: center;

  width: 100%;
}

.heartIcon {
  vertical-align: middle;
  transition: transform 0.3s ease;
}

.rotate {
  animation: rotateHeart 0.12s linear infinite;
}

@keyframes rotateHeart {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

.footerContainer a {
  color: #2cda9d;
  text-decoration: none;
}

.footerContainer a:hover {
  color: #1f996e;
  transition: color 350ms cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
