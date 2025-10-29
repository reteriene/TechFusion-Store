import { createApp } from 'vue'
import './assets/style.css'
import App from './App.vue'
import router from './router' // 👈 importa o router

const app = createApp(App)
app.use(router)               // 👈 ativa o roteamento
app.mount('#app')             // 👈 monta a aplicação
