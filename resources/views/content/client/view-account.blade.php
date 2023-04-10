@extends('layouts/contentNavbarLayout')

@section('title', 'View All Client')
@section('search', '/client/search')
@section('searchQuery', 'Name or Phone number')


@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Client /</span> View All Clients
    </h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Clients on System</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Phone Number</th>
                                <th>Home Address</th>
                                <th>State</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($clients as $client)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->gender }}</td>
                                    <td>{{ $client->phone_number }}</td>
                                    <td>{{ $client->home_address }}</td>
                                    <td>{{ $client->state }}</td>
                                     <td><span
                                            class="badge {{ $client->user->status == 'pending' ? 'bg-label-danger' : 'bg-label-primary' }} me-1">{{ $client->user->status }}</span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown"><i
                                                    class="bx bx-dots-vertical-rounded"></i></button>
                                            <div class="dropdown-menu">
                                                <form action="{{ route('client.status', $client) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="dropdown-item" type="submit" name="status"
                                                        value="active"><i class="bx bx bx-lock-open"></i> Activate</button>
                                                    <button class="dropdown-item" type="submit" name="status"
                                                        value="pending"><i class="bx bx bx-lock"></i> Deactivate</button>
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
                        {{ $clients->links('pagination::bootstrap-5') }}
                    </nav>
                </div> --}}
            </div>
        </div>
    </div>
@endsection

