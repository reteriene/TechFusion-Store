<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const api = axios.create({
  baseURL: 'http://127.0.0.1:8000/api',
})

const products = ref([])
const form = ref({
  name: '',
  price: '',
  description: '',
  image: null,
  is_featured: false
})
const loading = ref(false)
const message = ref('')

const loadProducts = async () => {
  const res = await api.get('/products')
  products.value = res.data
}

const saveProduct = async () => {
  loading.value = true
  message.value = ''

  try {
  const formData = new FormData()
  formData.append('name', form.value.name)
  formData.append('price', form.value.price)
  formData.append('description', form.value.description)
  formData.append('is_featured', form.value.is_featured ? 1 : 0)
  if (form.value.image) formData.append('image', form.value.image)

  const res = await api.post('/products', formData, {
    headers: { 'Content-Type': 'multipart/form-data' },
  })

  if (res.data.success) {
    products.value.push(res.data.product)
    message.value = '✅ Produto cadastrado com sucesso!'
  } else {
    message.value = '❌ Erro: ' + (res.data.message || 'Erro desconhecido')
  }

  form.value = { name: '', price: '', description: '', image: null, is_featured: false }
} catch (err) {
  console.error(err.response?.data || err.message)
  message.value = '❌ ' + (err.response?.data?.message || 'Erro inesperado.')
} finally {
  loading.value = false
}

}

onMounted(loadProducts)
</script>

<template>
  <div class="admin-container">
    <h1>Painel Administrativo - TechFusion</h1>

    <div class="form-section">
      <h2>Cadastrar novo produto</h2>

      <div class="form-group">
        <label>Nome:</label>
        <input v-model="form.name" type="text" placeholder="Nome do produto" />
      </div>

      <div class="form-group">
        <label>Preço:</label>
        <input v-model="form.price" type="number" placeholder="Preço (R$)" />
      </div>

      <div class="form-group">
        <label>Descrição:</label>
        <textarea v-model="form.description" placeholder="Descrição do produto"></textarea>
      </div>

      <div class="form-group">
        <label>Imagem:</label>
        <input type="file" @change="e => form.image = e.target.files[0]" />
      </div>

      <div class="form-group checkbox">
        <label><input type="checkbox" v-model="form.is_featured" /> Destaque</label>
      </div>

      <button @click="saveProduct" :disabled="loading">
        {{ loading ? 'Salvando...' : 'Salvar Produto' }}
      </button>

      <p class="message">{{ message }}</p>
    </div>

    <div class="list-section">
      <h2>Produtos Cadastrados</h2>
      <div class="product-list">
        <div v-for="p in products" :key="p.id" class="product-card">
          <img v-if="p.image" :src="`http://127.0.0.1:8000/storage/${p.image}`" alt="produto" />
          <h3>{{ p.name }}</h3>
          <p>R$ {{ p.price }}</p>
          <p v-if="p.is_featured" class="featured">🌟 Destaque</p>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.admin-container {
  background: #111;
  color: #f5f5f5;
  min-height: 100vh;
  padding: 20px 40px;
  font-family: Arial, sans-serif;
}

h1 {
  text-align: center;
  margin-bottom: 30px;
  color: #00bcd4;
}

.form-section {
  background: #1e1e1e;
  padding: 20px;
  border-radius: 10px;
  max-width: 600px;
  margin: 0 auto 40px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.6);
}

.form-section h2 {
  margin-bottom: 20px;
  color: #f5f5f5;
}

.form-group {
  margin-bottom: 15px;
  display: flex;
  flex-direction: column;
}

.form-group label {
  font-size: 14px;
  margin-bottom: 5px;
}

.form-group input,
.form-group textarea {
  background: #2b2b2b;
  color: white;
  border: 1px solid #444;
  border-radius: 5px;
  padding: 8px;
  font-size: 14px;
}

.form-group.checkbox {
  flex-direction: row;
  align-items: center;
}

button {
  background: #00bcd4;
  color: white;
  border: none;
  padding: 10px 16px;
  font-weight: bold;
  border-radius: 5px;
  cursor: pointer;
  transition: background 0.3s;
}

button:hover {
  background: #0097a7;
}

button[disabled] {
  background: #555;
  cursor: not-allowed;
}

.message {
  margin-top: 10px;
  font-size: 14px;
  color: #00e676;
}

.list-section {
  text-align: center;
}

.product-list {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 20px;
}

.product-card {
  background: #1e1e1e;
  border: 1px solid #333;
  border-radius: 10px;
  width: 200px;
  padding: 10px;
  text-align: center;
}

.product-card img {
  width: 100%;
  height: 120px;
  object-fit: cover;
  border-radius: 6px;
  margin-bottom: 10px;
}

.featured {
  color: gold;
  font-weight: bold;
}
</style>
