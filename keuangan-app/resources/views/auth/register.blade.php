@extends('layouts.app')

@section('title', 'Register User')

@section('content')
<div class="container py-5 d-flex justify-content-center">

    <div class="card shadow-lg rounded-4 p-4" style="max-width:450px; width:100%;">
        <div class="text-center mb-3">
            <i class="fas fa-user-plus fa-2x text-primary mb-2"></i>
            <h4 class="fw-bold text-primary">Tambah Akun Baru</h4>
        </div>

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
                <div class="input-group">
                    <input type="password" id="password"
                           name="password" class="form-control" required>

                    <button type="button" class="btn btn-outline-secondary"
                            onclick="togglePassword('password', this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Konfirmasi -->
            <div class="mb-3 text-start">
                <label class="form-label">Konfirmasi Password</label>
                <div class="input-group">
                    <input type="password"
                           name="password_confirmation"
                           class="form-control" required>
                </div>
            </div>

            <!-- Role -->
            <div class="mb-4 text-start">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin">Admin</option>
                    <option value="ceo">CEO</option>
                </select>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                    Simpan Akun
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
