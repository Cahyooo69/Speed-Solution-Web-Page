<template>
  <nav class="navbar">
    <div class="container">
      <a href="/" class="navbar-brand">
        <img src="/images/speedsolution_logo.png" alt="Speed Solution Logo">
      </a>
      <ul class="nav-menu">
        <li><a href="/promo">Promo</a></li>
        <li><a href="/produk">Produk</a></li>
        <li><a href="/outlet">Outlet</a></li>
        <li><a href="/tentang">Tentang</a></li>
        
        <!-- Auth Section -->
        <li v-if="!isAuthenticated">
          <a href="/login">Login</a>
        </li>
        <li v-else class="dropdown">
          <a href="#" class="dropdown-toggle" @click.prevent="toggleDropdown">
            {{ user.name }}
          </a>
          <div class="dropdown-menu" :class="{ 'show': showDropdown }">
            <a v-if="user.email === 'admin@gmail.com'" href="/admin/chat" class="dropdown-link">
              Admin Dashboard
            </a>
            <button @click="logout" class="dropdown-link">Logout</button>
          </div>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
import authService from '../services/AuthService.js';

export default {
  name: 'HeaderComponent',
  data() {
    return {
      isAuthenticated: false,
      user: null,
      showDropdown: false
    }
  },
  mounted() {
    // Subscribe to auth state changes
    this.unsubscribe = authService.subscribe((authState) => {
      this.isAuthenticated = authState.isAuthenticated;
      this.user = authState.user;
    });

    // Initial auth check
    this.checkAuthStatus();

    // Close dropdown when clicking outside
    document.addEventListener('click', this.handleClickOutside);
  },
  beforeUnmount() {
    if (this.unsubscribe) {
      this.unsubscribe();
    }
    document.removeEventListener('click', this.handleClickOutside);
  },
  methods: {
    async checkAuthStatus() {
      await authService.checkAuth();
    },
    
    toggleDropdown() {
      this.showDropdown = !this.showDropdown;
    },

    handleClickOutside(event) {
      if (!this.$el.contains(event.target)) {
        this.showDropdown = false;
      }
    },
    
    async logout() {
      try {
        await authService.logout();
        this.showDropdown = false;
        window.location.href = '/';
      } catch (error) {
        console.error('Logout failed:', error);
        // Force redirect anyway
        window.location.href = '/';
      }
    }
  }
}
</script>

<style scoped>
.dropdown {
  position: relative;
}

.dropdown-menu {
  display: none;
  position: absolute;
  top: 100%;
  right: 0;
  background: white;
  border: 1px solid #ddd;
  border-radius: 4px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  min-width: 160px;
  z-index: 1000;
}

.dropdown-menu.show {
  display: block;
}

.dropdown-link {
  display: block;
  padding: 10px 15px;
  color: #333;
  text-decoration: none;
  border: none;
  background: none;
  width: 100%;
  text-align: left;
  cursor: pointer;
}

.dropdown-link:hover {
  background-color: #f5f5f5;
}

.dropdown-toggle::after {
  content: ' ▼';
  font-size: 0.8em;
}
</style>
