    @extends('layouts/contentNavbarLayout')

    @section('title', 'Inactive Client')

    @section('search', '/inactive/clients/search')
    @section('searchQuery', 'name or phone number')


    @section('content')
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Client /</span> Inactive Clients
        </h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <h5 class="card-header">Inctive Clients on System</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Phone Number</th>
                                    <th>Home Address</th>
                                    <th>State</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ optional($user->client)->name }}</td>
                                        <td>{{ optional($user->client)->gender }}</td>
                                        <td>{{ optional($user->client)->phone_number }}</td>
                                        <td>{{ optional($user->client)->home_address }}</td>
                                        <td>{{ optional($user->client)->state }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">
                            {{ $users->links('pagination::bootstrap-5') }}
                        </nav>
                    </div> --}}
                </div>
            </div>
        </div>
    @endsection
