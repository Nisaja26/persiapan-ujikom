@extends('layouts.app')

@section('title', 'Tambah Tipe')

@section('content')
<section class="section">
  <div class="section-header bg-primary text-white shadow-sm rounded p-3">
    <h3 class="mb-0"><i class="fas fa-plus-circle"></i> Tambah Tipe</h3>
  </div>

  <div class="section-body mt-4">
    <div class="card border-0 shadow">
      <div class="card-body p-4">
        <form action="{{ route('types.store') }}" method="POST">
          @csrf

          <div class="form-group mb-4">
            <label for="name" class="font-weight-bold text-dark">Nama Tipe</label>
            <input type="text" name="name" id="name" 
                   class="form-control form-control-lg border-primary" 
                   placeholder="Masukkan nama tipe" required>
            <small class="form-text text-muted">Contoh: Pemasukan, Pengeluaran</small>
          </div>

          <div class="d-flex justify-content-end">
            <a href="{{ route('types.index') }}" class="btn btn-light border mr-2">
              <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
