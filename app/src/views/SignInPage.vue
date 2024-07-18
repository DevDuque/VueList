<template>
  <div class="signinPage">
    <!-- Header com o logo -->
    <div class="header">
      <img src="@/assets/LogoIcon.png" alt="LogoApp" />
    </div>

    <!-- Conteúdo do formulário de signin -->
    <div class="signinContent">
      <!-- Título -->
      <h2 class="signinLabel">REGISTRAR</h2>

      <!-- Formulário -->
      <form @submit.prevent="handleSubmit" class="signinForm">
        <!-- Campo de email -->
        <input
          type="text"
          id="emailUser"
          v-model="formData.emailUser"
          placeholder="Email"
          required
        />

        <!-- Campo de nome de usuário -->
        <input
          type="text"
          id="username"
          v-model="formData.username"
          placeholder="Nome de usuário"
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
        <button type="submit">Registrar</button>
      </form>

      <div class="options">
        <p>Já tem conta? <a href="/Login">Clique Aqui</a></p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "signinComponent",
  // Váriaveis desse componente
  data() {
    return {
      formData: {
        emailUser: "",
        username: "",
        password: "",
      },
    };
  },
  methods: {
    // Método para lidar com o envio do formulário
    async handleSubmit() {
      // Enviando dados para o backend
      try {
        const response = await fetch(
          "http://localhost:8080/database/api/signin.php",
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify(this.formData),
          }
        );

        const result = await response.json();

        if (result.success) {
          alert(
            "Usuário registrado com sucesso! Você será redirecionando para a tela de Login"
          );

          // Redirecionando para a tela de Login após 3 segundos
          setTimeout(() => {
            this.$router.push("/Login");
          }, 3000);
        } else {
          alert("Erro ao registrar o usuário: " + result.message);
        }
      } catch (error) {
        alert("Erro ao registrar o usuário.");
      }
    },
  },
};
</script>

<!-- Estilização apenas do signinPage -->
<style scoped>
.signinPage {
  display: flex;
  flex-direction: column;

  align-items: center;
  justify-content: center;

  margin-top: 20px;
}

.signinContent {
  display: flex;
  flex-direction: column;

  align-items: flex-start;

  margin-top: 20px;

  width: 100%;
  max-width: 450px;
}

.signinLabel {
  display: inline-block;

  margin: 20px 0;
  border-bottom: 4px solid #2cda9d;

  width: fit-content;

  font-size: 28px;
  text-align: left;
  letter-spacing: 1px;
  text-transform: uppercase;
}

.signinForm {
  display: flex;
  flex-direction: column;

  align-items: center;

  width: 100%;
}

.signinForm input {
  width: 100%;

  padding: 12px 5%;
  border-radius: 8px;
  margin-bottom: 16px;

  outline: none;

  background-color: #45484d;
  color: #eeedf0;

  font-size: 20px;
  font-weight: bold;
}

.signinForm button {
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

.signinForm button:hover {
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
