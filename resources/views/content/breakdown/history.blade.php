@extends('layouts/contentNavbarLayout')

@section('title', 'Breakdown')

@section('search', '/breakdown/history/search')
@section('searchQuery', 'Location')


@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Request /</span> Breakdown
    </h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Client Name</th>
                                <th>Breakdown Location</th>
                                <th>Destination Location</th>
                                <th>Service Provider</th>
                                <th>Provider Type</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($breakdowns as $breakdown)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if ($breakdown->client_id)
                                            {{ App\Models\Client::find($breakdown->client_id)->name }}
                                        @endif
                                    </td>
                                    <td>{{ $breakdown->breakdown_location }}</td>
                                    <td>
                                        @if ($breakdown->destination_location)
                                            {{ $breakdown->destination_location }}
                                        @else
                                            null
                                        @endif
                                    </td>
                                    <td>
                                        @foreach ($breakdown->requests as $request)
                                            @if ($request->provider_id)
                                                {{ App\Models\Provider::find($request->provider_id)->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($breakdown->requests as $request)
                                            @if ($request->provider_id)
                                                {{ App\Models\Provider::find($request->provider_id)->type }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $breakdown->updated_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <div class="card-footer py-4">
                    <nav class="d-flex justify-content-end" aria-label="...">
                        {{ $transactions->links('pagination::bootstrap-5') }}
                    </nav>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
