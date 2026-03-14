<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Home</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/construction/favicon-new2.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('assets/img/construction/favicon-new2.png') }}">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Ubuntu:wght@400;500;700&display=swap"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- Tambahan CSS Animasi -->
  <style>
    /* Efek muncul dari bawah */
    @keyframes fadeSlideUp {
      0% {
        opacity: 0;
        transform: translateY(30px);
      }
      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Efek kilau untuk teks judul */
    @keyframes textShine {
      0% {
        background-position: -200%;
      }
      100% {
        background-position: 200%;
      }
    }

    h1 {
      font-family: 'Ubuntu', sans-serif;
      font-weight: 700;
      background: linear-gradient(90deg, #165DAA, #4aa8ff, #165DAA);
      background-size: 200%;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      animation: textShine 3s linear infinite, fadeSlideUp 1.2s ease forwards;
    }

    p {
      font-family: 'Roboto', sans-serif;
      font-size: 1.1rem;
      color: #333;
      opacity: 0;
      animation: fadeSlideUp 1.5s ease forwards;
      animation-delay: 0.5s;
    }

    .btn-primary {
      display: inline-block;
      padding: 10px 20px;
      background-color: #165DAA;
      color: white;
      border-radius: 5px;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #0f4b8f;
      transform: translateY(-3px);
    }
  </style>
</head>

<body class="index-page">

  <header id="header" class="header sticky-top">
    <div class="branding d-flex align-items-center">
      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
          <h1 class="sitename">FinancialApp</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>
            <li><a href="dashboard">Dashboard</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
      </div>
    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="hero-content" data-aos="fade-right" data-aos-delay="200">
              <h1>Financial App</h1>
              <p>
                Aplikasi ini membantu perusahaan mencatat, mengelola,
                dan memantau keuangan dengan mudah — dari pemasukan,
                pengeluaran, hingga laporan keuangan yang informatif.
              </p>

              <div class="hero-buttons">
                <a href="login" class="btn-primary">Login</a>
              </div>
            </div>
          </div>

          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
            <img src="assets/img/construction/favicon-new2.png" alt="Financial App Logo" class="img-fluid">
          </div>
        </div>
      </div>
    </section><!-- /Hero Section -->

    <footer id="footer" class="footer dark-background"></footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>
