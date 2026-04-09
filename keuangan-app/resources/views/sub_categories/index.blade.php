@extends('layouts.app')

@section('title', 'Daftar Jenis Transaksi')

@section('content')
<section class="section">
    <div class="section-header bg-primary text-white shadow-sm rounded p-3 d-flex justify-content-between align-items-center">
        <h3 class="mb-0"></i> Daftar Jenis Transaksi</h3>
        <a href="{{ route('sub-categories.create') }}" class="btn btn-light text-primary border">
            <i class="fas fa-plus-circle"></i> Tambah Jenis
        </a>
    </div>

    <div class="section-body mt-4">
        @if (session('success'))
            <div class="alert alert-success shadow-sm">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if ($subCategories->isEmpty())
            <div class="alert alert-info shadow-sm text-center">
                <i class="fas fa-info-circle"></i> Belum ada data jenis transaksi.
            </div>
        @else
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-gradient-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-table"></i> Tabel Jenis Transaksi</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead class="bg-gradient-light">
                                <tr class="text-primary fw-bold">
                                    <th style="width: 5%">No</th>
                                    <th>Nama Jenis</th>
                                    <th>Periode</th>
                                    <th style="width: 20%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subCategories as $index => $subCategory)
                                    <tr>
                                        <td class="fw-semibold">{{ $index + 1 }}</td>
                                        <td class="fw-bold text-dark">{{ $subCategory->name }}</td>
                                        <td>{{ $subCategory->category->name ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('sub-categories.edit', $subCategory->id) }}"
                                               class="btn btn-warning btn-sm rounded-circle"
                                               data-bs-toggle="tooltip" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form id="delete-form-{{ $subCategory->id }}"
                                                  action="{{ route('sub-categories.destroy', $subCategory->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete({{ $subCategory->id }})"
                                                        class="btn btn-danger btn-sm rounded-circle"
                                                        data-bs-toggle="tooltip" title="Hapus">
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
            </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
@endsection
