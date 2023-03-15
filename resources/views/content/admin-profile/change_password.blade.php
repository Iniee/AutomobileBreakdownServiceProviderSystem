@extends('layouts/contentNavbarLayout')

@section('title', 'Your Profile')

@section('content')


    <div class="card mb-4">
        <h5 class="card-header">ADMIN CHANGE PASSWORD</h5>
        <!-- Account -->
        <div class="card-body">
            <form class="mb-3" action="{{ route('admin.changePassword') }}" method="POST">
                @csrf
        </div>
        <hr class="my-0">
        <div class="card-body">

            <div class="row">
                <div class="mb-3 col-md-6 ">
                    <label class="form-label" for="password">Current Password</label>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                            name="current_password"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        {{-- <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span> --}}
                    </div>
                </div>
                <div class="mb-3 col-md-6 form-password-toggle">
                    <label class="form-label" for="password">New Password</label>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                            name="password"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="password">

                        {{-- <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span> --}}

                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 col-md-6 form-password-toggle">
                    <label class="form-label" for="password">Confirm New Password</label>
                    <div class="input-group input-group-merge">
                        <input type="password" id="password_confirmation"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            name="password_confirmation"
                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                            aria-describedby="password_confirmation">

                        {{-- <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span> --}}

                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">SAVE</button>
                <button type="reset" class="btn btn-outline-secondary">CANCEL</button>
            </div>
        </div>
        <!-- /Account -->
        </form>
    </div>
    </div>

@endsection
