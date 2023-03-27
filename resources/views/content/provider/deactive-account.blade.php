@extends('layouts/contentNavbarLayout')

@section('title', 'View Inactive Providers')
@section('search', '/inactive/providers/search')
@section('searchQuery', 'name or LGA')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Provider /</span> View Inactive Providers
    </h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Inactve Providers On System</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
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
                                    <td>{{ $user->providers->name }}</td>
                                    <td>{{ $user->providers->phone_number }}</td>
                                    <td>{{ $user->providers->business_address }}</td>
                                    <td>{{ $user->providers->type }}</td>
                                    <td>{{ $user->providers->state }}</td>
                                    <td>{{ $user->providers->lga }}</td>
                                    <td>
                                        @if ($user->providers->verified_by_agent)
                                            {{ App\Models\Agent::find($user->providers->verified_by_agent)->name }}
                                        @else
                                            null
                                        @endif
                                    </td>
                                    {{-- <td>{{ $user->providers->total_earnings }}</td> --}}
                                    {{-- <td>
                                        <span
                                            class="badge {{ $providers->status == 'Pending' ? 'bg-label-danger' : 'bg-label-primary' }} me-1">
                                            {{ $user->provider->status }}
                                        </span>
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
