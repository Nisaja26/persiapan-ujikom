@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <div
        class="section-header bg-primary text-white shadow-sm rounded p-3 d-flex justify-content-between align-items-center">
        <h3 class="mb-0">Daftar Users</h3>
    </div>

    <div class="section-body mt-4">
        @if (session('success'))
            <div class="alert alert-success shadow-sm">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger shadow-sm">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @if ($users->isEmpty())
            <div class="alert alert-info shadow-sm text-center">
                <i class="fas fa-info-circle"></i> Belum ada data user.
            </div>
        @else
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-gradient-primary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-users"></i> Tabel Users
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-hover align-middle text-center">
                        <thead class="bg-gradient-light">
                            <tr class="text-primary fw-bold">
                                <th style="width: 10%">No</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th style="width: 20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr>
                                    <td class="fw-semibold">{{ $index + 1 }}</td>

                                    <td class="fw-bold text-dark">
                                        {{ $user->username }}
                                    </td>

                                    <td>
                                        @php
                                            $roleId = $user->role_id;
                                        @endphp

                                        <!-- atur warna  -->
                                        @if ($roleId == 1)
                                            <span class="badge badge-primary text-uppercase">
                                                {{ $user->role->name }}
                                            </span>
                                        @elseif ($roleId == 2)
                                            <span class="badge badge-info text-uppercase">
                                                {{ $user->role->name }}
                                            </span>
                                        @else
                                            <span class="badge badge-secondary text-uppercase">
                                                {{ $user->role->name ?? '-' }}
                                            </span>
                                        @endif
                                    </td>


                                    <td>
                                        @if (auth()->id() !== $user->id)
                                            <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete({{ $user->id }})"
                                                    class="btn btn-danger btn-sm rounded-circle" data-bs-toggle="tooltip" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="badge badge-secondary">Akun Anda</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    {{-- Blade view --}}
    @push('scripts')

    {{-- Tooltip Bootstrap --}}
        <script>
            // cari semua elemet toolip
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            // aktifkan tolltip di semua element
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        </script>
    @endpush

@endsection