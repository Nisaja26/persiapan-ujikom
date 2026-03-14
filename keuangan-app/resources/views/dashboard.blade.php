@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h2 fw-bold text-primary">
        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
    </h1>
</div>

<style>
.card:hover {
    transform: translateY(-3px);
    transition: all 0.25s ease-in-out;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

.form-select:focus {
    box-shadow: 0 0 6px rgba(0, 0, 0, 0.25) !important;
    outline: none;
    border-color: #fff;
}

.form-select option {
    color: #000;
}
</style>

<!-- FILTER TAHUN & BULAN -->
<div class="row mb-3">
    <div class="col-md-4">
        <form method="GET" action="{{ route('dashboard') }}">
            <div class="input-group" style="gap: 4px;">
                <select name="year" class="form-select form-select-sm fw-bold" onchange="this.form.submit()"
                    style="background: linear-gradient(135deg,#4361ee,#6e8bff); color:#fff; border-radius:8px; border:none; height:38px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                    @for($y = date('Y'); $y >= 2020; $y--)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>

                <select name="month" class="form-select form-select-sm fw-bold" onchange="this.form.submit()"
                    style="background: linear-gradient(135deg,#4361ee,#6e8bff); color:#fff; border-radius:8px; border:none; height:38px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                    <option value="">Semua Bulan</option>
                    @foreach(range(1,12) as $m)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                    </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</div>

<!-- SUMMARY CARDS -->
<div class="row">
    @php
    $cards = [
    ['title'=>'Pemasukan','value'=>$totalPemasukan,'icon'=>'fa-arrow-circle-down','bg'=>'linear-gradient(135deg,#4361ee,#6e8bff)'],
    ['title'=>'Pengeluaran','value'=>$totalPengeluaran,'icon'=>'fa-arrow-circle-up','bg'=>'linear-gradient(135deg,#ff6b6b,#ff8fab)'],
    ['title'=>'Total
    Transaksi','value'=>$totalTransaksi,'icon'=>'fa-clipboard-list','bg'=>'linear-gradient(135deg,#06d6a0,#7ef7d7)'],
    ['title'=>'Saldo','value'=>$saldoAkhir,'icon'=>'fa-wallet','bg'=>'linear-gradient(135deg,#ffb703,#ffd36b)'],
    ];
    @endphp

    @foreach($cards as $card)
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card shadow h-100 py-2" style="background: {{ $card['bg'] }}; border-radius:12px;">
            <div class="card-body text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs text-uppercase mb-1">{{ $card['title'] }}</div>
                        <div class="h5 mb-0 fw-bold">
                            {{ $card['title'] == 'Total Transaksi' ? $card['value'] : 'Rp '.number_format($card['value'],0,',','.') }}
                        </div>
                    </div>
                    <i class="fas {{ $card['icon'] }} fa-2x text-white-50"></i>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- DETAIL PERSENTASE -->
<div class="card mt-4 shadow-sm" style="max-height:400px;overflow-y:auto;border-radius:12px;">
    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center py-2 px-3">
        <h5 class="mb-0"><i class="fas fa-percentage"></i> Detail Persentase</h5>
        <span class="small">Tahun {{ $year }}
            {{ $month ? '- Bulan '.DateTime::createFromFormat('!m', $month)->format('F') : '' }}</span>
    </div>
    <div class="card-body p-2">
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-hover text-center align-middle mb-0">
                <thead class="bg-light text-primary">
                    <tr>
                        <th>Bulan</th>
                        <th>Pemasukan (%)</th>
                        <th>Pengeluaran (%)</th>
                        <th>Laba (%)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($detailPersentase as $row)
                    <tr>
                        <td><strong>{{ $row['bulan'] }}</strong></td>
                        <td>
                            <div class="progress" style="height:10px;">
                                <div class="progress-bar bg-success progress-bar-striped" role="progressbar"
                                    style="width: {{ $row['pemasukan_persen'] }}%;"></div>
                            </div>
                            <small class="text-muted">{{ $row['pemasukan_persen'] }}%</small>
                        </td>
                        <td>
                            <div class="progress" style="height:10px;">
                                <div class="progress-bar bg-danger progress-bar-striped" role="progressbar"
                                    style="width: {{ $row['pengeluaran_persen'] }}%;"></div>
                            </div>
                            <small class="text-muted">{{ $row['pengeluaran_persen'] }}%</small>
                        </td>
                        <td>
                            <div class="progress" style="height:10px;">
                                <div class="progress-bar {{ ($row['laba_persen'] ?? 0) >=0 ? 'bg-success':'bg-danger' }} progress-bar-striped"
                                    role="progressbar" style="width: {{ abs($row['laba_persen'] ?? 0) }}%;"></div>
                            </div>
                            <small
                                class="{{ ($row['laba_persen'] ?? 0) >=0 ? 'text-success':'text-danger' }}">{{ $row['laba_persen'] ?? 0 }}%</small>
                        </td>
                        <td>
                            @switch($row['status'])
                            @case('Naik')
                            <span class="badge bg-success"><i class="fas fa-arrow-up"></i> Naik</span>
                            @break
                            @case('Turun')
                            <span class="badge bg-danger"><i class="fas fa-arrow-down"></i> Turun</span>
                            @break
                            @case('Stabil')
                            <span class="badge" style="background-color:#e2e3e5; color:#495057;"><i
                                    class="fas fa-minus"></i> Stabil</span>
                            @break
                            @default
                            <span class="badge bg-info"><i class="fas fa-calendar"></i> Awal Periode</span>
                            @endswitch
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- GRAFIK -->
<div class="row mt-4">
    <div class="col-lg-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header bg-primary text-white"><strong>Ringkasan Transaksi</strong></div>
            <div class="card-body" style="height:250px;">
                <!-- lebih kecil -->
                <canvas id="transaksiChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header bg-success text-white"><strong>Perbandingan Pemasukan & Pengeluaran</strong></div>
            <div class="card-body" style="height:250px;">
                <!-- lebih kecil -->
                <canvas id="perbandinganChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    function validateData(data) {
        return (data || []).map(val => parseFloat(val) || 0);
    }

    // Ringkasan Transaksi
    const transaksiCanvas = document.getElementById('transaksiChart');
    if (transaksiCanvas) {
        const ctx = transaksiCanvas.getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Pemasukan', 'Pengeluaran', 'Saldo'],
                datasets: [{
                    label: 'Jumlah (Rp)',
                    data: [
                        @json($totalPemasukan ?? 0),
                        @json($totalPengeluaran ?? 0),
                        @json($saldoAkhir ?? 0)
                    ],
                    backgroundColor: ['#4e73df', '#e74a3b', '#f6c23e'],
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    }

    // Perbandingan Bulanan
    const perbandinganCanvas = document.getElementById('perbandinganChart');
    if (perbandinganCanvas) {
        const ctx = perbandinganCanvas.getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels ?? []),
                datasets: [{
                        label: 'Pemasukan',
                        data: validateData(@json($dataPemasukan ?? [])),
                        borderColor: '#1cc88a',
                        backgroundColor: 'rgba(28,200,138,0.2)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 4,
                        pointBackgroundColor: '#1cc88a'
                    },
                    {
                        label: 'Pengeluaran',
                        data: validateData(@json($dataPengeluaran ?? [])),
                        borderColor: '#e74a3b',
                        backgroundColor: 'rgba(231,74,59,0.2)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 4,
                        pointBackgroundColor: '#e74a3b'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': Rp ' + context.parsed.y
                                    .toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endpush