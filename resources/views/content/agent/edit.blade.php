@extends('layouts/contentNavbarLayout')

@section('title', ' Vertical Layouts - Forms')

@section('content')

    <!-- Basic Layout -->
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Basic Layout</h5> <small class="text-muted float-end">Default label</small>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('agent.edit', $agent) }}" autocomplete="off">
                        @csrf
                        @method('patch')
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="status" id="pending" checked
                                autocomplete="off" />
                            <label class="btn btn-outline-primary" for="pending">Deactivate</label>
                            <input type="radio" class="btn-check" name="status" id="active" autocomplete="off" />
                            <label class="btn btn-outline-primary" for="active">Activate</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection
