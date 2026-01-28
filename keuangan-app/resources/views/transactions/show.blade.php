@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
  <h1 class="h3 mb-4 text-gray-800">Detail Transaksi</h1>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Informasi Transaksi</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered">
          <tr>
            <th width="200">No</th>
            <td>{{ $transaction->id }}</td>
          </tr>
          <tr>
            <th>Tanggal</th>
            <td>{{ $transaction->tanggal }}</td>
            <!-- ambil data -->
          </tr>
          <tr>
            <th>Jumlah</th>
            <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
            <!--  nilai yang akan diformat, dan pengatur format penulisan rupiah  -->
          </tr>
          <tr>
            <th>Periode</th>
            <td>{{ $transaction->category->name ?? '-' }}</td>
          </tr>
          <tr>
            <th>Jenis</th>
            <td>{{ $transaction->subCategory->name ?? '-' }}</td>
          </tr>
          <tr>
            <th>Tipe</th>
            <td>{{ $transaction->type->name ?? '-' }}</td>
          </tr>
          <tr>
            <th>Deskripsi</th>
            <td>{{ $transaction->deskripsi }}</td>
          </tr>
        </table>
      </div>

      <div class="mt-3 d-flex justify-content-end gap-2">
        <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> Kembali
        </a>
        
      </div>
    </div>
  </div>
@endsection
