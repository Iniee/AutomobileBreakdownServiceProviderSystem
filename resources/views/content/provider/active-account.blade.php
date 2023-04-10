@extends('layouts/contentNavbarLayout')

@section('title', 'View Active Providers')
@section('search', '/active/providers/search')
@section('searchQuery', 'name or LGA')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Provider /</span> View Active Providers
    </h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Active Providers on System</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Business Address</th>
                                <th>Type</th>
                                <th>State</th>
                                <th>LGA</th>
                                <th>Verified By</th>
                                {{-- <th>Earnings</th> --}}
                                {{-- <th>Status</th> --}}
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->phone_number }}</td>
                                    <td>{{ $user->business_address }}</td>
                                    <td>{{ $user->type }}</td>
                                    <td>{{ $user->state }}</td>
                                    <td>{{ $user->lga }}</td>
                                    <td>
                                        @if ($user->verified_by_agent)
                                            {{ App\Models\Agent::find($user->verified_by_agent)->name }}
                                        @else
                                            Not Verified
                                        @endif
                                    </td>
                                    {{-- <td>{{ $user->providers->total_earnings }}</td> --}}
                                    {{-- <td>
                                        <span
                                            class="badge {{ $user->providers->status == 'Pending' ? 'bg-label-danger' : 'bg-label-primary' }} me-1">
                                            {{ $user->providers->status }}
                                        </span>
                                    </td> --}}
                                    {{-- <td>
                                      <div class="dropdown">
                                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                              data-bs-toggle="dropdown"><i
                                                  class="bx bx-dots-vertical-rounded"></i></button>
                                          <div class="dropdown-menu">
                                              <form action="{{ route('provider.status', $provider) }}" method="POST">
                                                  @csrf
                                                  @method('PUT')
                                                  <button class="dropdown-item" type="submit" name="status"
                                                      value="active"><i class="bx bx bx-lock-open"></i> Activate</button>
                                                  <button class="dropdown-item" type="submit" name="status"
                                                      value="pending"><i class="bx bx bx-lock"></i> Deactivate</button>
                                              </form>
                                          </div>
                                      </div>
                                  </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $providers->links('pagination::bootstrap-5') }}
                    </nav>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
