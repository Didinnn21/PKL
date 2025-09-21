<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Menu Utama</div>
            <a class="nav-link" href="{{ route('member.dashboard') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>

            <a class="nav-link" href="{{ route('member.products.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-tshirt"></i></div>
                Produk
            </a>
            <div class="sb-sidenav-menu-heading">Lainnya</div>
            <a class="nav-link" href="{{ route('landing.index') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                Kembali ke Landing Page
            </a>
        </div>
    </div>
    <div class="sb-sidenav-footer">
        <div class="small">Logged in as:</div>
        {{ Auth::user()->name }}
    </div>
</nav>
