<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f7f8fc">
    <title>@yield('title', 'Dashboard') · InvenTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root{--ink:#17233c;--muted:#778198;--brand:#5367e8;--brand-dark:#4052cf;--line:#e9edf5;--canvas:#f7f8fc}
        body{background:var(--canvas);color:var(--ink);font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",sans-serif;font-size:.94rem}
        .sidebar{width:250px;min-height:100vh;background:#fff;border-right:1px solid var(--line);position:fixed;inset:0 auto 0 0;z-index:1030;padding:1.6rem 1rem}
        .brand-mark{width:42px;height:42px;display:grid;place-items:center;border-radius:14px;background:linear-gradient(135deg,#6678f2,#4858d7);color:white;font-size:1.25rem;box-shadow:0 8px 18px #5367e833}
        .brand-name{font-weight:800;letter-spacing:-.5px;font-size:1.15rem}
        .nav-caption{font-size:.68rem;font-weight:800;color:#a1a9ba;letter-spacing:1.2px;padding:.7rem .8rem .45rem}
        .side-link{display:flex;align-items:center;gap:.8rem;padding:.78rem .85rem;border-radius:12px;text-decoration:none;color:#69748b;font-weight:600;margin:.2rem 0;transition:.2s}
        .side-link i{font-size:1.1rem;width:22px}.side-link:hover{background:#f4f5ff;color:var(--brand)}.side-link.active{background:#eef0ff;color:var(--brand)}
        .main{margin-left:250px;min-height:100vh}.topbar{height:78px;background:#fff;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;padding:0 2.2rem}
        .page-wrap{padding:2rem 2.2rem 3rem;max-width:1600px;margin:auto}.eyebrow{color:var(--brand);font-size:.72rem;letter-spacing:1.4px;font-weight:800;text-transform:uppercase}
        .page-title{font-weight:800;letter-spacing:-1px;font-size:clamp(1.55rem,2vw,2rem);margin:.25rem 0}.subtle{color:var(--muted)}
        .card{border:1px solid #edf0f6;border-radius:18px;box-shadow:0 5px 24px #26345b08}.stat-card{padding:1.2rem 1.3rem;height:100%;background:#fff}.stat-icon{height:46px;width:46px;border-radius:14px;display:grid;place-items:center;font-size:1.25rem}
        .stat-value{font-size:1.75rem;font-weight:800;letter-spacing:-.8px;line-height:1.2}.stat-label{font-size:.82rem;color:var(--muted);font-weight:600}
        .btn{border-radius:10px;font-weight:650;padding:.62rem .95rem}.btn-primary{background:var(--brand);border-color:var(--brand)}.btn-primary:hover{background:var(--brand-dark);border-color:var(--brand-dark)}
        .btn-light{background:#f5f6fa;border-color:#f0f1f6;color:#4e5a70}.form-control,.form-select{border-color:#e5e9f2;border-radius:10px;padding:.7rem .85rem}.form-control:focus,.form-select:focus{border-color:#aab3ff;box-shadow:0 0 0 .2rem #5367e81a}
        .table{--bs-table-bg:transparent;margin:0}.table thead th{font-size:.7rem;text-transform:uppercase;letter-spacing:.65px;color:#8992a6;background:#fafbfe;border-bottom:1px solid var(--line);padding:1rem .9rem;white-space:nowrap}.table tbody td{padding:1rem .9rem;border-color:#f0f2f7;vertical-align:middle}.table-hover tbody tr:hover>*{--bs-table-bg:#fbfcff}
        .item-icon{width:40px;height:40px;border-radius:12px;background:#f0f2ff;color:var(--brand);display:grid;place-items:center;font-size:1.1rem;flex-shrink:0}
        .badge-soft{background:#edf0ff;color:#4d5dd0;padding:.48rem .65rem;border-radius:8px;font-weight:700}.badge-stock{background:#e6f8ef;color:#218653}.badge-low{background:#fff1db;color:#a56708}.badge-empty{background:#ffebee;color:#c43b4a}
        .alert{border:0;border-radius:13px}.breadcrumb{font-size:.8rem}.breadcrumb-item a{color:#8a93a7;text-decoration:none}.empty-icon{width:66px;height:66px;display:grid;place-items:center;background:#f1f3ff;color:var(--brand);border-radius:20px;font-size:1.8rem;margin:0 auto 1rem}
        .footer-note{font-size:.78rem;color:#a0a8b8}.dropdown-menu{border:1px solid var(--line);border-radius:12px;box-shadow:0 12px 35px #26345b15;padding:.45rem}.dropdown-item{border-radius:8px;padding:.6rem .75rem}
        @media(max-width:991.98px){.sidebar{position:static;width:100%;min-height:auto;padding:.8rem 1rem;border-right:0;border-bottom:1px solid var(--line)}.sidebar .nav-caption,.sidebar .sidebar-footer{display:none}.sidebar-nav{display:flex;gap:.4rem}.side-link{margin:0;padding:.6rem .75rem}.main{margin-left:0}.topbar{height:65px;padding:0 1rem}.page-wrap{padding:1.4rem 1rem 2rem}}
        @media(max-width:575.98px){.sidebar .brand-name{font-size:1rem}.sidebar-nav{margin-top:.8rem}.side-link{font-size:.82rem;gap:.4rem}.page-wrap{padding:1.1rem .8rem 2rem}.table tbody td{padding:.8rem .65rem}.topbar{padding:0 .8rem}}
    </style>
    @stack('styles')
</head>
<body>
<aside class="sidebar">
    <a href="{{ route('products.index') }}" class="d-flex align-items-center gap-3 text-decoration-none text-dark px-2 mb-4">
        <span class="brand-mark"><i class="bi bi-box-seam-fill"></i></span>
        <span><span class="brand-name d-block">InvenTrack</span><span class="small subtle">Inventory workspace</span></span>
    </a>
    <div class="nav-caption">MENU UTAMA</div>
    <nav class="sidebar-nav">
        <a class="side-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}"><i class="bi bi-grid-1x2"></i> Ringkasan & Barang</a>
        <a class="side-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}"><i class="bi bi-collection"></i> Kategori</a>
    </nav>
    <div class="sidebar-footer position-absolute bottom-0 start-0 end-0 p-4">
        <div class="p-3 rounded-4" style="background:#f7f8ff">
            <div class="d-flex align-items-center gap-2 mb-2"><i class="bi bi-shield-check text-primary"></i><span class="fw-bold small">Data lebih teratur</span></div>
            <p class="small subtle mb-0">Kelola barang dan stok dalam satu tempat.</p>
        </div>
        <div class="footer-note mt-3 px-1">© {{ date('Y') }} InvenTrack</div>
    </div>
</aside>
<main class="main">
    <header class="topbar">
        <div class="d-flex align-items-center gap-2 text-secondary small"><i class="bi bi-house-door"></i><span>/</span><span class="text-dark fw-semibold">@yield('breadcrumb', 'Inventaris')</span></div>
        <div class="d-flex align-items-center gap-2"><span class="rounded-circle d-grid place-items-center text-primary fw-bold" style="width:38px;height:38px;background:#eef0ff">IT</span><div class="d-none d-sm-block"><div class="fw-bold small">Administrator</div><div class="subtle" style="font-size:.72rem">Pengelola inventaris</div></div></div>
    </header>
    <div class="page-wrap">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4" role="alert"><i class="bi bi-check-circle-fill fs-5"></i><div>{{ session('success') }}</div><button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Tutup"></button></div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button></div>
        @endif
        @yield('content')
        <div class="footer-note text-center mt-5">InvenTrack · Sistem Informasi Inventaris Barang</div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
