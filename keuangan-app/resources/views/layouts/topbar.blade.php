<!-- layouts/topbar.blade.php -->
<nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow"
  style="background: linear-gradient(90deg, #ced7f2ff 0%, #a6c2dfff 65%, #619dd2ff 100%);">

  <!-- Tombol Menu (Garis Tiga) di kiri -->
  <button id="sidebarToggle" class="btn btn-link rounded-circle mr-3">
    <i class="fas fa-bars"></i>
  </button>

  <!-- Spacer -->
  <div class="ml-auto"></div>

  <!-- Bagian kanan (Notifikasi + User Info) -->
  <ul class="navbar-nav align-items-center">

    @php
        $notifications = Auth::user()->unreadNotifications;
        $user = Auth::user();
    @endphp

    <!-- Notifikasi -->
    <li class="nav-item dropdown no-arrow mx-1">
      <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell fa-fw text-primary"></i>
        @if($notifications->count() > 0)
            <span class="badge badge-danger badge-counter">{{ $notifications->count() }}</span>
        @endif
      </a>

      <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--fade-in"
        aria-labelledby="alertsDropdown">
        <h6 class="dropdown-header bg-primary text-white">Notifikasi</h6>

        @forelse($notifications as $notif)
          <a class="dropdown-item d-flex align-items-center" 
             href="{{ $notif->data['url'] }}?notif_id={{ $notif->id }}">
            <div class="mr-3">
              <div class="icon-circle bg-primary">
                <i class="fas fa-file-alt text-white"></i>
              </div>
            </div>
            <div>
              <span class="small text-gray-500">{{ $notif->created_at->diffForHumans() }}</span>
              {{ $notif->data['message'] }}
            </div>
          </a>
        @empty
          <span class="dropdown-item small text-gray-500">Belum ada notifikasi</span>
        @endforelse
      </div>
    </li>

    <div class="topbar-divider d-none d-sm-block"></div>

    <!-- User Info -->
<li class="nav-item dropdown no-arrow">
  <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-toggle="dropdown"
    aria-haspopup="true" aria-expanded="false">

    <!-- Nama User (dipindah ke kiri) -->
    <span class="mr-2 d-none d-lg-inline text-black-500 small">
      {{ $user->role ? ($user->role === 'ceo' ? 'CEO' : ucfirst($user->role)) : $user->name }}
    </span>

    <!-- Foto Profil -->
    <img class="img-profile rounded-circle ml-2" 
         src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('./sb-admin2/img/admin.png') }}" 
         style="width: 35px; height: 35px; object-fit: cover;">
  </a>

      <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="{{ url('profile') }}">
          <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
          Profil
        </a>
      </div>
    </li>
  </ul>
</nav>
