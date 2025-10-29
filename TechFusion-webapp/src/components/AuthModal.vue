<script setup>

</script>

<template>
    <div v-if="show" class="modal-overlay">
      <div class="modal">
        <div class="tabs">
          <button :class="{ active: mode === 'login' }" @click="mode = 'login'">Entrar</button>
          <button :class="{ active: mode === 'register' }" @click="mode = 'register'">Registrar</button>
        </div>
  
        <form @submit.prevent="handleSubmit">
            <div :class="['input-group', { hidden: mode !== 'register' }]">
                <label>Nome</label>
                <input type="text" v-model="form.name" :required="mode === 'register'" />
            </div>
  
          <label>Email</label>
          <input type="email" v-model="form.email" required />
  
          <label>Senha</label>
          <input type="password" v-model="form.password" required />
  
          <button type="submit">{{ mode === 'login' ? 'Entrar' : 'Registrar' }}</button>
        </form>
  
        <button class="close" @click="closeModal">×</button>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import axios from 'axios'
  
  const show = ref(false)
  const mode = ref('login')
  const form = ref({ name: '', email: '', password: '' })
  
  // função que pode ser chamada de fora (por um botão)
  const openModal = () => (show.value = true)
  const closeModal = () => (show.value = false)
  
  // envia pro backend
  const handleSubmit = async () => {
    const url = mode.value === 'login' ? '/api/login' : '/api/register'
  
    try {
      const { data } = await axios.post(url, form.value)
      console.log('Sucesso:', data)
      alert('Autenticação concluída!')
      closeModal()
    } catch (error) {
      console.error(error)
      alert('Erro ao autenticar')
    }
  }
  
  // exporta função pra ser usada de fora
  defineExpose({ openModal })
  </script>
  
  <style scoped>
  .modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 999;
  }
  
  .modal {
    background: #1e1e1e;
    color: white;
    border-radius: 10px;
    padding: 20px;
    width: 360px;
    position: relative;
  }
  
  .tabs {
    display: flex;
    justify-content: space-around;
    margin-bottom: 20px;
  }
  
  .tabs button {
    background: none;
    border: none;
    color: gray;
    font-size: 16px;
    cursor: pointer;
    padding: 8px 16px;
  }
  
  .tabs button.active {
    color: #4e7eff;
    font-weight: bold;
    border-bottom: 2px solid #4e7eff;
  }
  
  form {
    display: flex;
    flex-direction: column;
  }
  
  label {
    margin-top: 10px;
    margin-bottom: 4px;
    font-size: 14px;
  }
  
  input {
    padding: 8px;
    border: 1px solid #444;
    border-radius: 5px;
    background: #2b2b2b;
    color: white;
  }
  
  button[type="submit"] {
    margin-top: 15px;
    padding: 10px;
    background: #4e7eff;
    border: none;
    border-radius: 5px;
    color: white;
    cursor: pointer;
    font-weight: bold;
  }
  
  button[type="submit"]:hover {
    background: #3a63d9;
  }
  
  .close {
    position: absolute;
    top: 6px;
    right: 10px;
    background: none;
    border: none;
    font-size: 22px;
    color: white;
    cursor: pointer;
  }
  .input-group {
  display: flex;
  flex-direction: column;
}

.hidden {
  visibility: hidden;
  height: 0;
  margin: 0;
  padding: 0;
  overflow: hidden;
}
  </style>
  