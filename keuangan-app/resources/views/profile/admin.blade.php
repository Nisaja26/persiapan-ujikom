@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid py-4">

    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="card-header text-white"
            style="background: linear-gradient(90deg, #007bff, #5fa0ff);">
            <h4 class="mb-0">
                <i class="fas fa-user-circle me-2"></i> Profil Admin
            </h4>
        </div>

        <div class="card-body bg-light">

            {{-- FOTO PROFIL --}}
            <div class="text-center mb-5">
                @if(auth()->user()->photo)
    <img src="{{ asset('storage/' . auth()->user()->photo) }}"
         alt="Foto Profil"
         class="rounded-circle shadow mb-3"
         width="120" height="120"
         style="object-fit: cover;">
@else
    <img src="{{ asset('sb-admin2/img/admin.png') }}"
         alt="Default Avatar"
         class="rounded-circle shadow mb-3"
         width="120" height="120"
         style="object-fit: cover;">
@endif
                <h5 class="fw-bold text-primary">{{ auth()->user()->name }}</h5>
                <p class="text-muted small mb-0">{{ auth()->user()->email }}</p>
                <hr class="mt-4 mb-5">
            </div>

            {{-- PROFILE INFORMATION --}}
            <div class="mb-5">
                <h6 class="fw-bold text-primary mb-3">
                    <i class="fas fa-id-badge me-2"></i>Informasi Akun
                </h6>
                <p class="text-muted small mb-3">Perbarui data profil Anda di bawah ini.</p>

                <form method="POST" action="{{ route('profile.update') }}"
                    class="bg-white p-4 rounded-4 shadow-sm">
                    @csrf
                    @method('PATCH')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" class="form-control border-0 bg-light shadow-sm"
                                name="name" value="{{ old('name', auth()->user()->name) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control border-0 bg-light shadow-sm"
                                name="email" value="{{ old('email', auth()->user()->email) }}">
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <hr>

            {{-- UPDATE PASSWORD --}}
            <div class="mb-5">
                <h6 class="fw-bold text-warning mb-3">
                    <i class="fas fa-lock me-2"></i> Ubah Password
                </h6>
                <p class="text-muted small mb-3">
                    Pastikan password baru Anda kuat dan unik untuk menjaga keamanan akun.
                </p>

                <form method="POST" action="{{ route('password.update') }}"
                    class="bg-white p-4 rounded-4 shadow-sm">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Password Saat Ini</label>
                            <input type="password" class="form-control border-0 bg-light shadow-sm"
                                name="current_password" autocomplete="current-password">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Password Baru</label>
                            <input type="password" class="form-control border-0 bg-light shadow-sm"
                                name="password" autocomplete="new-password">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Konfirmasi Password</label>
                            <input type="password" class="form-control border-0 bg-light shadow-sm"
                                name="password_confirmation" autocomplete="new-password">
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-warning text-white px-4">
                            <i class="fas fa-key me-1"></i> Update Password
                        </button>
                    </div>
                </form>
            </div>

            <hr>

            {{-- DELETE ACCOUNT --}}
            <div>
                <h6 class="fw-bold text-danger mb-3">
                    <i class="fas fa-user-times me-2"></i> Hapus Akun
                </h6>
                <p class="text-muted small mb-3">
                    Setelah akun dihapus, semua data akan hilang secara permanen. Tindakan ini tidak bisa dibatalkan.
                </p>

                <form method="POST" action="{{ route('profile.destroy') }}"
                    onsubmit="return confirm('Yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan!')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-outline-danger px-4">
                        <i class="fas fa-trash-alt me-1"></i> Hapus Akun
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
