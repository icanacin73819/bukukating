<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BukuKating – Marketplace Buku Kuliah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:   #0f1535;
            --navy2:  #1a2252;
            --orange: #f97316;
            --blue:   #3b82f6;
            --light:  #f8fafc;
            --gray:   #64748b;
            --border: #e2e8f0;
            --white:  #ffffff;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--white);
            color: #1e293b;
            line-height: 1.6;
        }

        a { text-decoration: none; color: inherit; }

        /* ── NAVBAR ── */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 5%; height: 68px;
            background: rgba(15, 21, 53, 0.96);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .navbar-brand { display: flex; align-items: center; gap: 10px; }
        .navbar-brand img { height: 36px; width: 36px; object-fit: contain; }
        .navbar-brand span { font-size: 1.1rem; font-weight: 800; color: #fff; letter-spacing: -0.3px; }
        .navbar-brand small { display: block; font-size: 0.62rem; font-weight: 400; color: #94a3b8; letter-spacing: 0.5px; }
        .nav-links { display: flex; align-items: center; gap: 2rem; }
        .nav-links a { color: #cbd5e1; font-size: 0.875rem; font-weight: 500; transition: color .2s; }
        .nav-links a:hover { color: #fff; }
        .nav-actions { display: flex; align-items: center; gap: 0.75rem; }
        .btn-ghost { padding: 8px 20px; border-radius: 8px; font-size: 0.875rem; font-weight: 600; color: #fff; border: 1px solid rgba(255,255,255,0.2); transition: all .2s; }
        .btn-ghost:hover { background: rgba(255,255,255,0.1); }
        
        .nav-user { display: flex; align-items: center; gap: 8px; }
        .nav-user-avatar { width: 32px; height: 32px; border-radius: 50%; background: var(--orange); color: #fff; font-weight: 700; font-size: 0.8rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .nav-user-name { font-size: 0.85rem; font-weight: 600; color: #fff; }
        
        .btn-primary { padding: 8px 20px; border-radius: 8px; font-size: 0.875rem; font-weight: 600; background: var(--orange); color: #fff; transition: all .2s; }
        .btn-primary:hover { background: #ea6c0a; }

        /* ── HERO ── */
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f1535 0%, #1a2252 50%, #0f1535 100%);
            display: flex; align-items: center;
            padding: 120px 5% 80px;
            position: relative; overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(ellipse 60% 50% at 80% 50%, rgba(59,130,246,0.12) 0%, transparent 70%),
                        radial-gradient(ellipse 40% 40% at 20% 70%, rgba(249,115,22,0.08) 0%, transparent 60%);
        }
        .hero-dots {
            position: absolute; inset: 0;
            background-image: radial-gradient(rgba(255,255,255,0.06) 1px, transparent 1px);
            background-size: 32px 32px;
        }
        
        /* STEP 1 — Kembalikan grid 2 kolom di hero */
        .hero-inner { 
            max-width: 1200px; 
            margin: 0 auto; 
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 4rem; 
            align-items: center; 
            position: relative; 
            z-index: 1; 
            width: 100%; 
        }
        
        .hero-badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; background: rgba(59,130,246,0.15); border: 1px solid rgba(59,130,246,0.3); border-radius: 100px; font-size: 0.75rem; font-weight: 600; color: #93c5fd; margin-bottom: 1.5rem; }
        .hero-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: #3b82f6; animation: pulse 2s infinite; }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }
        .hero h1 { font-size: clamp(2rem, 4vw, 3.25rem); font-weight: 800; color: #fff; line-height: 1.15; letter-spacing: -0.5px; margin-bottom: 1.25rem; }
        .hero h1 .accent { color: var(--orange); }
        .hero p { color: #94a3b8; font-size: 1.05rem; line-height: 1.7; margin-bottom: 2rem; max-width: 500px; }
        .hero-cta { display: flex; gap: 1rem; flex-wrap: wrap; }
        .btn-hero-primary { display: inline-flex; align-items: center; gap: 8px; padding: 14px 28px; background: var(--blue); color: #fff; border-radius: 10px; font-weight: 700; font-size: 0.95rem; transition: all .2s; }
        .btn-hero-primary:hover { background: #2563eb; transform: translateY(-1px); }
        .btn-hero-outline { display: inline-flex; align-items: center; gap: 8px; padding: 14px 28px; border: 1.5px solid rgba(255,255,255,0.25); color: #fff; border-radius: 10px; font-weight: 700; font-size: 0.95rem; transition: all .2s; }
        .btn-hero-outline:hover { background: rgba(255,255,255,0.08); }

        .hero-card {
            position: relative;
            width: 100%;
            height: 420px;
            border-radius: 24px;
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(255, 255, 255, .1);
            overflow: hidden;
        }
        .hero-card-default { 
            display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; gap: 1rem; text-align: center; 
        }
        .hero-card-default img { width: 260px; height: 260px; object-fit: contain; }
        .hero-card-default h3 { font-size: 1.4rem; font-weight: 800; color: #fff; }
        .hero-card-default p { font-size: 0.85rem; color: #94a3b8; }

        /* ── FITUR ── */
        .features { padding: 5rem 5%; background: var(--white); border-bottom: 1px solid var(--border); }
        .features-inner { max-width: 1200px; margin: 0 auto; }
        .features-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; }
        .feature-item { display: flex; align-items: flex-start; gap: 1rem; padding: 1.5rem; border: 1px solid var(--border); border-radius: 14px; transition: box-shadow .2s; }
        .feature-item:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.07); }
        .feature-icon { width: 42px; height: 42px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0; }
        .feature-icon.blue { background: #eff6ff; }
        .feature-icon.orange { background: #fff7ed; }
        .feature-icon.green { background: #f0fdf4; }
        .feature-icon.purple { background: #faf5ff; }
        .feature-item h4 { font-size: 0.9rem; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
        .feature-item p { font-size: 0.8rem; color: var(--gray); line-height: 1.5; }

        /* ── MARKETPLACE ── */
        .marketplace { padding: 5rem 5%; background: var(--light); }
        .marketplace-inner { max-width: 1200px; margin: 0 auto; }
        .section-eyebrow { font-size: 0.75rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: var(--blue); margin-bottom: 0.5rem; }
        .section-title { font-size: clamp(1.5rem, 3vw, 2rem); font-weight: 800; color: #0f172a; margin-bottom: 0.5rem; }
        .section-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem; gap: 1rem; flex-wrap: wrap; }
        .search-filter { display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap; }
        .search-box { display: flex; align-items: center; gap: 8px; background: #fff; border: 1px solid var(--border); border-radius: 10px; padding: 8px 14px; min-width: 220px; }
        .search-box input { border: none; outline: none; font-size: 0.85rem; font-family: inherit; color: #1e293b; width: 100%; }
        .search-box span { color: #94a3b8; }
        .filter-select { padding: 9px 14px; border: 1px solid var(--border); border-radius: 10px; font-size: 0.85rem; font-family: inherit; background: #fff; color: #1e293b; cursor: pointer; outline: none; }

        /* Book grid */
        .books-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
        .book-card { background: #fff; border-radius: 16px; border: 1px solid var(--border); overflow: hidden; transition: all .2s; }
        .book-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(0,0,0,0.1); }
        .book-img { width: 100%; height: 200px; object-fit: cover; display: block; }
        .book-img-placeholder { width: 100%; height: 200px; background: linear-gradient(135deg, #e2e8f0, #f1f5f9); display: flex; align-items: center; justify-content: center; font-size: 3rem; }
        .book-body { padding: 1.25rem; }
        .book-title { font-size: 0.95rem; font-weight: 700; color: #0f172a; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .book-author { font-size: 0.8rem; color: var(--gray); margin-bottom: 0.75rem; }
        .book-price { font-size: 1.15rem; font-weight: 800; color: var(--blue); margin-bottom: 0.75rem; }
        .book-footer { display: flex; align-items: center; justify-content: space-between; }
        .badge-status { padding: 4px 10px; border-radius: 100px; font-size: 0.7rem; font-weight: 700; }
        .badge-tersedia { background: #f0fdf4; color: #16a34a; }
        .badge-terjual { background: #fef2f2; color: #dc2626; }
        .btn-detail { font-size: 0.8rem; font-weight: 600; color: var(--blue); }
        .btn-detail:hover { text-decoration: underline; }

        /* Empty state */
        .empty-state { background: #fff; border: 2px dashed var(--border); border-radius: 16px; padding: 4rem; text-align: center; }
        .empty-state .icon { font-size: 3rem; margin-bottom: 1rem; display: block; }
        .empty-state h3 { font-size: 1rem; font-weight: 700; color: #1e293b; margin-bottom: 0.5rem; }
        .empty-state p { font-size: 0.875rem; color: var(--gray); }

        /* ── CARA KERJA ── */
        .workflow { padding: 5rem 5%; background: var(--navy); }
        .workflow-inner { max-width: 1200px; margin: 0 auto; text-align: center; }
        .workflow .section-eyebrow { color: #93c5fd; }
        .workflow .section-title { color: #fff; margin-bottom: 0.5rem; }
        .workflow-sub { color: #94a3b8; font-size: 0.95rem; margin-bottom: 3rem; }
        .workflow-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; margin-top: 3rem; }
        .workflow-item { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 2rem 1.5rem; text-align: center; }
        .step-num { width: 44px; height: 44px; border-radius: 12px; background: var(--blue); color: #fff; font-weight: 800; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; }
        .workflow-item h4 { font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: 0.5rem; }
        .workflow-item p { font-size: 0.82rem; color: #94a3b8; line-height: 1.6; }

        /* ── TENTANG ── */
        .about { padding: 5rem 5%; background: var(--white); }
        .about-inner { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: start; }
        .about h2 { font-size: clamp(1.5rem, 3vw, 2rem); font-weight: 800; color: #0f172a; line-height: 1.2; margin-bottom: 1rem; }
        .about h2 .accent { color: var(--blue); }
        .about p { color: var(--gray); font-size: 0.95rem; line-height: 1.75; margin-bottom: 1rem; }
        .about-box { background: var(--light); border: 1px solid var(--border); border-radius: 16px; padding: 1.75rem; margin-bottom: 1.25rem; }
        .about-box h4 { display: flex; align-items: center; gap: 8px; font-size: 1rem; font-weight: 700; color: #0f172a; margin-bottom: 0.75rem; }
        .about-box p { font-size: 0.875rem; color: var(--gray); line-height: 1.65; margin: 0; }
        .about-list { list-style: none; display: flex; flex-direction: column; gap: 0.5rem; margin-top: 0.75rem; }
        .about-list li { display: flex; align-items: flex-start; gap: 8px; font-size: 0.875rem; color: var(--gray); }
        .about-list li::before { content: '✓'; color: #16a34a; font-weight: 700; margin-top: 1px; }

        /* ── FOOTER ── */
        .footer { background: var(--navy); color: #94a3b8; padding: 3.5rem 5% 2rem; }
        .footer-inner { max-width: 1200px; margin: 0 auto; }
        .footer-top { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 3rem; padding-bottom: 2.5rem; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .footer-brand { display: flex; align-items: center; gap: 10px; margin-bottom: 0.75rem; }
        .footer-brand img { height: 36px; width: 36px; object-fit: contain; }
        .footer-brand span { font-size: 1.1rem; font-weight: 800; color: #fff; }
        .footer-desc { font-size: 0.83rem; line-height: 1.7; max-width: 280px; }
        .footer-col h5 { font-size: 0.85rem; font-weight: 700; color: #fff; margin-bottom: 1rem; letter-spacing: 0.3px; }
        .footer-col a, .footer-col p { display: block; font-size: 0.83rem; color: #94a3b8; margin-bottom: 0.5rem; transition: color .2s; }
        .footer-col a:hover { color: #fff; }
        .footer-bottom { display: flex; justify-content: space-between; align-items: center; padding-top: 1.5rem; flex-wrap: wrap; gap: 1rem; }
        .footer-bottom p { font-size: 0.8rem; }
        .footer-links { display: flex; gap: 1.5rem; }
        .footer-links a { font-size: 0.8rem; color: #94a3b8; }
        .footer-links a:hover { color: #fff; }
        .developer-credit a { color: var(--blue); font-weight: 600; font-size: 0.83rem; }

        @media (max-width: 900px) {
            .nav-links { display: none; }
            .nav-user-name { display: none; }
            .hero-inner { grid-template-columns: 1fr; }
            .hero-card { display: none; }
            .features-grid { grid-template-columns: 1fr 1fr; }
            .books-grid { grid-template-columns: 1fr 1fr; }
            .workflow-grid { grid-template-columns: 1fr 1fr; }
            .about-inner { grid-template-columns: 1fr; }
            .footer-top { grid-template-columns: 1fr 1fr; }
        }

        /* ── PROMO BANNER ── */
        .promo-banner-section {
    background: var(--white);
    padding: 2rem 5% 2rem;
}
        .promo-banner-section .promo-banner-inner {
            max-width: 1200px;
            margin: 0 auto;
        }
        .promo-banner-label {
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--orange);
            margin-bottom: 0.75rem;
        }
        .promo-banner-track {
            display: flex;
            gap: 1rem;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 0.5rem;
            scrollbar-width: none;
        }
        .promo-banner-track::-webkit-scrollbar { display: none; }
        .promo-banner-card {
            flex: 0 0 100%;
            scroll-snap-align: start;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy2) 100%);
            border: 1px solid rgba(59,130,246,0.25);
            border-radius: 18px;
            padding: 1.5rem 2rem;
            gap: 1.5rem;
            min-height: 110px;
        }
        .promo-banner-card-left {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            flex: 1;
            min-width: 0;
        }
        .promo-banner-book-img {
            width: 64px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }
        .promo-banner-book-img-placeholder {
            width: 64px;
            height: 80px;
            border-radius: 8px;
            background: rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            flex-shrink: 0;
        }
        .promo-banner-info { min-width: 0; }
        .promo-tag-sm {
            display: inline-block;
            padding: 3px 10px;
            background: var(--orange);
            color: #fff;
            border-radius: 999px;
            font-size: 0.68rem;
            font-weight: 700;
            margin-bottom: 6px;
        }
        .promo-banner-title {
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 380px;
        }
        .promo-banner-author {
            font-size: 0.8rem;
            color: #94a3b8;
            margin-top: 2px;
        }
        .promo-banner-price {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--blue);
            flex-shrink: 0;
        }
        .promo-banner-btn {
            display: inline-flex;
            align-items: center;
            padding: 10px 22px;
            background: var(--blue);
            color: #fff;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.875rem;
            transition: all .2s;
            flex-shrink: 0;
            white-space: nowrap;
        }
        .promo-banner-btn:hover { background: #2563eb; }
        .promo-dots-sm {
            display: flex;
            justify-content: center;
            gap: 6px;
            margin-top: 0.75rem;
        }
        .promo-dot-sm {
            width: 7px; height: 7px;
            border-radius: 50%;
            background: #cbd5e1;
            cursor: pointer;
            transition: background .2s;
        }
        .promo-dot-sm.active { background: var(--blue); }
        @media (max-width: 600px) {
            .features-grid, .books-grid, .workflow-grid { grid-template-columns: 1fr; }
            .footer-top { grid-template-columns: 1fr; }
            .promo-banner-card { flex-wrap: wrap; padding: 1.25rem; }
            .promo-banner-title { max-width: 200px; }
            .promo-banner-price { font-size: 1.2rem; }
        }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar">
    <a href="{{ url('/') }}" class="navbar-brand">
        <img src="{{ asset('images/logobukukating.png') }}" alt="BukuKating">
        <div>
            <span>BukuKating</span>
            <small>MARKETPLACE BUKU KULIAH</small>
        </div>
    </a>
    <div class="nav-links">
        <a href="{{ url('/') }}">Beranda</a>
        <a href="#cara-kerja">Panduan</a>
        <a href="#marketplace">Marketplace</a>
        <a href="#tentang">Tentang</a>
        <a href="#kontak">Kontak</a>
    </div>
    <div class="nav-actions">
        @auth
            <div class="nav-user">
                <div class="nav-user-avatar">{{ Str::upper(Str::substr(Auth::user()->name, 0, 1)) }}</div>
                <span class="nav-user-name">{{ Auth::user()->name }}</span>
            </div>
            <a href="{{ route('dashboard') }}" class="btn-ghost">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="btn-ghost">Login</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn-primary">Register</a>
            @endif
        @endauth
    </div>
</nav>

@php
    $promotions = \App\Models\BannerOrder::with('book.images')
        ->where('status', 'approved')
        ->where('starts_at', '<=', now())
        ->where('ends_at', '>=', now())
        ->get();
@endphp

{{-- HERO --}}
<section class="hero">
    <div class="hero-dots"></div>
    <div class="hero-inner">
        {{-- hero-content --}}
        <div class="hero-content">
            <div class="hero-badge">#1 Marketplace Buku Mahasiswa Indonesia</div>
            <h1>Cari Buku Kuliah<br><span class="accent">Hemat & Mudah</span> di<br>BukuKating</h1>
            <p>Platform jual beli buku kuliah bekas khusus mahasiswa. Hubungkan kebutuhan akademikmu dengan cutting (kakak tingkat) di seluruh universitas Indonesia secara aman, praktis, dan ramah kantong.</p>
            <div class="hero-cta">
                <a href="{{ route('marketplace') }}" class="btn-hero-primary">
                    🔍 Jelajahi Koleksi
                </a>
                @auth
                    <a href="{{ route('books.create') }}" class="btn-hero-outline">
                        📖 Mulai Jual Buku
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn-hero-outline">
                        📖 Mulai Jual Buku
                    </a>
                @endauth
            </div>
        </div>
        
        {{-- STEP 2 — Kembalikan hero-card di HTML, tapi isi default aja --}}
        {{-- hero-card kanan --}}
        <div class="hero-card">
            <div class="hero-card-default">
                <img src="{{ asset('images/logobukukating.png') }}" alt="BukuKating">
                <h3>BukuKating</h3>
                <p>Buku bekas, Ilmu tak terbatas</p>
            </div>
        </div>
    </div>
</section>

{{-- FITUR --}}
<section class="features">
    <div class="features-inner">
        <div class="features-grid">
            <div class="feature-item">
                <div class="feature-icon blue">📚</div>
                <div>
                    <h4>Ribuan Buku</h4>
                    <p>Koleksi referensi kuliah terlengkap dari berbagai universitas.</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon orange">🏷️</div>
                <div>
                    <h4>Harga Mahasiswa</h4>
                    <p>Diskon besar dibanding buku baru, cocok untuk kantong mahasiswa.</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon green">🎓</div>
                <div>
                    <h4>COD Area Kampus</h4>
                    <p>Bisa ketemu langsung di area kampus terdekat dengan aman.</p>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon purple">🛡️</div>
                <div>
                    <h4>Komunitas Aman</h4>
                    <p>Profil pengguna yang terverifikasi dengan email kampus.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- PROMO BANNER --}}
@if($promotions->count())
<section class="promo-banner-section">
    <div class="promo-banner-inner">
        <p class="promo-banner-label">🔥 Buku Unggulan & Promosi</p>
        <div class="promo-banner-track" id="promoBannerTrack">
            @foreach($promotions as $promo)
            <div class="promo-banner-card">
                <div class="promo-banner-card-left">
                    @if($promo->book->images->first())
                        <img class="promo-banner-book-img" 
                             src="{{ asset('storage/'.$promo->book->images->first()->image) }}" 
                             alt="{{ $promo->book->title }}">
                    @else
                        <div class="promo-banner-book-img-placeholder">📖</div>
                    @endif
                    <div class="promo-banner-info">
                        <span class="promo-tag-sm">🚀 PROMOSI</span>
                        <p class="promo-banner-title">{{ $promo->book->title }}</p>
                        <p class="promo-banner-author">{{ $promo->book->author }}</p>
                    </div>
                </div>
                <div class="promo-banner-price">
                    Rp{{ number_format($promo->book->price, 0, ',', '.') }}
                </div>
                <a href="{{ route('books.show', $promo->book) }}" class="promo-banner-btn">
                    Lihat Buku →
                </a>
            </div>
            @endforeach
        </div>
        @if($promotions->count() > 1)
        <div class="promo-dots-sm" id="promoDots">
            @foreach($promotions as $i => $promo)
                <span class="promo-dot-sm {{ $i == 0 ? 'active' : '' }}" data-index="{{ $i }}"></span>
            @endforeach
        </div>
        @endif
    </div>
</section>
@endif

{{-- MARKETPLACE --}}
<section class="marketplace" id="marketplace">
    <div class="marketplace-inner">
        <div class="section-header">
            <div class="section-header-left">
                <p class="section-eyebrow">MARKETPLACE</p>
                <h2 class="section-title">Koleksi Buku Terkini</h2>
            </div>
            <div class="search-filter">
                <div class="search-box">
                    <span>🔍</span>
                    <input type="text" id="searchInput" placeholder="Cari judul, penulis, atau matkul..." oninput="filterBooks()">
                </div>
                <select class="filter-select" id="categoryFilter" onchange="filterBooks()">
                    <option value="">Semua Mata Kuliah</option>
                    @foreach(\App\Models\Category::all() as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                <select class="filter-select" id="cityFilter" onchange="filterBooks()">
                    <option value="">Semua Lokasi</option>
                    @foreach(\App\Models\Book::where('status', 'tersedia')->whereNotNull('city')->distinct()->orderBy('city')->pluck('city') as $city)
                        <option value="{{ strtolower($city) }}">{{ $city }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @php
            $books = \App\Models\Book::with(['images', 'category'])
                ->where('status', 'tersedia')
                ->latest()
                ->take(6)
                ->get();
        @endphp

        @if($books->isEmpty())
            <div class="empty-state">
                <span class="icon">📭</span>
                <h3>Buku tidak ditemukan</h3>
                <p>Coba periksa kembali kata kunci pencarianmu atau ganti filter mata kuliah yang dipilih.</p>
            </div>
        @else
            <div class="books-grid" id="booksGrid">
                @foreach($books as $book)
                <div class="book-card" data-title="{{ strtolower($book->title) }}" data-author="{{ strtolower($book->author) }}" data-category="{{ $book->category_id }}" data-city="{{ strtolower($book->city) }}">
                    @if($book->images->first())
                        <img class="book-img" src="{{ asset('storage/'.$book->images->first()->image) }}" alt="{{ $book->title }}">
                    @else
                        <div class="book-img-placeholder">📖</div>
                    @endif
                    <div class="book-body">
                        <h3 class="book-title">{{ $book->title }}</h3>
                        <p class="book-author">{{ $book->author }}</p>
                        <p class="book-price">Rp{{ number_format($book->price, 0, ',', '.') }}</p>
                        <div class="book-footer">
                            <span class="badge-status {{ $book->status === 'tersedia' ? 'badge-tersedia' : 'badge-terjual' }}">
                                {{ ucfirst($book->status) }}
                            </span>
                            <a href="{{ route('books.show', $book) }}" class="btn-detail">Lihat Detail →</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div style="text-align:center; margin-top:2.5rem;">
                @auth
                    <a href="{{ route('marketplace') }}" class="btn-hero-primary" style="display:inline-flex;">
                        Lihat Semua Buku →
                    </a>
                @else
                    <a href="{{ route('login', ['redirect' => 'marketplace']) }}" class="btn-hero-primary" style="display:inline-flex;">
                        Lihat Semua Buku →
                    </a>
                @endauth
            </div>
        @endif
    </div>
</section>

{{-- CARA KERJA --}}
<section class="workflow" id="cara-kerja">
    <div class="workflow-inner">
        <p class="section-eyebrow">WORKFLOW</p>
        <h2 class="section-title">Cara Kerja BukuKating</h2>
        <p class="workflow-sub">Mudah, transparan, dan efisien hanya dalam 4 langkah praktis.</p>
        <div class="workflow-grid">
            <div class="workflow-item">
                <div class="step-num">1</div>
                <h4>Daftar Akun</h4>
                <p>Buat akun mahasiswamu menggunakan email aktif untuk keamanan validasi.</p>
            </div>
            <div class="workflow-item">
                <div class="step-num">2</div>
                <h4>Cari Buku</h4>
                <p>Filter pencarian berdasarkan judul, jurusan, penulis, atau lokasi kampus terdekat.</p>
            </div>
            <div class="workflow-item">
                <div class="step-num">3</div>
                <h4>Hubungi Kating</h4>
                <p>Hubungi pemilik buku secara langsung untuk janjian bertemu di area kampus.</p>
            </div>
            <div class="workflow-item">
                <div class="step-num">4</div>
                <h4>Selesai Transaksi</h4>
                <p>Periksa kondisi buku langsung saat COD, bayar aman, dan raih kesuksesan studimu!</p>
            </div>
        </div>
    </div>
</section>

{{-- TENTANG --}}
<section class="about" id="tentang">
    <div class="about-inner">
        <div>
            <p class="section-eyebrow">TENTANG KAMI</p>
            <h2>Mengenal Lebih Dekat<br><span class="accent">Ekosistem BukuKating</span></h2>
            <p>BukuKating hadir atas keresahan mahasiswa mengenai tingginya harga buku kuliah baru, padahal masa pakainya seringkali hanya satu semester. Platform ini dirancang ramah guna bagi mahasiswa agar dapat menghemat pengeluaran akademis mereka.</p>
            <p>Dengan membeli buku bekas layak pakai, kamu tidak hanya menghemat dompet, tetapi juga berkontribusi nyata dalam gerakan ramah lingkungan (eco-friendly) dengan menekan angka limbah kertas industri perbukuan.</p>
        </div>
        <div class="about-right">
            <div class="about-box">
                <h4>🎯 Visi Kami</h4>
                <p>Menjadi platform sirkuler ekonomi buku kuliah nomor satu di Indonesia yang menjembatani jutaan mahasiswa dari Sabang sampai Merauke dalam akses literasi yang setara dan murah.</p>
            </div>
            <div class="about-box">
                <h4>🚀 Misi Utama</h4>
                <ul class="about-list">
                    <li>Menyediakan platform digital yang mempermudah mahasiswa dalam menjual dan membeli buku kuliah bekas.</li>
                    <li>Membantu mahasiswa memperoleh bahan ajar dengan harga yang lebih terjangkau.</li>
                    <li>Mendorong budaya pemanfaatan kembali buku kuliah untuk mengurangi pemborosan sumber daya.</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer class="footer" id="kontak">
    <div class="footer-inner">
        <div class="footer-top">
            <div>
                <div class="footer-brand">
                    <img src="{{ asset('images/logobukukating.png') }}" alt="BukuKating">
                    <span>BukuKating</span>
                </div>
                <p class="footer-desc">Solusi cerdas berburu referensi kuliah berkualitas tanpa kuras kantong. Menjembatani mahasiswa seluruh Indonesia dengan pendidikan yang inklusif.</p>
            </div>
            <div class="footer-col" id="kontak-info">
    <h5>HUBUNGI KAMI</h5>
    <div class="footer-contact-list">
        <a href="mailto:bukukating@gmail.com" class="footer-contact-item">
            <span class="footer-contact-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
            </span>
            bukukating@gmail.com
        </a>
        <a href="https://instagram.com/BukuKating" target="_blank" class="footer-contact-item">
            <span class="footer-contact-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
            </span>
            BukuKating
        </a>
        <a href="https://tiktok.com/@BukuKating" target="_blank" class="footer-contact-item">
            <span class="footer-contact-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"/></svg>
            </span>
            BukuKating
        </a>
    </div>
</div>
            <div class="footer-col">
                <h5>DEVELOPER</h5>
                <p>Dibuat dengan dedikasi tinggi untuk kemajuan mahasiswa Indonesia.</p>
                <div class="developer-credit" style="margin-top:0.5rem;">
                    <a href="#">Ikhsan Pratama</a>
                    <p style="font-size:0.75rem; margin-top:2px;">Full-Stack Web Developer</p>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2026 BukuKating. Hak Cipta Dilindungi.</p>
            <div class="footer-links">
                <a href="#">Terms of Service</a>
                <a href="#">Privacy Policy</a>
            </div>
        </div>
    </div>
</footer>

{{-- SCRIPT JAVASCRIPT --}}
<script>
function filterBooks() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const category = document.getElementById('categoryFilter').value;
    const city = document.getElementById('cityFilter').value;
    const cards = document.querySelectorAll('.book-card');
    cards.forEach(card => {
        const title = card.dataset.title || '';
        const author = card.dataset.author || '';
        const cat = card.dataset.category || '';
        const cardCity = card.dataset.city || '';
        const matchSearch = !search || title.includes(search) || author.includes(search);
        const matchCat = !category || cat === category;
        const matchCity = !city || cardCity === city;
        card.style.display = (matchSearch && matchCat && matchCity) ? '' : 'none';
    });
}

// ── PROMO BANNER SCROLL ──
const bannerTrack = document.getElementById('promoBannerTrack');
const bannerDots  = document.querySelectorAll('.promo-dot-sm');
if (bannerTrack && bannerDots.length) {
    bannerDots.forEach(dot => {
        dot.addEventListener('click', () => {
            const idx = Number(dot.dataset.index);
            const cardWidth = bannerTrack.offsetWidth;
            bannerTrack.scrollTo({ left: cardWidth * idx, behavior: 'smooth' });
            bannerDots.forEach(d => d.classList.remove('active'));
            dot.classList.add('active');
        });
    });
    bannerTrack.addEventListener('scroll', () => {
        const idx = Math.round(bannerTrack.scrollLeft / bannerTrack.offsetWidth);
        bannerDots.forEach((d, i) => d.classList.toggle('active', i === idx));
    });
}
</script>

</body>
</html>