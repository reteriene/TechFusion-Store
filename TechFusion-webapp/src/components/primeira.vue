<template>
  <header>
    <h1 @click="goHome" class="logo">TechFusion</h1>

    <div class="search-wrapper">
      <button>🔍</button>
      <input type="text" placeholder="Buscar..." />
    </div>

    <nav>
      <!-- Botão de login -->
      <button v-if="!user" @click="openLogin" class="btn-login">Login</button>

      <!-- Menu do usuário -->
      <div v-else class="user-menu">
        <span>Olá, {{ user.name }}</span>

        <!-- Botão de administração visível só para admin -->
        <button
          v-if="user.is_admin"
          class="btn-admin"
          @click="goToAdmin"
        >
          Administrar
        </button>

        <button @click="logout" class="btn-logout">Sair</button>
      </div>
    </nav>

    <AuthModal ref="authModal" />
  </header>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import AuthModal from './AuthModal.vue'
import { useRouter } from 'vue-router' 

const authModal = ref(null)
const user = ref(null)

onMounted(() => {
  const storedUser = localStorage.getItem('user')
  if (storedUser) {
    user.value = JSON.parse(storedUser)
  }
})

const openLogin = () => authModal.value.openModal()

const router = useRouter()

const logout = () => {
  localStorage.removeItem('token')
  localStorage.removeItem('user')
  window.location.reload()
}

const goHome = () => router.push('/')


const goToAdmin = () => {
  window.location.href = '/admin'
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap');

* {
  font-family: 'Poppins', sans-serif;
  box-sizing: border-box;
}

.logo {
  cursor: pointer;
  color: #5d8df7;
  font-weight: 600;
  transition: 0.2s;
}
.logo:hover {
  color: #7a9ffb;
}

header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background-color: #1a1a1a;
  color: #fff;
  padding: 12px 25px;
  border-bottom: 1px solid #333;
}

h1 {
  font-weight: 500;
  color: #5d8df7;
  letter-spacing: 0.5px;
}

.search-wrapper {
  display: flex;
  align-items: center;
  background-color: #333;
  border-radius: 8px;
  padding: 3px 10px;
}

.search-wrapper input {
  background: none;
  border: none;
  color: #fff;
  padding: 5px;
  outline: none;
  width: 200px;
}

.search-wrapper button {
  background: none;
  border: none;
  color: #bbb;
  cursor: pointer;
  font-size: 16px;
}

nav {
  display: flex;
  align-items: center;
  gap: 10px;
}

.user-menu {
  display: flex;
  align-items: center;
  gap: 10px;
}

button {
  cursor: pointer;
  border: none;
  padding: 7px 14px;
  border-radius: 5px;
  font-weight: 500;
  transition: 0.2s ease;
}

/* Botão de login */
.btn-login {
  background-color: #0018a8;
  color: white;
}

.btn-login:hover {
  background-color: #0026d1;
}

/* Botão admin */
.btn-admin {
  background-color: #2246e2;
  color: #fff;
}

.btn-admin:hover {
  background-color: #4465f3;
}

/* Botão sair */
.btn-logout {
  background-color: #444;
  color: #fff;
}

.btn-logout:hover {
  background-color: #666;
}
</style>
