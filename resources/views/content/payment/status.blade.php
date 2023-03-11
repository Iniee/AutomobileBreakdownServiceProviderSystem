@extends('layouts/blankLayout')

@section('title', 'Payment Status')

@section('content')
 <div class="col-md-6 col-lg-12 d-flex flex-column align-items-center">
<h6 class="mt-2 text-muted">Transaction Details</h6>
    <div class="card mb-4">
      <ul class="list-group list-group-flush">
        <li class="list-group-item">Client Name: {{ $result['data']['metadata']['name'] }}</li>
        <li class="list-group-item">Charged Amount: {{ $result['data']['metadata']['amount'] }}</li>
        <li class="list-group-item">Status: {{ $result['data']['status'] }}</li>
      </ul>
    </div>
 </div>

<!--/ Table within card -->
@endsection
