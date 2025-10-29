<template>
  <section class="admin-panel">
    <h2>Gerenciar Produtos</h2>

    <form @submit.prevent="createProduct" enctype="multipart/form-data">
      <div class="form-group">
        <label>Nome do Produto</label>
        <input v-model="form.name" type="text" required />
      </div>

      <div class="form-group">
        <label>Preço (R$)</label>
        <input v-model="form.price" type="number" step="0.01" required />
      </div>

      <div class="form-group">
        <label>Descrição</label>
        <textarea v-model="form.description"></textarea>
      </div>

      <div class="form-group">
        <label>Imagem</label>
        <input type="file" @change="handleFileUpload" accept="image/*" />
      </div>

      <div class="form-group checkbox">
        <label>
          <input type="checkbox" v-model="form.is_featured" />
          Produto em destaque
        </label>
      </div>

      <button type="submit">Salvar Produto</button>
    </form>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import api from '../axios'

const form = ref({
  name: '',
  price: '',
  description: '',
  image: null,
  is_featured: false,
})

const handleFileUpload = (event) => {
  form.value.image = event.target.files[0]
}

const createProduct = async () => {
  try {
    const token = localStorage.getItem('token')
    if (!token) {
      alert('Você precisa estar logado como admin.')
      return
    }

    const formData = new FormData()
    Object.keys(form.value).forEach((key) => {
      formData.append(key, form.value[key])
    })

    const { data } = await api.post('/products', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
        Authorization: `Bearer ${token}`,
      },
    })

    alert('Produto criado com sucesso!')
    console.log('Novo produto:', data.product)

    // limpa o formulário
    form.value = {
      name: '',
      price: '',
      description: '',
      image: null,
      is_featured: false,
    }
  } catch (error) {
    console.error(error)
    alert('Erro ao salvar produto.')
  }
}
</script>

<style scoped>
.admin-panel {
  max-width: 600px;
  margin: 50px auto;
  padding: 25px;
  background: #1c1c1c;
  color: #fff;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
}

h2 {
  text-align: center;
  color: #5d8df7;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 15px;
  display: flex;
  flex-direction: column;
}

.form-group label {
  font-weight: 500;
  margin-bottom: 5px;
}

input,
textarea {
  padding: 8px;
  border-radius: 5px;
  border: 1px solid #444;
  background: #2a2a2a;
  color: #fff;
}

textarea {
  resize: none;
  height: 80px;
}

button {
  background-color: #2246e2;
  color: white;
  border: none;
  padding: 10px;
  width: 100%;
  border-radius: 5px;
  cursor: pointer;
  font-weight: 500;
  transition: 0.3s;
}

button:hover {
  background-color: #3355f3;
}

.checkbox {
  flex-direction: row;
  align-items: center;
  gap: 5px;
}
</style>
