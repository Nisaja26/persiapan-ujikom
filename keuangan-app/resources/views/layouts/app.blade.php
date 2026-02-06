<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>@yield('title')</title>

  <link href="{{ asset('sb-admin2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('sb-admin2/css/sb-admin-2.min.css') }}" rel="stylesheet">

  <!-- CSS Button Back -->
  <style>
    .back-btn-fixed {
      position: fixed;
      bottom: 16px;
      left: 16px;
      z-index: 1050;

      display: flex;
      align-items: center;
      gap: 6px;

      border-radius: 50px;
      padding: 8px 14px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, .15);
    }

    @media (max-width: 576px) {
      .back-btn-fixed {
        padding: 10px;
        border-radius: 50%;
      }

      .back-text {
        display: none;
      }
    }
  </style>

  @stack('styles')

  <link rel="icon" href="{{ asset('sb-admin2/img/favicon-new.png') }}" type="image/png">
</head>


<body id="page-top">
  <div id="wrapper">

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">

        <!-- Topbar -->
        @include('layouts.topbar')

        <div class="container-fluid">

          {{-- ISI HALAMAN --}}
          @yield('content')

          {{-- 🔙 TOMBOL BACK GLOBAL --}}
          @if (!request()->routeIs('dashboard', 'login', ) && url()->previous() && url()->previous() !== url()->current())
            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm back-btn-fixed"> <i
          class="fas fa-arrow-left me-1"></i> <span class="back-text">Kembali</span> </a> @endif

        </div>
      </div>
    </div>

  </div>

  {{-- FLASH MESSAGE --}}
  @if (session('success'))
    <meta name="flash-success" content="{{ session('success') }}">
  @endif

  @if (session('error'))
    <meta name="flash-error" content="{{ session('error') }}">
  @endif

  {{-- SWEETALERT2 --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  {{-- CONFIRM DELETE --}}
  <script>
    function confirmDelete(id) {
      Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data yang dihapus tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('delete-form-' + id).submit();
        }
      });
    }
  </script>

  {{-- FLASH NOTIFICATION --}}
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      let successMessage = document.querySelector('meta[name="flash-success"]')?.content;
      let errorMessage = document.querySelector('meta[name="flash-error"]')?.content;

      if (successMessage) {
        Swal.fire({
          icon: 'success',
          title: 'Berhasil',
          text: successMessage,
          showConfirmButton: false,
          timer: 2000
        });
      }

      if (errorMessage) {
        Swal.fire({
          icon: 'error',
          title: 'Gagal',
          text: errorMessage,
          showConfirmButton: false,
          timer: 2000
        });
      }
    });
  </script>

  {{-- Button eye password --}}
  <script>
    function togglePassword(fieldId, btn) {
      const input = document.getElementById(fieldId);
      const icon = btn.querySelector('i');

      if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    }
  </script>


  {{-- ASSET --}}
  @vite('resources/js/app.js')
  @stack('scripts')

  <script src="{{ asset('sb-admin2/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('sb-admin2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('sb-admin2/js/sb-admin-2.min.js') }}"></script>

</body>

</html>