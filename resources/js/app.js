import { createApp } from 'vue';
import axios from 'axios';

// Import CSS
import '../css/app.css';

// Setup axios untuk API calls
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Setup CSRF token
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

// Import AuthService
import './services/AuthService.js';

// Import Vue components
import ProductSearch from './components/ProductSearch.vue';
import TentangContent from './components/TentangContent.vue';
import LoginContent from './components/LoginContent.vue';
import RegisterContent from './components/RegisterContent.vue';
import HomeContent from './components/HomeContent.vue';
import HeaderComponent from './components/HeaderComponent.vue';

const app = createApp({});

// Register components globally (Vue 3 syntax)
app.component('product-search', ProductSearch);
app.component('tentang-content', TentangContent);
app.component('login-content', LoginContent);
app.component('register-content', RegisterContent);
app.component('home-content', HomeContent);
app.component('header-component', HeaderComponent);

// Mount Vue app
app.mount('#app');