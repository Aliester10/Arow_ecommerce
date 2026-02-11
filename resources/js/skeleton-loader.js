/**
 * Skeleton Loading - Adaptive Network Detection
 * Mendeteksi kecepatan koneksi dan menampilkan skeleton loading sesuai kebutuhan
 */

class SkeletonLoader {
    constructor() {
        this.networkSpeed = this.detectNetworkSpeed();
        this.skeletonDuration = this.calculateSkeletonDuration();
        this.init();
    }

    /**
     * Deteksi kecepatan jaringan menggunakan Network Information API
     */
    detectNetworkSpeed() {
        if ('connection' in navigator) {
            const connection = navigator.connection;
            const effectiveType = connection.effectiveType || '4g';
            
            const speedMap = {
                '4g': { label: 'fast', delay: 1500 },
                '3g': { label: 'medium', delay: 3000 },
                '2g': { label: 'slow', delay: 5000 },
                'slow-2g': { label: 'very-slow', delay: 7000 }
            };
            
            return speedMap[effectiveType] || speedMap['4g'];
        }
        
        // Fallback jika API tidak tersedia
        return { label: 'unknown', delay: 2000 };
    }

    /**
     * Hitung durasi skeleton loading berdasarkan kecepatan
     */
    calculateSkeletonDuration() {
        return this.networkSpeed.delay;
    }

    /**
     * Inisialisasi skeleton loading
     */
    init() {
        document.addEventListener('DOMContentLoaded', () => {
            this.setupImageLoadingWithSkeleton();
            this.setAttributesForMonitoring();
        });
    }

    /**
     * Setup image loading dengan skeleton
     */
    setupImageLoadingWithSkeleton() {
        const images = document.querySelectorAll('[data-skeleton-image]');
        
        images.forEach(img => {
            const container = img.closest('[data-skeleton-container]');
            const skeletonElement = container?.querySelector('[data-skeleton]');
            
            if (!skeletonElement) return;

            // Mulai animasi skeleton
            this.startSkeletonAnimation(skeletonElement);

            // Handle load image
            img.addEventListener('load', () => {
                this.hideSkeletonWithTransition(skeletonElement, img);
            });

            // Handle error
            img.addEventListener('error', () => {
                this.showFallbackImage(container);
            });

            // Set timeout untuk skeleton (jika image tidak load dalam waktu tertentu)
            setTimeout(() => {
                if (!img.complete && skeletonElement.style.opacity !== '0') {
                    this.hideSkeletonWithTransition(skeletonElement, img);
                }
            }, this.skeletonDuration);
        });
    }

    /**
     * Mulai animasi skeleton (shimmer effect)
     */
    startSkeletonAnimation(element) {
        element.style.opacity = '1';
        element.classList.add('skeleton-shimmer');
    }

    /**
     * Sembunyikan skeleton dengan transisi halus
     */
    hideSkeletonWithTransition(skeleton, image) {
        skeleton.style.transition = 'opacity 0.4s ease-in-out';
        skeleton.style.opacity = '0';
        
        setTimeout(() => {
            skeleton.style.display = 'none';
            if (image) {
                image.style.display = 'block';
            }
        }, 400);
    }

    /**
     * Tampilkan fallback image jika error
     */
    showFallbackImage(container) {
        const fallback = container?.querySelector('[data-fallback-image]');
        const skeleton = container?.querySelector('[data-skeleton]');
        
        if (skeleton) {
            skeleton.style.opacity = '0';
            skeleton.style.display = 'none';
        }
        
        if (fallback) {
            fallback.style.display = 'flex';
        }
    }

    /**
     * Set attributes untuk monitoring
     */
    setAttributesForMonitoring() {
        const dataElement = document.querySelector('[data-network-speed]');
        if (dataElement) {
            dataElement.setAttribute('data-network-speed', this.networkSpeed.label);
            dataElement.setAttribute('data-skeleton-duration', this.skeletonDuration);
        }
    }

    /**
     * Public method untuk mendapatkan kecepatan jaringan
     */
    getNetworkSpeed() {
        return this.networkSpeed.label;
    }

    /**
     * Public method untuk mendapatkan durasi skeleton
     */
    getSkeletonDuration() {
        return this.skeletonDuration;
    }
}

// Inisialisasi saat page load
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new SkeletonLoader();
    });
} else {
    new SkeletonLoader();
}

export default SkeletonLoader;
