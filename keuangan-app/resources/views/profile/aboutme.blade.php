@extends('layouts.app')

@section('title', 'Profil CEO')

@section('content')
    <div class="container-fluid py-4">

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

            {{-- HEADER --}}
            <div class="card-header border-0 text-white" style="background: linear-gradient(90deg, #4e73df, #224abe);">
                <h4 class="mb-0">
                    <i class="fas fa-user-tie me-2"></i> Aboutme
                </h4>
            </div>

            <div class="card-body px-5 py-4 bg-light">

                {{-- FOTO PROFIL --}}
                <div class="text-center mb-5">
                    @if(auth()->user()->photo)
                        <img src="{{ asset('storage/' . auth()->user()->photo) }}" class="rounded-circle shadow mb-3"
                            width="120" height="120" style="object-fit: cover;">
                    @else
                        <img src="{{ asset('sb-admin2/img/admin.png') }}" class="rounded-circle shadow mb-3" width="120"
                            height="120" style="object-fit: cover;">
                    @endif

                    <h5 class="fw-bold text-primary">
                        {{ auth()->user()->username }}
                    </h5>

                    <p class="text-muted small mb-0 text-uppercase">
                        {{ auth()->user()->role->name ?? 'CEO' }}
                    </p>

                    <hr class="mt-4 mb-5">
                </div>

                {{-- UPDATE PROFIL --}}
                <div class="mb-5">
                    <h6 class="fw-bold text-primary mb-3">
                        <i class="fas fa-id-badge me-2"></i> Informasi Akun
                    </h6>

                    <form method="POST" action="{{ route('profile.update') }}" class="bg-white p-4 rounded-4 shadow-sm">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Username</label>
                            <input type="text" class="form-control border-0 bg-light shadow-sm" name="username"
                                value="{{ old('username', auth()->user()->username) }}">
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

    <form method="POST" action="{{ route('password.update') }}"
          class="bg-white p-4 rounded-4 shadow-sm">
        @csrf
        @method('PUT')

        <div class="row g-3">

            {{-- Password Saat Ini --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold">Password Saat Ini</label>
                <div class="input-group">
                    <input type="password"
                           id="current_password"
                           name="current_password"
                           class="form-control border-0 bg-light shadow-sm">
                </div>
            </div>

            {{-- Password Baru --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold">Password Baru</label>
                <div class="input-group">
                    <input type="password"
                           id="new_password"
                           name="password"
                           class="form-control border-0 bg-light shadow-sm">

                    <button class="btn btn-outline-secondary"
                            type="button"
                            onclick="togglePassword('new_password', this)">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            {{-- Konfirmasi Password --}}
            <div class="col-md-4">
                <label class="form-label fw-semibold">Konfirmasi Password</label>
                <div class="input-group">
                    <input type="password"
                           id="confirm_password"
                           name="password_confirmation"
                           class="form-control border-0 bg-light shadow-sm">
                </div>
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
                <form id="delete-form-{{ auth()->id() }}" action="{{ route('profile.destroy') }}" method="POST"
                    class="d-inline">
                    @csrf
                    @method('DELETE')

                    <button type="button" onclick="confirmDelete('{{ auth()->id() }}')" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-1"></i>
                        Hapus Akun
                    </button>

                </form>

            </div>
        </div>
    </div>
@endsection