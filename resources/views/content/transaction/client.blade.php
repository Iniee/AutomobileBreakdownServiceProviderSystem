@extends('layouts/contentNavbarLayout')

@section('title', 'Client Transaction')

@section('search', '/transaction/search')
@section('searchQuery', 'name or trx_id')


@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Transactions /</span> Clients Transaction
    </h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Client Name</th>
                                <th>Amount</th>
                                <th>Transaction ID</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->id }}</td>
                                    <td>{{ $transaction->client_name }}</td>
                                    <td>{{ $transaction->charged_amount }}</td>
                                    <td>{{ $transaction->transaction_id }}</td>
                                    <td><span
                                            class="badge {{ $transaction->paymentstatus == 'failed' ? 'bg-label-danger' : 'bg-label-primary' }} me-1">{{ $transaction->paymentstatus }}</span>
                                    </td>
                                    <td>{{ $transaction->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $transactions->links('pagination::bootstrap-5') }}
                    </nav>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
