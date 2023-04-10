@extends('layouts/contentNavbarLayout')

@section('title', 'View All Provider')
@section('search', '/provider/search')
@section('searchQuery', 'name or LGA')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Provider /</span> View All Providers
    </h4>
    @if (session()->has('message'))
      <div class="alert alert-primary">{{ session()->get('message') }}</div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Providers on System</h5>
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
                                <th>Earnings</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($providers as $provider)
                              <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $provider->name }}</td>
                                    <td>{{ $provider->phone_number }}</td>
                                    <td>{{ $provider->business_address }}</td>
                                    <td>{{ $provider->type }}</td>
                                    <td>{{ $provider->state }}</td>
                                    <td>{{ $provider->lga }}</td>
                                    <td>
                                        @if ($provider->verified_by_agent)
                                            {{ App\Models\Agent::find($provider->verified_by_agent)->name }}
                                        @else
                                            Not verified
                                        @endif
                                    </td>
                                    <td>{{ $provider->total_earnings }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $provider->user->status == 'Pending' ? 'bg-label-danger' : 'bg-label-primary' }} me-1">
                                            {{ $provider->status }}
                                        </span>
                                    </td>
                                    <td>
                                      <div class="dropdown">
                                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                              data-bs-toggle="dropdown"><i
                                                  class="bx bx-dots-vertical-rounded"></i></button>
                                          <div class="dropdown-menu">
                                              <form action="{{ route('provider.status', $provider) }}" method="POST">
                                                  @csrf
                                                  @method('PUT')
                                                  <button class="dropdown-item" type="submit" name="status"
                                                      value="Approved"><i class="bx bx bx-lock-open"></i> Activate</button>
                                                  <button class="dropdown-item" type="submit" name="status"
                                                      value="Pending"><i class="bx bx bx-lock"></i> Deactivate</button>
                                              </form>
                                          </div>
                                      </div>
                                    </td>
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
