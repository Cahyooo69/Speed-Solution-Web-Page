<template>
  <div class="register-content">
    <div class="register-container">
      <div class="register-image">
        <img src="/images/speedsolution_logo.png" alt="Speed Solution Logo">
      </div>
      
      <div class="register-form">
        <div class="form-header">
          <h1>Daftar Akun Baru</h1>
          <p>Bergabunglah dengan Speed Solution</p>
        </div>

        <form @submit.prevent="register">
          <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input
              type="text"
              id="name"
              v-model="form.name"
              placeholder="Masukkan nama lengkap"
              required
              :class="{ 'error': errors.name }"
            >
            <div v-if="errors.name" class="error-message">
              {{ errors.name[0] }}
            </div>
          </div>

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
            <label for="phone">No. Handphone</label>
            <input
              type="tel"
              id="phone"
              v-model="form.phone"
              placeholder="08xxxxxxxxx"
              :class="{ 'error': errors.phone }"
            >
            <div v-if="errors.phone" class="error-message">
              {{ errors.phone[0] }}
            </div>
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input
              type="password"
              id="password"
              v-model="form.password"
              placeholder="Masukkan password"
              required
              :class="{ 'error': errors.password }"
            >
            <div v-if="errors.password" class="error-message">
              {{ errors.password[0] }}
            </div>
          </div>

          <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input
              type="password"
              id="password_confirmation"
              v-model="form.password_confirmation"
              placeholder="Ulangi password"
              required
            >
          </div>

          <div class="form-actions">
            <label class="checkbox-container">
              <input 
                type="checkbox" 
                v-model="form.agree_terms"
                :class="{ 'error': errors.agree_terms }"
                required
              >
              <span class="checkmark"></span>
              Saya setuju dengan <a href="#" class="terms-link">syarat dan ketentuan</a>
            </label>
            <div v-if="errors.agree_terms" class="error-message">
              {{ errors.agree_terms[0] }}
            </div>
          </div>

          <button 
            type="submit" 
            class="register-btn"
            :disabled="loading"
          >
            {{ loading ? 'Memproses...' : 'Daftar' }}
          </button>

          <div class="form-divider">
            <span>atau</span>
          </div>

          <button type="button" class="google-btn">
            <img src="/images/google.png" alt="Google">
            Daftar dengan Google
          </button>

          <div class="login-link">
            <p>Sudah punya akun? <a href="/login">Masuk di sini</a></p>
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
export default {
  name: 'RegisterContent',
  data() {
    return {
      form: {
        name: '',
        email: '',
        phone: '',
        password: '',
        password_confirmation: '',
        agree_terms: false
      },
      errors: {},
      loading: false,
      message: '',
      error: ''
    }
  },
  methods: {
    async register() {
      this.loading = true;
      this.errors = {};
      this.message = '';
      this.error = '';

      try {
        // Get CSRF token
        await window.axios.get('/sanctum/csrf-cookie');
        
        // Register request
        const response = await window.axios.post('/api/register', this.form);
        
        if (response.data.success) {
          this.message = 'Pendaftaran berhasil! Mengalihkan ke halaman login...';
          
          // Clear form
          this.form = {
            name: '',
            email: '',
            phone: '',
            password: '',
            password_confirmation: '',
            agree_terms: false
          };
          
          // Redirect after successful registration
          setTimeout(() => {
            window.location.href = '/login';
          }, 2000);
        } else {
          this.error = response.data.message || 'Pendaftaran gagal';
        }
      } catch (error) {
        console.error('Register error:', error);
        
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
