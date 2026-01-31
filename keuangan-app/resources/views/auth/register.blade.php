<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>

    <!-- boptsrap -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <!--icon -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">


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

        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(51, 153, 255, 0.15);
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

        .register-card {
            background: #fff;
            border-radius: 20px;
            padding: 40px 35px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 450px;
            text-align: center;
            position: relative;
            z-index: 1;
            animation: fadeUp 0.8s ease-in-out;
        }

        .register-icon {
            background: #e6f2ff;
            color: #3399ff;
            font-size: 40px;
            border-radius: 50%;
            padding: 15px;
            margin-bottom: 15px;
        }

        .register-title {
            font-size: 1.6rem;
            font-weight: 600;
            margin-bottom: 25px;
            color: #3399ff;
        }

        .form-label {
            font-weight: 500;
            color: #333;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            padding: 10px 15px;
            border: 1px solid #ccdff5;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #3399ff;
            box-shadow: 0 0 6px rgba(51, 153, 255, 0.3);
        }

        .btn-register {
            background: #3399ff;
            border: none;
            border-radius: 12px;
            padding: 10px;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-register:hover {
            background: #228be6;
        }

        /* definisi animasi css */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            /* kondisi akhir */
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <!-- Dekorasi -->
    <div class="circle circle1"></div>
    <div class="circle circle2"></div>

    <div class="register-card">
        <div class="register-icon">
            <i class="fas fa-user-plus"></i>
        </div>
        <h3 class="register-title">Tambah Akun Baru</h3>

        <form method="POST" action="{{ route('admin.register.store') }}">
            @csrf

            <!-- Username -->
            <div class="mb-3 text-start">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
                @error('username')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3 text-start">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-3 text-start">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <!-- Role -->
            <div class="mb-4 text-start">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin">Admin</option>
                    <option value="ceo">CEO</option>
                </select>
                @error('role')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Tombol -->
            <div class="d-grid">
                <button type="submit" class="btn btn-register text-white">
                    Simpan Akun
                </button>
            </div>
        </form>
    </div>

    <!-- js dropdown dll -->
    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>