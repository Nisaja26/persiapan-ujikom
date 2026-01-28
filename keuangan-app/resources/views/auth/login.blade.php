<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Icon -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background: #f5faff;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: "Poppins", sans-serif;
      position: relative;
      overflow: hidden;
    }

    /* Dekorasi lingkaran */
    .circle {
      position: absolute;
      border-radius: 50%;
      background: rgba(51,153,255,0.15); /* biru muda transparan */
      z-index: 0;
    }
    .circle1 {
      width: 350px;
      height: 350px;
      top: -120px;
      left: -120px;
    }
    .circle2 {
      width: 300px;
      height: 300px;
      bottom: -100px;
      right: -100px;
    }

    .login-card {
      background: #fff;
      border-radius: 20px;
      padding: 40px 35px;
      box-shadow: 0px 8px 20px rgba(0,0,0,0.08);
      width: 100%;
      max-width: 420px;
      text-align: center;
      position: relative;
      z-index: 1;
      animation: fadeUp 0.8s ease-in-out;
    }

    .login-icon {
      background: #e6f2ff;
      color: #3399ff;
      font-size: 40px;
      border-radius: 50%;
      padding: 15px;
      margin-bottom: 15px;
    }

    .login-title {
      font-size: 1.6rem;
      font-weight: 600;
      margin-bottom: 25px;
      color: #3399ff;
    }

    .form-label {
      font-weight: 500;
      color: #333;
      text-align: left;
      display: block;
    }

    .form-control {
      border-radius: 12px;
      padding: 10px 15px;
      border: 1px solid #ccdff5;
    }

    .form-control:focus {
      border-color: #3399ff;
      box-shadow: 0 0 6px rgba(51,153,255,0.3);
    }

    .btn-login {
      background: #3399ff;
      border: none;
      border-radius: 12px;
      padding: 10px;
      font-weight: 500;
      transition: 0.3s;
    }

    .btn-login:hover {
      background: #228be6;
    }

    /* Animasi muncul */
    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(40px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>

  <!-- Dekorasi lingkaran -->
  <div class="circle circle1"></div>
  <div class="circle circle2"></div>

  <div class="login-card">
    <div class="login-icon">
      <i class="fas fa-user"></i>
    </div>
    <h3 class="login-title">Selamat Datang</h3>
    <form method="POST" action="{{ route('login') }}">
      @csrf

      <!-- Username -->
      <div class="mb-3 text-start">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required autofocus>
        @error('username')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <!-- Password -->
      <div class="mb-3 text-start">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
        @error('password')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      <!-- Tombol -->
      <div class="d-grid">
        <button type="submit" class="btn btn-login text-white">Masuk</button>
      </div>
    </form>
  </div>

</body>
</html>
