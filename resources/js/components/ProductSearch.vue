<template>
    <section class="produk-content">
        <!-- Loading state -->
        <div v-if="loading" class="text-center">
            <p>Memuat data produk...</p>
        </div>
        
        <!-- Error state -->
        <div v-else-if="error" class="alert alert-danger">
            <p>{{ error }}</p>
        </div>
        
        <!-- Content -->
        <div v-else class="produk-kategori">
            <!-- Header -->
            <div class="produk-header">
                <h1 class="produk-heading">Produk Motor Berkualitas</h1>
                <p class="produk-subtitle">TEMUKAN PRODUK MOTOR BERKUALITAS UNTUK KENDARAAN ANDA</p>
            </div>
            
            <!-- Filter -->
            <div class="outlet-filter">
                <h3>Filter Kategori:</h3>
                <div class="filter-buttons">
                    <button 
                        v-for="category in categories" 
                        :key="category.id"
                        @click="filterByCategory(category.id)"
                        :class="['filter-btn', { 'active': selectedCategory === category.id }]"
                    >
                        {{ category.name }}
                    </button>
                </div>
            </div>

            <!-- Search Box -->
            <div class="outlet-filter">
                <h3>Cari Produk:</h3>
                <div class="mt-2">
                    <input 
                        type="text" 
                        v-model="searchQuery" 
                        placeholder="Cari nama produk..." 
                        class="search-input"
                    >
                </div>
            </div>
              <!-- Products Count -->
            <div class="products-count">
                <p>Menampilkan {{ paginatedProducts.length }} dari {{ filteredProducts.length }} produk</p>
            </div>

            <!-- Compare Bar -->
            <div v-if="compareProducts.length > 0" class="compare-bar">
                <div class="compare-info">
                    <span>{{ compareProducts.length }} produk dipilih untuk perbandingan</span>
                    <button 
                        v-if="compareProducts.length >= 2" 
                        @click="showCompareModal = true"
                        class="btn-compare-show"
                    >
                        Bandingkan Produk
                    </button>
                    <button @click="clearCompare" class="btn-compare-clear">
                        Bersihkan
                    </button>
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="produk-grid">
                <div v-if="filteredProducts.length === 0 && !loading" class="scraping-error">
                    <h3>Tidak ada produk ditemukan</h3>
                    <p>Coba ubah filter atau kata kunci pencarian</p>
                </div>
                <div 
                    v-for="product in paginatedProducts" 
                    :key="product.id"
                    class="produk-card"
                >
                    <div class="produk-image">
                        <img :src="product.image" :alt="product.name" onerror="this.src='/images/default-product.png'">
                    </div>                    <div class="produk-info">
                        <h3 class="produk-name">{{ product.name }}</h3>
                        <p class="produk-price">{{ product.formatted_price }}</p>
                        <p class="product-description">{{ product.description }}</p>
                        <div class="product-actions">
                            <button class="detail-btn" @click="viewProduct(product)">Lihat Detail</button>
                            <button 
                                v-if="!isProductInCompare(product.id)"
                                @click="addToCompare(product)"
                                :disabled="compareProducts.length >= 3"
                                class="compare-btn"
                                :class="{ 'disabled': compareProducts.length >= 3 }"
                            >
                                + Bandingkan
                            </button>
                            <button 
                                v-else
                                @click="removeFromCompare(product.id)"
                                class="compare-btn remove"
                            >
                                - Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div v-if="filteredProducts.length > itemsPerPage" class="pagination-wrapper">
                <div class="pagination-container">
                    <button 
                        @click="previousPage" 
                        :disabled="currentPage === 1"
                        class="filter-btn pagination-btn"
                        :class="{ 'disabled': currentPage === 1 }"
                    >
                        Previous
                    </button>
                    
                    <span class="pagination-info">
                        Halaman {{ currentPage }} dari {{ totalPages }}
                    </span>
                    
                    <button 
                        @click="nextPage" 
                        :disabled="currentPage === totalPages"
                        class="filter-btn pagination-btn"
                        :class="{ 'disabled': currentPage === totalPages }"
                    >
                        Next                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Perbandingan Produk -->
        <div v-if="showCompareModal" class="compare-modal-overlay" @click="closeCompareModal">
            <div class="compare-modal" @click.stop>
                <div class="compare-modal-header">
                    <h2>Perbandingan Produk</h2>
                    <button @click="closeCompareModal" class="close-modal-btn">&times;</button>
                </div>                <div class="compare-modal-body">
                    <div class="compare-table">                        <div class="compare-row compare-header" :data-products="compareProducts.length">
                            <div class="compare-cell feature-label">Produk</div>
                            <div 
                                v-for="product in compareProducts" 
                                :key="product.id"
                                class="compare-cell product-header"
                            >
                                <img :src="product.image" :alt="product.name" class="compare-product-image">
                                <h4>{{ product.name }}</h4>
                            </div>
                        </div>
                        
                        <div class="compare-row" :data-products="compareProducts.length">
                            <div class="compare-cell feature-label">Harga</div>
                            <div 
                                v-for="product in compareProducts" 
                                :key="product.id"
                                class="compare-cell"
                            >
                                <span class="price-value">{{ product.formatted_price }}</span>
                            </div>
                        </div>
                        
                        <div class="compare-row" :data-products="compareProducts.length">
                            <div class="compare-cell feature-label">Kategori</div>
                            <div 
                                v-for="product in compareProducts" 
                                :key="product.id"
                                class="compare-cell"
                            >
                                <span class="category-badge">{{ getCategoryName(product.category) }}</span>
                            </div>
                        </div>
                        
                        <div class="compare-row" :data-products="compareProducts.length">
                            <div class="compare-cell feature-label">Deskripsi</div>
                            <div 
                                v-for="product in compareProducts" 
                                :key="product.id"
                                class="compare-cell"
                            >
                                <p>{{ product.description }}</p>
                            </div>
                        </div>
                        
                        <div class="compare-row" :data-products="compareProducts.length">
                            <div class="compare-cell feature-label">Aksi</div>
                            <div 
                                v-for="product in compareProducts" 
                                :key="product.id"
                                class="compare-cell"
                            >
                                <button @click="viewProduct(product)" class="detail-btn small">
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ProductSearch',    data() {
        return {
            allProducts: [],
            categories: [],
            searchQuery: '',
            selectedCategory: 'all',
            loading: true,
            error: null,
            currentPage: 1,
            itemsPerPage: 6,
            // Fitur perbandingan
            compareProducts: [],
            showCompareModal: false
        }
    },
    computed: {
        filteredProducts() {
            if (!Array.isArray(this.allProducts)) {
                return [];
            }
            
            let filtered = this.allProducts;
            
            // Filter berdasarkan kategori
            if (this.selectedCategory !== 'all') {
                filtered = filtered.filter(product => product.category === this.selectedCategory);
            }
            
            // Filter berdasarkan pencarian
            if (this.searchQuery.trim()) {
                const query = this.searchQuery.toLowerCase();
                filtered = filtered.filter(product => 
                    product.name.toLowerCase().includes(query)
                );
            }
            
            return filtered;
        },
        
        paginatedProducts() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.filteredProducts.slice(start, end);
        },
        
        totalPages() {
            return Math.ceil(this.filteredProducts.length / this.itemsPerPage);
        }
    },
    watch: {
        filteredProducts() {
            // Reset ke halaman 1 saat filter berubah
            this.currentPage = 1;
        }
    },
    mounted() {
        this.fetchCategories();
        this.fetchAllProducts();
    },
    methods: {
        async fetchAllProducts() {
            try {
                this.loading = true;
                this.error = null;
                
                const response = await axios.get('/api/products');
                
                if (response.data.success) {
                    this.allProducts = response.data.data.products || [];
                } else {
                    this.error = response.data.message || 'Gagal memuat produk';
                    this.allProducts = [];
                }
                
            } catch (error) {
                this.error = 'Gagal memuat data produk dari database';
                this.allProducts = [];
            } finally {
                this.loading = false;
            }
        },
        
        async fetchCategories() {
            try {
                const response = await axios.get('/api/products/categories');
                
                if (response.data.success) {
                    this.categories = response.data.data || [];
                } else {
                    this.categories = [
                        { id: 'all', name: 'Semua' },
                        { id: 'oli', name: 'Oli' },
                        { id: 'ban', name: 'Ban' },
                        { id: 'shockbreaker', name: 'Shockbreaker' },
                        { id: 'aki', name: 'Aki' },
                        { id: 'lainnya', name: 'Lainnya' }
                    ];
                }
                
            } catch (error) {
                this.categories = [
                    { id: 'all', name: 'Semua' },
                    { id: 'oli', name: 'Oli' },
                    { id: 'ban', name: 'Ban' },
                    { id: 'shockbreaker', name: 'Shockbreaker' },
                    { id: 'aki', name: 'Aki' },
                    { id: 'lainnya', name: 'Lainnya' }
                ];
            }
        },
        
        filterByCategory(categoryId) {
            this.selectedCategory = categoryId;
        },
        
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
                // Hapus scrollToProducts() - tidak ada scroll behavior
            }
        },
        
        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                // Hapus scrollToProducts() - tidak ada scroll behavior
            }
        },
          viewProduct(product) {
            alert(`Detail produk: ${product.name}\nHarga: ${product.formatted_price}`);
        },
        
        // Fitur perbandingan produk
        addToCompare(product) {
            if (this.compareProducts.length < 3 && !this.isProductInCompare(product.id)) {
                this.compareProducts.push(product);
            }
        },
        
        removeFromCompare(productId) {
            this.compareProducts = this.compareProducts.filter(p => p.id !== productId);
        },
        
        isProductInCompare(productId) {
            return this.compareProducts.some(p => p.id === productId);
        },
        
        clearCompare() {
            this.compareProducts = [];
        },
        
        closeCompareModal() {
            this.showCompareModal = false;
        },
        
        getCategoryName(categoryId) {
            const category = this.categories.find(c => c.id === categoryId);
            return category ? category.name : 'Lainnya';
        }
    }
}
</script>