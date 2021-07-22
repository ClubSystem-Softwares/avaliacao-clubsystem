import { createApp } from 'vue'

require('./bootstrap')
import 'bootstrap/dist/css/bootstrap.min.css'

import '../css/app.css'

import App from './App.vue'
import axios from 'axios'
import router from './router'

const app = createApp(App)
app.config.globalProperties.$axios = axios;
app.use(router)
app.mount('#app')
