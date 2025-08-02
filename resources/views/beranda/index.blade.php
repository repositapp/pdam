@extends('layouts.first')
@section('title')
    Beranda
@endsection
@section('content')
    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">
        <div class="info d-flex align-items-center">
            <div class="container">
                <div class="row justify-content-center aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-lg-6 text-center">
                        <h2>Perumda Air Minum Tirta Takawa Kabupaten Buton</h2>
                        <p>Perumda Air Minum Tirta Takawa Kabupaten Buton berkomitmen menyediakan layanan air bersih yang
                            layak, adil, dan berkelanjutan bagi seluruh lapisan masyarakat. Dengan semangat "Mengalir,
                            Melayani, Menyejahterakan", kami hadir menjangkau wilayah terdalam, mengalirkan kehidupan, dan
                            mendukung kemajuan daerah demi Buton yang sehat, bersih, dan berdaya.</p>
                    </div>
                </div>
            </div>
        </div>
        <div id="hero-carousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-item">
                <img src="{{ URL::asset('dist/img/images/slider/3.png') }}" alt="">
            </div>
            <div class="carousel-item active">
                <img src="{{ URL::asset('dist/img/images/slider/1.png') }}" alt="">
            </div>
            <div class="carousel-item">
                <img src="{{ URL::asset('dist/img/images/slider/2.png') }}" alt="">
            </div>
            <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
            </a>
            <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
            </a>

            <ol class="carousel-indicators">
                <li data-bs-target="#hero-carousel" data-bs-slide-to="0" class=""></li>
                <li data-bs-target="#hero-carousel" data-bs-slide-to="1" class="active" aria-current="true"></li>
                <li data-bs-target="#hero-carousel" data-bs-slide-to="2" class=""></li>
            </ol>
        </div>
    </section>
    <!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">
        <div class="container">
            <div class="row position-relative">
                <div class="col-lg-7 about-img" data-aos="zoom-out" data-aos-delay="200">
                    <a href="https://www.youtube.com/watch?v=xfpXA-1Ex6k" class="glightbox stretched-link">
                        <div class="video-play"></div>
                    </a>
                    <img src="{{ URL::asset('dist/img/images/tentang/about.jpg') }}">
                </div>
                <div class="col-lg-7" data-aos="fade-up" data-aos-delay="100">
                    <h2 class="inner-title">Tentang Kami</h2>
                    <div class="our-story">
                        <p>Perusahaan Umum Daerah (Perumda) Air Minum Tirta Takawa Kabupaten Buton merupakan lembaga
                            pelayanan publik milik Pemerintah Daerah yang bertugas menyelenggarakan penyediaan dan
                            pendistribusian air bersih bagi masyarakat Kabupaten Buton. Dengan mengemban misi sosial
                            sekaligus ekonomi, Perumda Tirta Takawa berkomitmen memberikan pelayanan air minum yang
                            berkualitas, aman, dan berkesinambungan. Perusahaan ini terus melakukan perbaikan infrastruktur,
                            penguatan sistem operasional, serta perluasan jaringan pelayanan agar mampu menjangkau seluruh
                            lapisan masyarakat, termasuk wilayah-wilayah yang masih minim akses air bersih.</p>

                        <p>Dalam menghadapi tantangan meningkatnya kebutuhan air bersih akibat pertumbuhan penduduk dan
                            pembangunan daerah, Perumda Air Minum Tirta Takawa Kabupaten Buton terus berinovasi melalui
                            modernisasi teknologi dan peningkatan kapasitas produksi. Selain itu, perusahaan juga mulai
                            mengembangkan sistem pelayanan digital guna mempermudah interaksi dan pengaduan pelanggan.
                            Melalui sinergi dengan pemerintah pusat, lembaga donor, dan mitra swasta, Perumda Tirta Takawa
                            menargetkan peningkatan kualitas layanan sekaligus keberlanjutan pengelolaan sumber daya air.
                            Dengan semangat pelayanan prima, perusahaan ini bertekad menjadi penyedia layanan air minum yang
                            handal, profesional, dan berorientasi pada kepuasan masyarakat.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /About Section -->

    <!-- Announcement Section -->
    <section id="services" class="services section light-background">
        <div class="container section-title position-relative d-flex align-items-center justify-content-between">
            <h3 class="inner-title">Pengumuman</h3>
            <a href="{{ url('/pengumuman') }}">Lihat Semua <i class="bi bi-arrow-right"></i></a>
        </div>
        <div class="container">
            <div class="row gy-4">
                @foreach ($pengumumans as $pengumuman)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <a href="{{ route('pengumuman.show', $pengumuman->slug) }}">
                            <div class="service-item  position-relative">
                                <h3>{{ $pengumuman->judul }}</h3>
                                <p>{!! implode(' ', array_slice(explode(' ', $pengumuman->body), 0, 20)) !!}...</p>
                                <p class="mt-2 muted">{{ $pengumuman->created_at->translatedFormat('d F Y, h:s') }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- /Announcement Section -->
@endsection
