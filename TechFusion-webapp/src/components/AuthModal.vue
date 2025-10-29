<template>
  <div v-if="show" class="modal-overlay" @click.self="closeModal">
    <div class="modal">
      <h2>{{ mode === 'login' ? 'Entrar' : 'Registrar' }}</h2>

      <form @submit.prevent="handleSubmit">
        <div v-if="mode === 'register'" class="form-group">
          <label for="name">Nome</label>
          <input type="text" id="name" v-model="form.name" required />
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" v-model="form.email" required />
        </div>

        <div class="form-group">
          <label for="password">Senha</label>
          <input type="password" id="password" v-model="form.password" required />
        </div>

        <button type="submit">{{ mode === 'login' ? 'Entrar' : 'Registrar' }}</button>
      </form>

      <p class="switch-mode">
        <span v-if="mode === 'login'">
          Ainda não tem conta?
          <a href="#" @click.prevent="mode = 'register'">Registrar</a>
        </span>
        <span v-else>
          Já tem conta?
          <a href="#" @click.prevent="mode = 'login'">Entrar</a>
        </span>
      </p>

      <button class="close-btn" @click="closeModal">Fechar</button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import api from '../axios' // teu arquivo Axios

// estado modal
const show = ref(false)
const mode = ref('login')

// dados do formulário
const form = ref({
  name: '',
  email: '',
  password: ''
})

// funções
const openModal = () => { show.value = true }
const closeModal = () => { show.value = false }

// login / registro
const handleSubmit = async () => {
  try {
    const endpoint = mode.value === 'login' ? '/login' : '/register'
    const { data } = await api.post(endpoint, form.value)

    // guarda token e dados do usuário
    localStorage.setItem('token', data.token)
    localStorage.setItem('user', JSON.stringify(data.user))

    alert(`${mode.value === 'login' ? 'Login efetuado' : 'Cadastro realizado'} com sucesso!`)
    closeModal()
    window.location.reload() // atualiza header pra mostrar nome
  } catch (error) {
    console.error(error)
    alert('Erro ao autenticar. Verifique os dados e tente novamente.')
  }
}

// expõe função pro Header abrir o modal
defineExpose({ openModal })
</script>

<style scoped>

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.85);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
}

.modal {
  background: #141414; /* fundo dark */
  color: #f2f2f2;
  padding: 2rem;
  border-radius: 14px;
  width: 340px;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.6);
  position: relative;
  text-align: center;
}

/* título */
.modal h2 {
  margin-bottom: 1.5rem;
  font-weight: 600;
  color: #fff;
}

/* form agrupado */
.form-group {
  margin-bottom: 1rem;
  text-align: left;
}

/* label */
label {
  display: block;
  margin-bottom: 6px;
  font-weight: 400;
  color: #e0e0e0;
}

/* inputs */
input {
  width: 100%;
  padding: 10px;
  border: none;
  border-radius: 8px;
  background: #2a2a2a;
  color: #fff;
  font-size: 15px;
  outline: none;
}

input:focus {
  border: 1px solid #3a6cf4;
}

/* botões padrão */
button {
  width: 100%;
  padding: 10px;
  font-weight: 500;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: 0.2s ease;
}

/* Entrar / Registrar (botão principal) */
button[type="submit"] {
  background-color: #2e7d32;
  color: white;
}

button[type="submit"]:hover {
  background-color: #388e3c;
}

/* botão fechar */
.close-btn {
  background-color: #333;
  color: #fff;
  margin-top: 12px;
}

.close-btn:hover {
  background-color: #555;
}

/* link trocar modo (Entrar / Registrar) */
.switch-mode {
  text-align: center;
  margin-top: 1rem;
  color: #ccc;
}

.switch-mode a {
  color: #4caf50;
  text-decoration: underline;
  font-weight: 500;
  cursor: pointer;
}

.switch-mode a:hover {
  color: #66bb6a;
}

</style>
