<template>
    <div>
        <!-- Loading State -->
        <div v-if="loading" class="text-center">
            <p>Memuat data...</p>
        </div>

        <!-- Error State -->
        <div v-else-if="error" class="alert alert-danger">
            <p>{{ error }}</p>
        </div>

        <!-- Content -->
        <div v-else>
            <!-- Hero Section -->
            <section class="hero">
                <div class="container">
                    <div class="hero-content">
                        <div class="hero-text">
                            <h1>{{ tentangData.hero.title }}</h1>
                            <h2 class="subheading">{{ tentangData.hero.subtitle }}</h2>
                            <p class="hero-description">{{ tentangData.hero.description }}</p>
                        </div>
                        <div class="hero-images">
                            <img :src="'/images/' + tentangData.hero.image" alt="Speed Solution Workshop">
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- About Section -->
            <section class="about-section">
                <div class="container">
                    <h2>{{ tentangData.about.title }}</h2>
                    <div class="about-content">
                        <p v-for="(paragraph, index) in tentangData.about.content" :key="index">
                            {{ paragraph }}
                        </p>
                    </div>
                </div>
            </section>

            <!-- Vision Mission Section -->
            <section class="vision-mission">
                <div class="container">
                    <div class="vision-mission-content boxed">
                        <div class="vision-mission-image">
                            <img :src="'/images/' + tentangData.visionMission.image" alt="Speed Solution Mobile App">
                        </div>
                        <div class="vision-mission-text">
                            <div class="vision-box">
                                <h3>Visi</h3>
                                <p>{{ tentangData.visionMission.vision }}</p>
                            </div>
                            <div class="mission-box">
                                <h3>Misi</h3>
                                <ol>
                                    <li v-for="(misi, index) in tentangData.visionMission.mission" :key="index">
                                        {{ misi }}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Journey Section -->
            <section class="journey-section">
                <div class="container">
                    <div class="journey-box">
                        <h2>{{ tentangData.journey.title }}</h2>
                        <p>{{ tentangData.journey.content }}</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'TentangContent',
    data() {
        return {
            tentangData: {
                hero: {},
                about: {},
                visionMission: {},
                journey: {}
            },
            loading: true,
            error: null
        }
    },
    mounted() {
        console.log('TentangContent component mounted! 📖');
        this.loadTentangData();
    },
    methods: {
        async loadTentangData() {
            try {
                this.loading = true;
                this.error = null;
                
                const response = await axios.get('/api/tentang');
                
                if (response.data.success) {
                    this.tentangData = response.data.data;
                } else {
                    this.error = response.data.message || 'Gagal memuat data tentang';
                }
            } catch (error) {
                console.error('Error loading tentang data:', error);
                this.error = 'Terjadi kesalahan saat memuat data';
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>