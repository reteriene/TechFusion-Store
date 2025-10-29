<template>
  <div>
   
    <section v-if="authorized">
      <AdminPanel />
    </section>

    <section v-else class="denied">
      <h2>Acesso negado</h2>
      <p>Você não tem permissão para acessar esta área.</p>
      <button @click="goHome">Voltar</button>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import Header from '../components/primeira.vue'
import AdminPanel from '../components/AdminPanel.vue'
import api from '../axios'

const authorized = ref(false)

const goHome = () => {
  window.location.href = '/'
}

onMounted(async () => {
  try {
    const token = localStorage.getItem('token')
    if (!token) {
      authorized.value = false
      return
    }

    const { data } = await api.get('/admin', {
      headers: { Authorization: `Bearer ${token}` }
    })

    // se sucesso, libera
    if (data.success === true) {
      authorized.value = true
    } else {
      authorized.value = false
    }
  } catch (error) {
    authorized.value = false
    console.warn('Acesso negado ou erro na verificação:', error)
  }
})
</script>

<style scoped>
.denied {
  text-align: center;
  color: #fff;
  margin-top: 80px;
}

.denied h2 {
  color: #ff4d4d;
  margin-bottom: 10px;
}

.denied button {
  background-color: #444;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 8px;
  cursor: pointer;
  margin-top: 10px;
  transition: 0.2s ease;
}

.denied button:hover {
  background-color: #666;
}
</style>
