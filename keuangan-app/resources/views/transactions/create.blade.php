@extends('layouts.app')

@section('title', 'Input Transaksi')

@section('content')
  <div class="section">
    <div class="section-header">
    </div>

    <div class="section-body">
      <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white">
          <h4 class="mb-0 h4 font-weight-bold">
            <i class="fas fa-plus-circle mr-2"></i> Add Transaksi
          </h4>
        </div>

        <div class="card-body p-4">
          <form action="{{ route('transactions.store') }}" method="POST">
            @csrf

            <div class="form-row">
              <!-- Tipe Transaksi -->
              <div class="form-group col-md-6">
                <label><i class="fas fa-random mr-1 text-primary"></i> Tipe Transaksi</label>
                <select name="type_id" class="form-control shadow-sm @error('type_id') is-invalid @enderror" required>
                  <option value="">-- Pilih Tipe --</option>
                  @foreach($types as $type)
                    <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>
                      {{ $type->name }}
                    </option>
                  @endforeach
                </select>
                @error('type_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Periode -->
              <div class="form-group col-md-6">
                <label><i class="fas fa-calendar-alt mr-1 text-info"></i> Periode</label>
                <select name="category_id" id="category_id"
                  class="form-control shadow-sm @error('category_id') is-invalid @enderror" required>
                  <option value="">-- Pilih Periode Transaksi --</option>
                  @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                      {{ $category->name }}
                    </option>
                  @endforeach
                </select>
                @error('category_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="form-row">
              <!-- Jenis Biaya -->
              <div class="form-group col-md-6">
                <label><i class="fas fa-list-ul mr-1 text-warning"></i> Jenis Transaksi</label>
                <select name="sub_category_id" id="sub_category_id"
                  class="form-control shadow-sm @error('sub_category_id') is-invalid @enderror">
                  <option value="">-- Pilih Jenis Transaksi --</option>
                </select>
                @error('sub_category_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Nominal -->
              <div class="form-group col-md-6">
                <label><i class="fas fa-money-bill-wave mr-1 text-success"></i> Nominal</label>
                <input type="number" name="amount" class="form-control shadow-sm @error('amount') is-invalid @enderror"
                  placeholder="Masukkan jumlah" value="{{ old('amount') }}" required>
                @error('amount')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <!-- Tanggal -->
            <div class="form-row">
              <div class="form-group col-md-12">
                <label><i class="fas fa-calendar-day mr-1 text-danger"></i> Tanggal</label>
                <div class="input-group">
                  <input type="date" name="tanggal" id="tanggal"
                    class="form-control shadow-sm @error('tanggal') is-invalid @enderror"
                    value="{{ old('tanggal', isset($trx) ? $trx->tanggal->format('Y-m-d') : '') }}" required>
                  <div class="input-group-append">
                    <button type="button" id="todayBtn" class="btn btn-outline-primary shadow-sm">
                      <i class="fas fa-clock mr-1"></i> Hari Ini
                    </button>
                  </div>
                  @error('tanggal')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>


            <!-- Deskripsi -->
            <div class="form-row">
              <div class="form-group col-md-12">
                <label><i class="fas fa-pencil-alt mr-1 text-secondary"></i> Deskripsi</label>
                <textarea name="deskripsi" class="form-control shadow-sm @error('deskripsi') is-invalid @enderror"
                  rows="3" placeholder="Tuliskan keterangan...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
              <a href="{{ route('transactions.index') }}" class="btn btn-light border mr-2">
                <i class="fas fa-times mr-1"></i> Batal
              </a>
              <button type="submit" class="btn btn-primary shadow-sm">
                <i class="fas fa-save mr-1"></i> Simpan
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    /**
     * ===============================
     *  Tombol "Hari Ini" → Isi otomatis tanggal hari ini
     * ===============================
     */
    document.getElementById('todayBtn').addEventListener('click', function () {
      const today = new Date(); // Ambil tanggal hari ini dari sistem
      const formatted = today.toISOString().split('T')[0]; // Format ke YYYY-MM-DD
      document.getElementById('tanggal').value = formatted; // Set nilai input tanggal
    });

    /**
     * ===============================
     *  Dropdown Dinamis: Kategori → Sub Kategori
     *  Ketika kategori dipilih, sistem akan memuat daftar sub kategori
     *  melalui request ke endpoint: /get-subcategories/{categoryId}
     * ===============================
     */
    document.getElementById('category_id').addEventListener('change', function () {
      let categoryId = this.value; // Ambil ID kategori yang dipilih
      let subCategorySelect = document.getElementById('sub_category_id'); // Elemen dropdown sub kategori

      // Tampilkan pesan loading sementara
      subCategorySelect.innerHTML = '<option value="">Memuat data...</option>';

      // Jika kategori dipilih (tidak kosong)
      if (categoryId) {
        // Ambil data sub kategori dari server (Laravel route)
        fetch(`/get-subcategories/${categoryId}`)
          .then(response => response.json()) // Ubah response ke JSON
          .then(data => {
            // Reset isi dropdown dengan opsi awal
            subCategorySelect.innerHTML = '<option value="">-- Pilih Jenis Transaksi --</option>';

            // Loop setiap sub kategori dari response
            data.forEach(sub => {
              let option = document.createElement('option');
              option.value = sub.id;     // ID sub kategori
              option.textContent = sub.name; // Nama sub kategori
              subCategorySelect.appendChild(option); // Tambahkan ke dropdown
            });
          })
          .catch(() => {
            // Jika error saat fetch (misalnya koneksi gagal)
            subCategorySelect.innerHTML = '<option value="">Gagal memuat data</option>';
          });

      } else {
        // Jika kategori dihapus atau belum dipilih
        subCategorySelect.innerHTML = '<option value="">-- Pilih Jenis Transaksi --</option>';
      }
    });
  </script>
@endpush