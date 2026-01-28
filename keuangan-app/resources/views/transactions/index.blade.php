@extends('layouts.app')

@section('title', 'Data Transaksi')

@section('content')
  <div class="section">

    <div class="section-body">
      {{-- Alert --}}
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded" role="alert">
          <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif

      <div class="card shadow border-0">
        <div
          class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center rounded-top">
          <h4 class="mb-0 h4 font-weight-bold">
            <i class="fas fa-list mr-2"></i> Daftar Transaksi
          </h4>



          {{-- Filter bulan, tahun, dan jenis transaksi --}}
          <form method="GET" action="{{ route('transactions.index') }}" class="form-inline" id="filterForm">

            {{-- Filter bulan --}}
            <select name="month" class="form-control form-control-sm mr-2 shadow-sm">
              <option value="">Semua Bulan</option>
              @foreach(range(1, 12) as $m)
                <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                  {{ \Carbon\Carbon::createFromDate(null, $m, 1)->translatedFormat('F') }}
                </option>
              @endforeach
            </select>

            {{-- Filter tahun --}}
            <select name="year" class="form-control form-control-sm mr-2 shadow-sm">
              <option value="">Semua Tahun</option>
              @foreach($years as $y)
                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
              @endforeach
            </select>

            {{-- 🔹 Filter jenis transaksi --}}
            <select name="type_id" class="form-control form-control-sm mr-2 shadow-sm">
              <option value="">Semua Tipe</option>
              @foreach(\App\Models\Type::all() as $type)
                <option value="{{ $type->id }}" {{ request('type_id') == $type->id ? 'selected' : '' }}>
                  {{ $type->name }}
                </option>
              @endforeach
            </select>

            {{-- Tombol filter --}}
            <button class="btn btn-light btn-sm border mr-2 shadow-sm" type="submit">
              <i class="fas fa-filter mr-1 text-primary"></i> Filter
            </button>

            {{-- Tombol reset --}}
            <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-secondary shadow-sm mr-2">
              <i class="fas fa-undo mr-1"></i> Reset
            </a>

            {{-- Tombol Generate Report (PDF) --}}
            <a href="#" id="generateReportBtn" class="btn btn-sm btn-primary shadow-sm">
              <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
            </a>

          </form>

        </div>

        <div class="card-body">
          {{-- Info filter --}}
          @if(request()->filled('month') || request()->filled('year'))
            @php
              // Hitung saldo berdasarkan data transaksi yang sudah difilter
              $saldo = $transactions->sum(function ($t) {
                // Jika type name adalah "Pengeluaran", ubah nilai jadi negatif
                return $t->type->name === 'Pengeluaran'
                  ? -$t->amount
                  : $t->amount;
              });
            @endphp
            <!-- tulisan -->
            <p class="small text-muted mb-3">
              <i class="fas fa-info-circle mr-1"></i>
              Total Saldo :
              <strong class="{{ $saldo >= 0 ? 'text-success' : 'text-danger' }}">
                Rp {{ number_format($saldo, 0, ',', '.') }}
              </strong>
            </p>
          @endif
        </div>



        <div class="table-responsive">
          <table class="table table-hover table-striped table-borderless align-middle text-center">
            <thead class="thead-light">
              <tr>
                <th>No</th>
                <th>Tipe</th>
                <th>Periode</th>
                <th>Jenis</th>
                <th>Nominal</th>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                @if($role === 'admin')
                  <th>Action</th>
                @endif
              </tr>
            </thead>
            <tbody>
              @forelse($transactions as $index => $trx)
                <tr>
                  <!-- nomor berurutan di pagnation, jika next halaman no data tetap berurutan tidak kembali 1 -->
                  <td>{{ $transactions->firstItem() + $index }}</td>
                  <td>
                    <!-- jika type namenya pemasukan  -->
                    @if($trx->type->name == 'Pemasukan')
                    <!-- maka warna text hijau -->
                      <span class="badge badge-success px-2 py-1">
                        <!-- dengan icon panah ke bawah -->
                        <i class="fas fa-arrow-down mr-1"></i> {{ $trx->type->name }}
                      </span>
                      <!-- jika type name pengeluaran -->
                    @elseif($trx->type->name == 'Pengeluaran')
                    <!-- maka warna text merah -->
                      <span class="badge badge-danger px-2 py-1">
                        <!-- ikon tanda panah ke atas -->
                        <i class="fas fa-arrow-up mr-1"></i> {{ $trx->type->name }}
                      </span>
                    @else
                    <!-- selain itu maka tulisan warna abu-abu tanpa ikon -->
                      <span class="badge badge-secondary px-2 py-1">
                        <!-- karena type tidak di kenal/null -->
                        {{ $trx->type->name ?? '-' }}
                      </span>
                    @endif
                  </td>
                  <!-- jika category kosong, maka akan tampil - -->
                  <td>{{ $trx->category->name ?? '-' }}</td>
                  <td>{{ $trx->subCategory->name ?? '-' }}</td>
                  <!-- jika type name pemasukan maka text hijau selain itu text merah -->
                  <td class="{{ $trx->type->name == 'Pemasukan' ? 'text-success' : 'text-danger' }} font-weight-bold">
                    <!-- membuat format angka menjadi tampilan ribuan -->
                    Rp {{ number_format($trx->amount, 0, ',', '.') }}
                  </td>
                  <!-- mengubah string tanggal  -->
                  <td>{{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}</td>
                  <td>{{ $trx->deskripsi ?? '-' }}</td>

                  @if($role === 'admin')
                    <td>
                      <a href="{{ route('transactions.edit', $trx->id) }}" class="btn btn-warning btn-sm rounded-circle"
                        data-bs-toggle="tooltip" title="Edit">
                        <i class="fas fa-edit"></i>
                      </a>

                      <form id="delete-form-{{ $trx->id }}" action="{{ route('transactions.destroy', $trx->id) }}"
                        method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete({{ $trx->id }})"
                          class="btn btn-danger btn-sm rounded-circle" data-bs-toggle="tooltip" title="Hapus">
                          <i class="fas fa-trash"></i>
                        </button>
                      </form>
                    </td>

                  @endif
                </tr>
              @empty
                <tr>
                  <td colspan="{{ $role === 'admin' ? 8 : 7 }}" class="text-center text-muted py-4">
                    <i class="fas fa-info-circle mr-1"></i> Data transaksi belum ada
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>

          <div class="d-flex justify-content-center mt-4 mb-2">
            {{ $transactions->links() }}
          </div>

        </div>
      </div>
    </div>
  </div>
  </div>
@endsection

@push('scripts')
  <script>
    // Saat tombol "Generate Report" diklik
    document.getElementById('generateReportBtn').addEventListener('click', function (e) {
      e.preventDefault();

      // Ambil form filter
      const form = document.getElementById('filterForm');
      if (!form) {
        alert('Form filter tidak ditemukan di halaman.');
        return;
      }

      // Buat query string dari input form
      const params = new URLSearchParams(new FormData(form)).toString();

      // Buka halaman generate report di tab baru dengan filter yang sama
      window.open(`{{ route('report.index.generate') }}?${params}`, '_blank');
    });
  </script>
@endpush