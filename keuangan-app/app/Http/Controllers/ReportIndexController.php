<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Type;
use App\Models\Category;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportIndexController extends Controller
{
    public function generate(Request $request)
    {
        // Query dasar
        $query = Transaction::with(['type', 'category', 'subCategory']);

        // Filter berdasarkan bulan
        if ($request->filled('month')) {
            $query->whereMonth('tanggal', $request->month);
        }

        // Filter berdasarkan tahun
        if ($request->filled('year')) {
            $query->whereYear('tanggal', $request->year);
        }

        // Filter berdasarkan tipe
        if ($request->filled('type_id')) {
            $query->where('type_id', $request->type_id);
        }

        // Ambil data transaksi setelah difilter
        $transactions = $query->orderBy('tanggal', 'desc')->get();

        /**
         * =============================
         * 🔹 CEK JIKA DATA KOSONG
         * =============================
         */
        if ($transactions->isEmpty()) {
            return redirect()
                ->back()
                ->with('error', 'Tidak ada data transaksi yang cocok dengan filter yang dipilih.');
        }

        /**
         * =============================
         * 🔹 HITUNG TOTAL
         * =============================
         */
        $pemasukanId = Type::where('name', 'Pemasukan')->value('id');
        $pengeluaranId = Type::where('name', 'Pengeluaran')->value('id');

        $totalPemasukan = (clone $query)->where('type_id', $pemasukanId)->sum('amount');
        $totalPengeluaran = (clone $query)->where('type_id', $pengeluaranId)->sum('amount');
        $saldo = $totalPemasukan - $totalPengeluaran;

        /**
         * =============================
         * 🔹 DATA UNTUK VIEW PDF
         * =============================
         */
        $filters = [
            'month' => $request->month,
            'year' => $request->year,
            'type_id' => $request->type_id,
        ];

        $pdf = Pdf::loadView('transactions.Reports.Transactions', compact(
            'transactions',
            'totalPemasukan',
            'totalPengeluaran',
            'saldo',
            'filters'
        ))->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_Transaksi.pdf');
    }
}
