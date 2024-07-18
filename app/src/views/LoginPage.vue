<template>
  <div class="loginPage">
    <!-- Header com o logo -->
    <div class="header">
      <img src="@/assets/LogoIcon.png" alt="LogoApp" />
    </div>

    <!-- Conteúdo do formulário de login -->
    <div class="loginContent">
      <!-- Título -->
      <h2 class="loginLabel">Entrar</h2>

      <!-- Formulário -->
      <form @submit.prevent="handleSubmit" class="loginForm">
        <!-- Campo de email -->
        <input
          type="text"
          id="email"
          v-model="formData.emailUser"
          placeholder="Email ou Nome de Usuário"
          required
        />

        <!-- Campo de senha -->
        <input
          type="password"
          id="password"
          v-model="formData.password"
          placeholder="Senha"
          required
        />

        <!-- Botão de envio -->
        <button type="submit">Entrar</button>
      </form>

      <div class="options">
        <p>Não tem conta? <a href="">Clique Aqui</a></p>
        <p>Esqueceu a senha? <a href="">Clique Aqui</a></p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "LoginComponent",
  // Váriaveis desse componente
  data() {
    return {
      formData: {
        emailUser: "",
        password: "",
      },
    };
  },
  methods: {
    // Método para lidar com o envio do formulário
    handleSubmit() {
      // Exibir os dados do formulário no console
      console.log("Formulário enviado:", this.formData);

      // Limpar os campos após o envio
      this.formData.emailUser = "";
      this.formData.password = "";
    },
  },
};
</script>

<!-- Estilização apenas do LoginPage -->
<style scoped>
.loginPage {
  display: flex;
  flex-direction: column;

  align-items: center;
  justify-content: center;

  margin-top: 20px;
}

.loginContent {
  display: flex;
  flex-direction: column;

  align-items: flex-start;

  margin-top: 20px;

  width: 100%;
  max-width: 450px;
}

.loginLabel {
  display: inline-block;

  margin: 20px 0;
  border-bottom: 4px solid #2cda9d;

  width: fit-content;

  font-size: 28px;
  text-align: left;
  letter-spacing: 1px;
  text-transform: uppercase;
}

.loginForm {
  display: flex;
  flex-direction: column;

  align-items: center;

  width: 100%;
}

.loginForm input {
  width: 100%;

  padding: 15px 3%;
  border-radius: 8px;
  margin-bottom: 16px;

  outline: none;

  background-color: #45484d;
  color: #eeedf0;

  font-size: 20px;
  font-weight: bold;
}

.loginForm button {
  width: 100%;

  padding: 15px 3%;
  border-radius: 8px;

  cursor: pointer;
  outline: none;

  background-color: #2cda9d;
  color: #1a181b;

  font-size: 24px;
  font-weight: bold;
  text-transform: uppercase;
}

.loginForm button:hover {
  background-color: #1f996e;
  color: #eeedf0;
  transition: background-color 250ms cubic-bezier(0.4, 0, 0.2, 1),
    color 350ms cubic-bezier(0.4, 0, 0.2, 1);
}

.options p {
  margin-top: 12px;
}

.options a {
  color: #2cda9d;
  text-decoration: none;
}

.options a:hover {
  color: #1f996e;
  transition: color 350ms cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
