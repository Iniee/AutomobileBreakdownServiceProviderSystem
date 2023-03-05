@extends('layouts/contentNavbarLayout')

@section('title', 'Service Charges')

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
          <th>Client Name</th>
          <th>S-Provider Name</th>
          <th>Type</th>
          <th>Amount</th>
          <th>Transaction ID</th>
          <th>Status</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        <tr>
          <td>Teniola Cole</td>
          <td>Meko 1</td>
          <td>Artisan</td>
          <td>12,000</td>
          <td>1456789</td>
          <td><span class="badge bg-label-success me-1">Successful</span></td>
          <td>2023-03-03 00:08:32</td>
          

        </tr>
        <tr>
          <td>Barry Hunter</td>
          <td>Meko 2</td>
          <td>Cab Driver</td>
          <td>12,000</td>
          <td>1456789</td>
          <td><span class="badge bg-label-success me-1">Successful</span></td>
          <td>2023-03-03 00:08:32</td>

        </tr>
        <tr>
          <td>Trevor Baker</td>
          <td>Meko 3</td>
          <td>Tow Trucker</td>
          <td>12,000</td>
          <td>1456789</td>
          <td><span class="badge bg-label-danger me-1">Failed</span></td>
          <td>2023-02-17 12:08:32</td>

        </tr>
        <tr>
          <td>Jerry Milton</td>
          <td>Meko 4</td>
          <td>Artisan</td>
          <td>12,000</td>
          <td>1456789</td>
          <td><span class="badge bg-label-success me-1">Successful</span></td>
          <td>2023-03-03 00:08:32</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
  </div>
</div>
@endsection
