@extends('layouts/contentNavbarLayout')

@section('title', 'Service Charges')

@section('search', '/service/search')
@section('searchQuery', 'name/cost')


@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Transactions /</span> Service Charges
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
                                <th>Cost</th>
                                <th>Provider Name</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{  App\Models\Client::find($transaction->client_id)->name }} </td>
                                    <td>{{ $transaction->cost }}</td>
                                    <td>{{ App\Models\Provider::find($transaction->provider_id)->name }}</td>
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
