@extends('layouts/contentNavbarLayout')

@section('title', 'View All Agent')

@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Agent /</span> Inactive Agents
    </h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                  <h5 class="card-header">Deactive Agents on System</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>LGA</th>
                                <th>State</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->agent->agent_id }}</td>
                                    <td>{{ $user->agent->name }}</td>
                                    <td>{{ $user->agent->gender }}</td>
                                    <td>{{ $user->agent->lga }}</td>
                                    <td>{{ $user->agent->state }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $users->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
