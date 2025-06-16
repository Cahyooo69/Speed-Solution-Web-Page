<template>
  <!-- Services Section -->
  <section class="services">
    <div class="container">
      <h2>PILIH JENIS SERVIS YANG MEMUDAHKAN PERAWATAN MOTORMU</h2>
      <div class="services-scroll">
        <div 
          v-for="service in services" 
          :key="service.title"
          class="service-card"
        >
          <div class="image-wrapper">
            <img :src="`/images/${service.image}`" :alt="service.title">
            <div class="overlay-text">
              <h3>{{ service.title }}</h3>
              <span class="service-label">Mulai dari</span>
              <h4 class="service-price">{{ service.price }}</h4>
              <button 
                class="btn-pesan" 
                @click="orderService(service.title, service.price)"
              >
                Pesan Sekarang
              </button>
              <p>{{ service.description }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials Section -->
  <section class="testimonials">
    <div class="container">
      <h2>TESTIMONI PELANGGAN</h2>
      <div class="testimonial-container">
        <div 
          v-for="testimonial in testimonials" 
          :key="testimonial.name"
          class="testimonial-card"
        >
          <img 
            :src="`/images/${testimonial.image}`" 
            :alt="testimonial.name" 
            class="testimonial-img"
          >
          <h3>{{ testimonial.name }}</h3>
          <span class="testimonial-role">{{ testimonial.role }}</span>
          <div class="stars">⭐⭐⭐⭐⭐</div>
          <p>"{{ testimonial.message }}"</p>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'HomeContent',
  data() {
    return {
      services: [],
      testimonials: []
    }
  },
  mounted() {
    this.loadHomeData();
  },
  methods: {
    async loadHomeData() {
      await Promise.all([
        this.loadServices(),
        this.loadTestimonials()
      ]);
    },
    async loadServices() {
      try {
        const response = await axios.get('/api/services');
        this.services = response.data;
      } catch (error) {
        console.error('Error loading services:', error);
        // Fallback data jika API gagal
        this.services = [
          {
            image: 'gantioli.png',
            title: 'Oli',
            price: 'Rp. 50.000/Liter',
            description: 'Ganti oli + gratis jasa penggantian'
          },
          {
            image: 'rem.png',
            title: 'Rem',
            price: 'Rp. 40.000',
            description: 'Jaga kondisi rem agar aman berkendara'
          },
          {
            image: 'detailing.png',
            title: 'Detailing',
            price: 'Rp. 50.000',
            description: 'Bikin cat motor kamu kembali kinclong'
          },
          {
            image: 'tuneup.png',
            title: 'Tune Up',
            price: 'Rp. 90.000',
            description: 'Tune up rutin untuk mengembalikan tenaga maksimal'
          }
        ];
      }
    },
    async loadTestimonials() {
      try {
        const response = await axios.get('/api/testimonials');
        this.testimonials = response.data;
      } catch (error) {
        console.error('Error loading testimonials:', error);
        // Fallback data jika API gagal
        this.testimonials = [
          {
            image: 'ilham.png',
            name: 'Ilham Nurcahyo',
            role: 'Mahasiswa - Sidoarjo',
            message: 'Hasil servicenya rapi dan cepet banget, sangat cocok buat kalian yang suka modifikasi motor juga, di Speed Solution ini juga banyak sparepart variasi yang bagus dan berkualitas'
          },
          {
            image: 'farhan.png',
            name: 'Farhan Maheswara',
            role: 'Mahasiswa - Surabaya',
            message: 'Modif motor jadi makin gampang bareng Speed Solution! Servis cepat, hasil rapi, dan pilihan sparepart variasi yang lengkap serta berkualitas tinggi. Cocok banget buat kamu yang ingin tampil beda dan tetap nyaman di jalan!'
          },
          {
            image: 'daud.png',
            name: 'Daud Rizal',
            role: 'Driver Ojek - Gresik',
            message: 'Driver ojek? Wajib coba Speed Solution! Servis motor jadi cepat, hasil rapi, dan banyak pilihan sparepart berkualitas. Gak perlu antri lama, motor kamu selalu siap ngebut cari orderan!'
          }
        ];
      }
    },
    orderService(serviceName, price) {
      // Panggil fungsi global orderService yang sudah ada di chat.blade.php
      if (typeof window.orderService === 'function') {
        window.orderService(serviceName, price);
      } else {
        console.log('Order service:', serviceName, price);
        // Fallback jika fungsi chat belum tersedia
        alert(`Anda ingin memesan layanan ${serviceName} dengan harga ${price}`);
      }
    }
  }
}
</script>