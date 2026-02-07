@extends('layouts.app')

@section('title', 'Roles')

@section('content')


<div class="section-body mt-4">

    {{-- Alert --}}
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

    {{-- Table Roles --}}
    @if ($roles->isEmpty())
        <div class="alert alert-info shadow-sm text-center">
            <i class="fas fa-info-circle"></i> Belum ada role.
        </div>
    @else
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header bg-gradient-primary text-white">
                <h6 class="mb-0">
                    <i class="fas fa-table"></i> Tabel Roles
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-hover align-middle text-center">
                    <thead class="bg-gradient-light">
                        <tr class="text-primary fw-bold">
                            <th style="width: 10%">No</th>
                            <th>Nama Role</th>
                            <th style="width: 20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $index => $role)
                            <tr>
                                <td class="fw-semibold">{{ $index + 1 }}</td>
                                <td class="fw-bold text-uppercase">{{ $role->name }}</td>
                                <td>
                                    <form id="delete-form-{{ $role->id }}"
                                          action="{{ route('roles.destroy', $role->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                onclick="confirmDelete({{ $role->id }})"
                                                class="btn btn-danger btn-sm rounded-circle"
                                                data-bs-toggle="tooltip"
                                                title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</br>
     {{-- Form Create Role --}}
    <div class="card shadow-sm border-0 rounded-3 mb-4">
        <div class="card-header bg-gradient-primary text-white">
            <h6 class="mb-0">
                <i class="fas fa-plus-circle"></i> Tambah Role
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('roles.store') }}" method="POST" class="form-inline">
                @csrf
                <div class="form-group mb-2 mr-2">
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Nama role (admin, ceo, user)"
                           value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button class="btn btn-primary mb-2">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    )
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
