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
        <input ref="fileInput" type="file" @change="handleFileUpload" accept="image/*" />
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

const fileInput = ref(null)

const handleFileUpload = (event) => {
  form.value.image = event.target.files[0] || null
}

const createProduct = async () => {
  try {
    const token = localStorage.getItem('token')
    if (!token) {
      alert('Você precisa estar logado como admin.')
      return
    }

    const formData = new FormData()
    // append seletivo — converte boolean/number para string
    formData.append('name', form.value.name || '')
    formData.append('price', String(form.value.price || '0'))
    formData.append('description', form.value.description || '')
    formData.append('is_featured', form.value.is_featured ? '1' : '0')

    if (form.value.image) {
      formData.append('image', form.value.image)
    }

    // NÃO setar Content-Type — deixe o browser definir o boundary automaticamente
    const { data } = await api.post('/products', formData, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    })

    alert('Produto criado com sucesso!')
    console.log('Novo produto:', data.product)

    // limpa o formulário e o input file
    form.value = { name: '', price: '', description: '', image: null, is_featured: false }
    if (fileInput.value) fileInput.value.value = null
  } catch (error) {
    console.error(error)
    const msg = error?.response?.data?.error || error?.response?.data?.message || 'Erro ao salvar produto.'
    alert(msg)
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
