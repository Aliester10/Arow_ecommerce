@extends('layouts.app')

@section('content')
<style>
/* Hero Section Styles */
.hero-section {
    position: relative;
    min-height: 500px;
    background: linear-gradient(135deg, rgba(251, 146, 60, 0.9) 0%, rgba(254, 215, 170, 0.8) 50%, rgba(255, 255, 255, 0.7) 100%),
                url('https://images.unsplash.com/photo-1497366214041-512f6b9a5466?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    display: flex;
    align-items: center;
    overflow: hidden;
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    color: white;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    margin-bottom: 1rem;
}

.breadcrumb {
    color: rgba(255,255,255,0.9);
    font-size: 1rem;
}

.breadcrumb a {
    color: white;
    text-decoration: none;
    transition: opacity 0.3s;
}

.breadcrumb a:hover {
    opacity: 0.8;
}

/* Company Profile Section */
.company-profile {
    padding: 5rem 0;
    background: linear-gradient(135deg, #ffffff 0%, #fef9f7 100%);
}

.company-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 1rem;
}

.company-subtitle {
    font-size: 1.5rem;
    font-weight: 600;
    color: #ea580c;
    margin-bottom: 2rem;
}

.company-description {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #4b5563;
    margin-bottom: 2rem;
}

.cta-button {
    background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%);
    color: white;
    padding: 1rem 2.5rem;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(234, 88, 12, 0.3);
}

.cta-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(234, 88, 12, 0.4);
    color: white;
}

.website-mockup {
    width: 100%;
    height: 400px;
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    border-radius: 15px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.website-mockup::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 40px;
    background: #e5e7eb;
    border-bottom: 1px solid #d1d5db;
}

.website-mockup::after {
    content: 'ayobelanja.co.id';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 1.5rem;
    font-weight: 700;
    color: #ea580c;
}

/* Vision & Mission Sections */
.vision-mission-section {
    padding: 4rem 0;
    background: #f9fafb;
}

.vm-box {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    transition: transform 0.3s ease;
}

.vm-box:hover {
    transform: translateY(-5px);
}

.vm-title {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 1.8rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 2rem;
}

.vm-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.vm-content {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #4b5563;
}

.highlight-text {
    color: #ea580c;
    font-weight: 600;
}

/* Mission Items */
.mission-item {
    display: flex;
    align-items: flex-start;
    gap: 1.5rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: #fef9f7;
    border-radius: 15px;
    transition: all 0.3s ease;
}

.mission-item:hover {
    background: #fef3ed;
    transform: translateX(5px);
}

.mission-number {
    min-width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1.1rem;
}

.mission-content h4 {
    font-size: 1.2rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.mission-content p {
    color: #6b7280;
    line-height: 1.6;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .company-title {
        font-size: 2rem;
    }
    
    .company-subtitle {
        font-size: 1.2rem;
    }
    
    .vm-box {
        padding: 2rem;
    }
    
    .mission-item {
        flex-direction: column;
        text-align: center;
    }
    
    .mission-number {
        margin: 0 auto;
    }
}
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container mx-auto px-4">
        <div class="hero-content">
            <nav class="breadcrumb mb-4">
                <a href="{{ route('home') }}">Beranda</a> > Tentang Kami
            </nav>
            <h1 class="hero-title">Tentang Kami</h1>
        </div>
    </div>
</section>

<!-- Company Profile Section -->
<section class="company-profile">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="company-title">PT Aro Baskara Esa</h2>
                <h3 class="company-subtitle">Belanja Tepat, Layanan Cepat, Kualitas Hebat</h3>
                <p class="company-description">
                    PT Aro Baskara Esa adalah perusahaan yang bergerak di bidang pengadaan B2B (Business-to-Business) 
                    yang menyediakan solusi lengkap untuk kebutuhan barang dan jasa perusahaan. Dengan pengalaman 
                    bertahun-tahun dalam industri pengadaan, kami telah membangun reputasi sebagai mitra terpercaya 
                    bagi berbagai perusahaan di Indonesia.
                </p>
                <p class="company-description">
                    Melalui platform e-commerce kami di ayobelanja.co.id, kami menghadirkan pengalaman berbelanja 
                    yang modern, efisien, dan transparan. Sistem kami dirancang khusus untuk memenuhi kebutuhan 
                    pengadaan perusahaan dengan proses yang disederhanakan, harga kompetitif, dan kualitas produk 
                    yang terjamin.
                </p>
                <a href="https://ayobelanja.co.id" target="_blank" class="cta-button">
                    Kunjungi Website Kami
                </a>
            </div>
            <div>
                <div class="website-mockup"></div>
            </div>
        </div>
    </div>
</section>

<!-- Vision Section -->
<section class="vision-mission-section">
    <div class="container mx-auto px-4">
        <div class="mb-12">
            <div class="vm-box">
                <div class="vm-title">
                    <div class="vm-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    VISI
                </div>
                <div class="vm-content">
                    <p>
                        Menjadi mitra pengadaan terdepan di Indonesia yang memberikan solusi inovatif dan 
                        terintegrasi untuk kebutuhan B2B. Kami berkomitmen untuk terus berinovasi dalam 
                        menghadirkan pengalaman berbelanja yang <span class="highlight-text">Belanja Tepat, 
                        Layanan Cepat, Kualitas Hebat</span> bagi setiap pelanggan kami.
                    </p>
                </div>
            </div>
        </div>

        <!-- Mission Section -->
        <div>
            <div class="vm-box">
                <div class="vm-title">
                    <div class="vm-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    MISI
                </div>
                <div class="vm-content">
                    <div class="mission-item">
                        <div class="mission-number">1</div>
                        <div class="mission-content">
                            <h4>Belanja Tepat</h4>
                            <p>
                                Menyediakan produk yang sesuai dengan kebutuhan spesifik perusahaan dengan 
                                katalog lengkap dan sistem rekomendasi yang akurat untuk memastikan setiap 
                                pembelian adalah keputusan yang tepat.
                            </p>
                        </div>
                    </div>
                    
                    <div class="mission-item">
                        <div class="mission-number">2</div>
                        <div class="mission-content">
                            <h4>Layanan Cepat</h4>
                            <p>
                                Menghadirkan proses pengadaan yang efisien dengan sistem otomatisasi, 
                                pengiriman tepat waktu, dan responsif customer service untuk memastikan 
                                kebutuhan perusahaan terpenuhi dengan cepat.
                            </p>
                        </div>
                    </div>
                    
                    <div class="mission-item">
                        <div class="mission-number">3</div>
                        <div class="mission-content">
                            <h4>Kualitas Hebat</h4>
                            <p>
                                Menjamin kualitas produk terbaik melalui seleksi supplier ketat, sistem 
                                kontrol kualitas yang komprehensif, dan jaminan kepuasan pelanggan untuk 
                                setiap transaksi yang dilakukan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
