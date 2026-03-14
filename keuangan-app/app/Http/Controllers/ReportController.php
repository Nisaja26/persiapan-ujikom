<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use PDF;

class ReportController extends Controller
{
    public function generate()
    {
        $transactions = Transaction::with(['category', 'subCategory', 'type'])->latest()->get();

        $pdf = PDF::loadView('reports.transactions', compact('transactions'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-transaksi.pdf');
    }
}
