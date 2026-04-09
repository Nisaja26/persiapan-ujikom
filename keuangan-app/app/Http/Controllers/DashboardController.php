<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Type;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Filter Tahun & Bulan
        $year = $request->get('year', date('Y'));
        $month = $request->get('month'); // Bisa null (seluruh bulan)

        // Ambil ID tipe Pemasukan & Pengeluaran (validasi null)
        $pemasukanId = Type::where('name', 'Pemasukan')->value('id');
        $pengeluaranId = Type::where('name', 'Pengeluaran')->value('id');

        if (!$pemasukanId || !$pengeluaranId) {
            // Jika type tidak ditemukan, set default 0 untuk semua
            $totalPemasukan = 0;
            $totalPengeluaran = 0;
            $dataPemasukan = array_fill(0, 12, 0);
            $dataPengeluaran = array_fill(0, 12, 0);
            $detailPersentase = [];
        } else {
            // =========================
            // 🔹 Hitung Data Bulanan Sekali (Optimasi: Reuse untuk summary, grafik, dan detail)
            // =========================
            $monthlyIncome = Transaction::where('type_id', $pemasukanId)
                ->whereYear('tanggal', $year)
                ->selectRaw('MONTH(tanggal) as bulan, SUM(amount) as total')
                ->groupBy('bulan')
                ->pluck('total', 'bulan')
                ->toArray();

            $monthlyExpense = Transaction::where('type_id', $pengeluaranId)
                ->whereYear('tanggal', $year)
                ->selectRaw('MONTH(tanggal) as bulan, SUM(amount) as total')
                ->groupBy('bulan')
                ->pluck('total', 'bulan')
                ->toArray();

            // Isi array 12 bulan dengan 0 jika tidak ada data
            $dataPemasukan = [];
            $dataPengeluaran = [];
            for ($m = 1; $m <= 12; $m++) {
                $dataPemasukan[] = (float) ($monthlyIncome[$m] ?? 0);
                $dataPengeluaran[] = (float) ($monthlyExpense[$m] ?? 0);
            }

            // =========================
            // 🔹 Summary Cards (Filter bulan jika dipilih)
            // =========================
            $totalPemasukanQuery = Transaction::where('type_id', $pemasukanId)
                ->whereYear('tanggal', $year);
            $totalPengeluaranQuery = Transaction::where('type_id', $pengeluaranId)
                ->whereYear('tanggal', $year);

            if ($month) {
                $totalPemasukanQuery->whereMonth('tanggal', $month);
                $totalPengeluaranQuery->whereMonth('tanggal', $month);
            }

            $totalPemasukan = (float) $totalPemasukanQuery->sum('amount');
            $totalPengeluaran = (float) $totalPengeluaranQuery->sum('amount');
            $totalTransaksi = Transaction::whereYear('tanggal', $year)
                ->when($month, fn($q) => $q->whereMonth('tanggal', $month))
                ->count();
            $saldoAkhir = $totalPemasukan - $totalPengeluaran;

            // =========================
            // 🔹 Detail Persentase per Bulan (hanya bulan terpilih jika ada)
            // =========================
            $detailPersentase = [];
            $prevLaba = 0; // Track laba bulan sebelumnya
            $startMonth = $month ? $month : 1;
            $endMonth = $month ? $month : 12;
            $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

            for ($m = $startMonth; $m <= $endMonth; $m++) {
                $bulanNama = $labels[$m - 1];

                $income = (float) ($monthlyIncome[$m] ?? 0);
                $expense = (float) ($monthlyExpense[$m] ?? 0);

                $laba = $income - $expense;
                $total = $income + $expense;
                $incomePercent = $total > 0 ? round(($income / $total) * 100, 1) : 0;
                $expensePercent = $total > 0 ? round(($expense / $total) * 100, 1) : 0;
                $labaPercent = $total > 0 ? round(($laba / $total) * 100, 1) : 0;

                // Logika status: bandingkan laba bulan ini dengan bulan sebelumnya
                $status = 'Stabil'; // Default
                if ($m == $startMonth && !$month) {
                    // Bulan pertama full tahun: tidak ada perbandingan
                    $status = 'Awal Periode';
                } elseif ($month) {
                    // Hanya satu bulan: bandingkan dengan bulan sebelumnya (cross-year jika perlu)
                    $prevMonth = $m - 1;
                    $prevYear = $year;
                    if ($prevMonth == 0) {
                        $prevMonth = 12;
                        $prevYear = $year - 1;
                    }

                    // Hitung prevLaba (query terpisah karena cross-year)
                    $prevIncomeQuery = Transaction::where('type_id', $pemasukanId)
                        ->whereYear('tanggal', $prevYear)
                        ->whereMonth('tanggal', $prevMonth)
                        ->sum('amount');
                    $prevExpenseQuery = Transaction::where('type_id', $pengeluaranId)
                        ->whereYear('tanggal', $prevYear)
                        ->whereMonth('tanggal', $prevMonth)
                        ->sum('amount');

                    $prevLaba = (float) $prevIncomeQuery - (float) $prevExpenseQuery;

                    if ($laba > $prevLaba) {
                        $status = 'Naik';
                    } elseif ($laba < $prevLaba) {
                        $status = 'Turun';
                    } else {
                        $status = 'Stabil';
                    }
                } else {
                    // Full tahun: bandingkan dengan prevLaba (sequential bulan sebelumnya)
                    if ($laba > $prevLaba) {
                        $status = 'Naik';
                    } elseif ($laba < $prevLaba) {
                        $status = 'Turun';
                    } else {
                        $status = 'Stabil';
                    }
                }

                $detailPersentase[] = [
                    'bulan' => $bulanNama,
                    'pemasukan' => $income,
                    'pengeluaran' => $expense,
                    'laba' => $laba,
                    'pemasukan_persen' => $incomePercent,
                    'pengeluaran_persen' => $expensePercent,
                    'laba_persen' => $labaPercent,
                    'status' => $status,
                ];

                // Update prevLaba untuk iterasi berikutnya (penting untuk sequential full tahun)
                $prevLaba = $laba;
            }
        }

        return view('dashboard', compact(
            'totalPemasukan',
            'totalPengeluaran',
            'totalTransaksi',
            'saldoAkhir',
            'labels',
            'dataPemasukan',
            'dataPengeluaran',
            'detailPersentase',
            'year',
            'month'
        ));
    }
}