@extends('layouts/contentNavbarLayout')

@section('title', 'View All Provider')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Provider /</span> View All Providers
    </h4>

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
                                <th>State</th>
                                <th>LGA</th>
                                <th>Verified By</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($providers as $provider)
                                <tr>
                                    <td>{{ $provider->sp_id }}</td>
                                    <td>{{ $provider->name }}</td>
                                    <td>{{ $provider->phone_number }}</td>
                                    <td>{{ $provider->business_address }}</td>
                                    <td>{{ $provider->state }}</td>
                                    <td>{{ $provider->lga }}</td>
                                    <td>{{ $provider->verified_by_agent ?? 'null' }}</td>
                                    <td><span
                                            class="badge {{ $provider->user->status == 'pending' ? 'bg-label-danger' : 'bg-label-primary' }} me-1">{{ $provider->user->status }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $providers->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
