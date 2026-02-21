@extends('layouts.app')

@section('title', 'History Transaksi')

@section('content')
    <div class="section">
        <div class="section-body">

            {{-- Alert --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm rounded" role="alert">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            @endif

            <div class="card shadow border-0">

                {{-- Header --}}
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 font-weight-bold">
                        <i class="fas fa-trash mr-2"></i> History Transaksi (Trash)
                    </h4>

                    <a href="{{ route('transactions.index') }}" class="btn btn-light btn-sm shadow-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Lihat Transaksi
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-striped table-borderless align-middle text-center mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>User</th>
                                <th>Tanggal</th>
                                <th>Tipe</th>
                                <th>Nominal</th>
                                <th>Dihapus Pada</th>
                                @if(auth()->user()->isAdmin())
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($transactions as $index => $transaction)
                                @php
                                    $typeName = optional($transaction->type)->name;
                                    $isIncome = $typeName === 'Pemasukan';
                                  @endphp

                                <tr>
                                    <td>{{ $transactions->firstItem() + $index }}</td>

                                    <td>
                                        <span class="badge badge-info px-2 py-1">
                                            <i class="fas fa-user mr-1"></i>
                                            {{ optional($transaction->user)->username ?? 'Unknown' }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($transaction->tanggal)->format('d M Y') }}
                                    </td>

                                    {{-- Badge Type --}}
                                    <td>
                                        <span
                                            class="badge 
                                        {{ $isIncome ? 'badge-success' : ($typeName === 'Pengeluaran' ? 'badge-danger' : 'badge-secondary') }}">

                                            @if($isIncome)
                                                <i class="fas fa-arrow-down mr-1"></i>
                                            @elseif($typeName === 'Pengeluaran')
                                                <i class="fas fa-arrow-up mr-1"></i>
                                            @endif

                                            {{ $typeName ?? '-' }}
                                        </span>
                                    </td>

                                    {{-- Nominal --}}
                                    <td class="{{ $isIncome ? 'text-success' : 'text-danger' }} font-weight-bold">
                                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($transaction->deleted_at)->format('d M Y H:i') }}
                                    </td>

                                    @if(auth()->user()->isAdmin())
                                        <td>
                                            {{-- Restore --}}
                                            <form action="{{ route('transactions.restore', $transaction->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn btn-success btn-sm rounded-circle" data-toggle="tooltip"
                                                    title="Restore">
                                                    <i class="fas fa-undo"></i>
                                                </button>
                                            </form>

                                            {{-- Permanent Delete --}}
                                            <form id="delete-form-{{ $transaction->id }}"
                                                action="{{ route('transactions.forceDelete', $transaction->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button" onclick="confirmDelete({{ $transaction->id }})"
                                                    class="btn btn-danger btn-sm rounded-circle" title="Delete Permanent">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    @endif

                                </tr>

                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->isAdmin() ? 6 : 5 }}" class="text-center text-muted py-4">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        No deleted transactions.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-4 mb-2">
                    {{ $transactions->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection