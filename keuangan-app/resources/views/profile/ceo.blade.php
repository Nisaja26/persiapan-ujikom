@extends('layouts.app')

@section('title', 'Profil CEO')

@section('content')
<div class="container-fluid py-4">

    <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
        {{-- HEADER --}}
        <div class="card-header border-0 text-white"
            style="background: linear-gradient(90deg, #4e73df, #224abe);">
            <h4 class="mb-0">
                <i class="fas fa-user-tie me-2"></i> Profil CEO
            </h4>
        </div>

        <div class="card-body px-5 py-4 bg-light">

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
                <h4 class="fw-bold text-primary">{{ auth()->user()->name }}</h4>
                <p class="text-muted small">{{ auth()->user()->email }}</p>
            </div>

            {{-- STATISTIK CEO --}}
            <div class="row text-center mb-5">
                <div class="col-md-4 mb-3">
                    <div class="p-4 rounded-4 shadow-sm bg-white border-start border-4 border-primary">
                        <h5 class="text-primary mb-1">Rp 125 jt</h5>
                        <p class="text-muted mb-0 small">Total Pendapatan</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="p-4 rounded-4 shadow-sm bg-white border-start border-4 border-success">
                        <h5 class="text-success mb-1">18</h5>
                        <p class="text-muted mb-0 small">Jumlah Proyek</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="p-4 rounded-4 shadow-sm bg-white border-start border-4 border-info">
                        <h5 class="text-info mb-1">6</h5>
                        <p class="text-muted mb-0 small">Tim Aktif</p>
                    </div>
                </div>
            </div>

            {{-- FORM UPDATE PROFIL --}}
            <div class="bg-white rounded-4 p-4 shadow-sm mb-5 border-start border-4 border-primary">
                <h6 class="text-primary fw-bold mb-3">
                    <i class="fas fa-id-card me-2"></i> Informasi Pribadi
                </h6>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Nama Lengkap</label>
                            <input type="text" class="form-control" name="name"
                                value="{{ old('name', auth()->user()->name) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">Email</label>
                            <input type="email" class="form-control" name="email"
                                value="{{ old('email', auth()->user()->email) }}">
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary px-4 fw-semibold">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- FORM UPDATE PASSWORD --}}
            <div class="bg-white rounded-4 p-4 shadow-sm mb-5 border-start border-4 border-warning">
                <h6 class="text-warning fw-bold mb-3">
                    <i class="fas fa-lock me-2"></i> Ubah Password
                </h6>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label text-muted">Password Lama</label>
                            <input type="password" class="form-control" name="current_password">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted">Password Baru</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted">Konfirmasi Password</label>
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-warning text-white px-4 fw-semibold">
                            <i class="fas fa-key me-1"></i> Update Password
                        </button>
                    </div>
                </form>
            </div>

            {{-- DELETE ACCOUNT --}}
            <div class="bg-white rounded-4 p-4 shadow-sm border-start border-4 border-danger">
                <h6 class="text-danger fw-bold mb-3">
                    <i class="fas fa-user-times me-2"></i> Hapus Akun
                </h6>
                <p class="text-muted small mb-3">
                    Menghapus akun CEO akan menghapus seluruh data yang terkait secara permanen.
                </p>

                <form method="POST" action="{{ route('profile.destroy') }}"
                    onsubmit="return confirm('Yakin ingin menghapus akun CEO ini?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-outline-danger px-4 fw-semibold">
                        <i class="fas fa-trash-alt me-1"></i> Hapus Akun
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
