<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Transaksi</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
    h2 { text-align: center; margin-bottom: 5px; }
    p { text-align: center; margin-top: 0; font-size: 11px; color: #555; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 6px; text-align: center; }
    th { background-color: #f4f4f4; font-weight: bold; }
    .text-success { color: green; font-weight: bold; }
    .text-danger { color: red; font-weight: bold; }
  </style>
</head>
<body>
  <h2>Laporan Transaksi</h2>
  
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Tipe</th>
        <th>Periode</th>
        <th>Jenis</th>
        <th>Nominal</th>
        <th>Tanggal</th>
        <th>Deskripsi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($transactions as $i => $trx)
      <tr>
        <td>{{ $i + 1 }}</td>
        <td>{{ $trx->type->name ?? '-' }}</td>
        <td>{{ $trx->category->name ?? '-' }}</td>
        <td>{{ $trx->subCategory->name ?? '-' }}</td>
        <td class="{{ $trx->type->name == 'Pemasukan' ? 'text-success' : 'text-danger' }}">
          Rp {{ number_format($trx->amount, 0, ',', '.') }}
        </td>
        <td>{{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}</td>
        <td>{{ $trx->deskripsi ?? '-' }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="7">Tidak ada data transaksi sesuai filter.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</body>
</html>
