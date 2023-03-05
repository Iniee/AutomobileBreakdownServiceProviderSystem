@extends('layouts/contentNavbarLayout')

@section('title', 'View All Provider')

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Provider /</span> View All Providers
</h4>

<div class="row">
  <div class="col-md-12">
  <div class="card">
  <div class="table-responsive text-nowrap">
    <table class="table table-sm">
      <thead>
        <tr>
          <th>Name</th>
          <th>Gender</th>
          <th>Status</th>
          <th>LGA</th>
          <th>Verified by Agent</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        <tr>
          <td>Albert Cook</td>
          <td>Male</td>
          <td><span class="badge bg-label-primary me-1">Active</span></td>
          <td>Kosofe</td>
          <td>Agent 1</td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                {{-- <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx bx-lock"></i> Deactivate</a> --}}
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td>Barry Hunter</td>
          <td>Male</td>
          <td><span class="badge bg-label-warning me-1">Pending</span></td>
          <td>Bariga</td>
          <td>Agent 2</td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                {{-- <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx bx-lock"></i> Deactivate</a> --}}
              </div>
            </div>
          </td>
        </tr>
        <td>Albert Cook</td>
          <td>Male</td>
          <td><span class="badge bg-label-primary me-1">Active</span></td>
          <td>Kosofe</td>
          <td>Agent 3</td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                {{-- <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx bx-lock"></i> Deactivate</a> --}}
              </div>
            </div>
          </td>
        </tr>
        <tr>
        <tr>
          <td>Trevor Baker</td>
          <td>Female</td>
          <td><span class="badge bg-label-primary me-1">Active</span></td>
          <td>Ikeja</td>
          <td>Agent 4</td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Deactivate</a>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td>Jerry Milton</td>
          <td>Female</td>
          <td><span class="badge bg-label-warning me-1">Pending</span></td>
          <td>Somolu</td>
          <td>Agent 5</td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                {{-- <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx bx-lock"></i> Deactivate</a> --}}
              </div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
  </div>
</div>
@endsection
