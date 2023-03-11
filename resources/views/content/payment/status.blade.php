@extends('layouts/blankLayout')

@section('title', 'Payment Status')

@section('content')
<h5 class="mb-9">Transaction Details</h5>
<div class="table-responsive text-nowrap">
    <table class="table card-table">
        <thead>
            <tr>
                <th>Client Name</th>
                <th>Amount</th>
                <th>Status</th>

            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            <tr>
                <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $result['data']['metadata']['name'] }}</strong></td>
                <td>{{ $result['data']['metadata']['amount'] }}</td>
                <td>{{ $result['data']['status'] }}</td>
            </tr>
            <tr>
        </tbody>
    </table>
</div>
<!--/ Table within card -->
@endsection
