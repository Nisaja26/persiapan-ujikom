<!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar"
        style="background: linear-gradient(180deg,#1e3c72,#2a5298,#3f86c2,#6dd5ed);">

      <!-- Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon">
          <i class="fas fa-wallet"></i>
        </div>
        <div class="sidebar-brand-text mx-3 font-weight-bold">Finance</div>
      </a>

      <hr class="sidebar-divider my-0">

      <!-- Dashboard -->
      <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/dashboard') }}">
          <i class="fas fa-fw fa-tachometer-alt text-info"></i>
          <span class="menu-text">Dashboard</span>
        </a>
      </li>

      <hr class="sidebar-divider">

      {{-- ================= ADMIN MENU ================= --}}
      @if(auth()->user()->role === 'admin' || auth()->user()->role == 1)
        <div class="sidebar-heading text-light">Transaksi</div>
        <li class="nav-item {{ request()->is('transactions*') ? 'active' : '' }}">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTransactionsAdmin"
            aria-expanded="true" aria-controls="collapseTransactionsAdmin">
            <i class="fas fa-exchange-alt text-warning"></i>
            <span class="menu-text">Kelola Transaksi</span>
          </a>
          <div id="collapseTransactionsAdmin"
               class="collapse {{ request()->is('transactions*') ? 'show' : '' }}"
               data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item {{ request()->is('transactions/create') ? 'active' : '' }}"
                 href="{{ route('transactions.create') }}">
                 <i class="fas fa-plus-circle mr-2 text-primary"></i> Tambah Transaksi
              </a>
              <a class="collapse-item {{ request()->is('transactions') ? 'active' : '' }}"
                 href="{{ route('transactions.index') }}">
                 <i class="fas fa-list-ul mr-2 text-success"></i> Daftar Transaksi
              </a>
            </div>
          </div>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading text-light">Master Data</div>
        <li class="nav-item {{ request()->is('types*','categories*','sub-categories*') ? 'active' : '' }}">
          <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMaster"
             aria-expanded="false" aria-controls="collapseMaster">
              <i class="fas fa-database text-success"></i>
              <span class="menu-text">Data Referensi</span>
          </a>
          <div id="collapseMaster"
               class="collapse {{ request()->is('types*','categories*','sub-categories*') ? 'show' : '' }}"
               data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
              <a class="collapse-item {{ request()->is('types*') ? 'active' : '' }}" href="{{ url('/types') }}">
                <i class="fas fa-random mr-1 text-primary"></i> Tipe Transaksi
              </a>
              <a class="collapse-item {{ request()->is('categories*') ? 'active' : '' }}" href="{{ url('/categories') }}">
                <i class="fas fa-calendar-alt mr-1 text-info"></i> Periode Transaksi
              </a>
              <a class="collapse-item {{ request()->is('sub-categories*') ? 'active' : '' }}" href="{{ url('/sub-categories') }}">
                <i class="fas fa-list-ul mr-1 text-warning"></i> Jenis Transaksi
              </a>
            </div>
          </div>
        </li>
        <hr class="sidebar-divider">
      @endif

      {{-- ================= CEO MENU ================= --}}
      @if(auth()->user()->role === 'ceo' || auth()->user()->role == 2)
        <div class="sidebar-heading text-light">Transaksi</div>
        <li class="nav-item {{ request()->is('transactions') ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('transactions.index') }}">
            <i class="fas fa-exchange-alt text-success"></i>
            <span class="menu-text">Daftar Transaksi</span>
          </a>
        </li>
        <hr class="sidebar-divider">
      @endif

      <div class="sidebar-heading text-light">Menu Utama</div>

<li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
  <a class="nav-link" href="{{ url('/') }}">
    <i class="fas fa-fw fa-home text-light"></i>
    <span class="menu-text">Home</span>
  </a>
</li>

<!-- Logout -->
<li class="nav-item">
  <a class="nav-link" href="#"
     onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class="fas fa-sign-out-alt text-light"></i>
    <span class="menu-text">Logout</span>
  </a>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
  </form>
</li>

<hr class="sidebar-divider d-none d-md-block">
</ul>
<!-- End of Sidebar -->

      <hr class="sidebar-divider d-none d-md-block">
    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column w-100">
