<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>@yield('title')</title>
  <link href="{{ asset('sb-admin2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('sb-admin2/css/sb-admin-2.min.css') }}" rel="stylesheet">
  


  <!-- icon css fontawesome -->
<link rel="icon" href="{{ asset('sb-admin2/img/favicon-new.png') }}" type="image/png">

</head>

<body id="page-top">
  <div id="wrapper">
    <!-- menyisipkan file sidebar -->
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        @include('layouts.topbar')
        <div class="container-fluid">
          <!-- menampilkan isi halaman yang menggunakkan layout ini -->
          @yield('content')
        </div>
      
  </div>

  <!-- notifikasi action sukses/error -->
  @if (session('success'))
    <meta name="flash-success" content="{{ session('success') }}">
  @endif

  @if (session('error'))
    <meta name="flash-error" content="{{ session('error') }}">
  @endif


  <!-- notifikasi delete konfirmasi -->
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

<!-- pesan data sukses di tambahkan -->
  <script>
  document.addEventListener('DOMContentLoaded', function () {
    let successMessage = document.querySelector('meta[name="flash-success"]')?.content;
    let errorMessage   = document.querySelector('meta[name="flash-error"]')?.content;

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






  <!-- notifikasi pake npm run dev -->
  @vite('resources/js/app.js')
  @stack('scripts')
  <script src="{{ asset('sb-admin2/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('sb-admin2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('sb-admin2/js/sb-admin-2.min.js') }}"></script>





  <!-- grafik berdasarkan kategori yang ada button di halaman transaksi-->
  <!-- @stack('scripts') -->



</body>

</html>