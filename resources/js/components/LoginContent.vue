<template>
  <div class="login-content">
    <div class="login-container">
      <div class="login-image">
        <img src="/images/speedsolution_logo.png" alt="Speed Solution Logo">
      </div>
      
      <div class="login-form">
        <div class="form-header">
          <h1>Masuk ke Akun Anda</h1>
          <p>Silakan masuk untuk melanjutkan</p>
        </div>

        <form @submit.prevent="login">
          <div class="form-group">
            <label for="email">Email</label>
            <input
              type="email"
              id="email"
              v-model="form.email"
              placeholder="Masukkan email Anda"
              required
              :class="{ 'error': errors.email }"
            >
            <div v-if="errors.email" class="error-message">
              {{ errors.email[0] }}
            </div>
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input
              type="password"
              id="password"
              v-model="form.password"
              placeholder="Masukkan password Anda"
              required
              :class="{ 'error': errors.password }"
            >
            <div v-if="errors.password" class="error-message">
              {{ errors.password[0] }}
            </div>
          </div>

          <div class="form-actions">
            <label class="checkbox-container">
              <input type="checkbox" v-model="form.remember">
              <span class="checkmark"></span>
              Ingat saya
            </label>
            <a href="#" class="forgot-password">Lupa Password?</a>
          </div>

          <button 
            type="submit" 
            class="login-btn"
            :disabled="loading"
          >
            {{ loading ? 'Memproses...' : 'Masuk' }}
          </button>

          <div class="form-divider">
            <span>atau</span>
          </div>

          <button type="button" class="google-btn">
            <img src="/images/google.png" alt="Google">
            Masuk dengan Google
          </button>

          <div class="register-link">
            <p>Belum punya akun? <a href="/register">Daftar Sekarang</a></p>
          </div>
        </form>

        <!-- Alert Messages -->
        <div v-if="message" class="alert alert-success">
          {{ message }}
        </div>
        <div v-if="error" class="alert alert-danger">
          {{ error }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import authService from '../services/AuthService.js';

export default {
  name: 'LoginContent',
  data() {
    return {
      form: {
        email: '',
        password: '',
        remember: false
      },
      errors: {},
      loading: false,
      message: '',
      error: ''
    }
  },
  methods: {
    async login() {
      this.loading = true;
      this.errors = {};
      this.message = '';
      this.error = '';

      try {
        // Use AuthService for login
        const response = await authService.login(this.form);
        
        if (response.success) {
          this.message = 'Login berhasil! Mengalihkan...';
          
          // Redirect after successful login
          setTimeout(() => {
            window.location.href = response.data.redirect || '/';
          }, 1500);
        } else {
          this.error = response.message || 'Login gagal';
        }
      } catch (error) {
        console.error('Login error:', error);
        
        if (error.response && error.response.status === 422) {
          // Validation errors
          this.errors = error.response.data.errors || {};
        } else if (error.response && error.response.data.message) {
          this.error = error.response.data.message;
        } else {
          this.error = 'Terjadi kesalahan. Silakan coba lagi.';
        }
      } finally {
        this.loading = false;
      }
    }
  }
}
</script>

<style scoped>
/* Gunakan CSS yang sudah ada di app.css */
</style>
