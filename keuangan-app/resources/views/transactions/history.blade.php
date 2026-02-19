@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Transaction History (Trash)</h3>

        <a href="{{ route('transactions.index') }}" class="btn btn-primary mb-3">
            Back to Transactions
        </a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Deleted At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->tanggal }}</td>
                        <td>{{ $transaction->type->name ?? '-' }}</td>
                        <td>{{ number_format($transaction->amount, 0, ',', '.') }}</td>
                        <td>{{ $transaction->deleted_at }}</td>
                        <td>
                            {{-- Restore --}}
                            <form action="{{ route('transactions.restore', $transaction->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-success btn-sm">
                                    Restore
                                </button>
                            </form>

                            {{-- Permanent Delete --}}
                            <form id="delete-form-{{ $transaction->id }}"
                                action="{{ route('transactions.forceDelete', $transaction->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')

                                <button type="button" onclick="confirmDelete({{ $transaction->id }})"
                                    class="btn btn-danger btn-sm">
                                    Delete Permanent
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            No deleted transactions.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $transactions->links() }}
    </div>
@endsection