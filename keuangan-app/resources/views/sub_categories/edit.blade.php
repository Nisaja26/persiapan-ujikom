@extends('layouts.app')

@section('title', 'Edit Jenis Transaksi')

@section('content')
<section class="section">
  <div class="section-header bg-primary text-white shadow-sm rounded p-3">
    <h3 class="mb-0"><i class="fas fa-edit"></i> Edit Jenis Transaksi</h3>
  </div>

  <div class="section-body mt-4">
    <div class="card border-0 shadow">
      <div class="card-body p-4">
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('sub-categories.update', $subCategory->id) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="form-group mb-4">
            <label for="name" class="font-weight-bold text-dark">Nama Jenis</label>
            <input type="text" name="name" id="name" 
                   value="{{ old('name', $subCategory->name) }}"
                   class="form-control form-control-lg border-primary" 
                   placeholder="Masukkan nama jenis transaksi" required>
          </div>

          <div class="form-group mb-4">
            <label for="category_id" class="font-weight-bold text-dark">Pilih Periode</label>
            <select name="category_id" id="category_id" class="form-control form-control-lg border-primary" required>
              <option value="">-- Pilih Periode --</option>
              @foreach($categories as $category)
                  <option value="{{ $category->id }}" {{ $subCategory->category_id == $category->id ? 'selected' : '' }}>
                      {{ $category->name }}
                  </option>
              @endforeach
            </select>
          </div>

          <div class="d-flex justify-content-end">
            <a href="{{ route('sub-categories.index') }}" class="btn btn-light border mr-2">
              <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-sync-alt"></i> Update
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
