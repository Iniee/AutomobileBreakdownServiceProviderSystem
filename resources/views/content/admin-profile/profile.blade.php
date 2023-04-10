@extends('layouts/contentNavbarLayout')

@section('title', 'Profile')

@section('content')


<div class="card mb-4">
  <h5 class="card-header">ADMIN PROFILE</h5>
  <!-- Account -->
    <div class="card-body">
        <form class="mb-3" action="{{ route('admin.update') }}" method="POST">
            @csrf
            <hr class="my-0">
            <div class="card-body">

                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text"
                            id="name" name="name" value="{{ $user->name  }}"
                            placeholder="John"
                            required readonly/>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="email" class="form-label">E-mail</label>
                        <input class="form-control @error('email') is-invalid @enderror" type="text"
                            id="email" name="email" value="{{ $user->email }}"
                            placeholder="john.doe@example.com" required readonly/>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="account_number" class="form-label">Account Number</label>
                        <input class="form-control @error('account_number') is-invalid @enderror" type="text"
                            max="10" id="account_number" name="account_number"
                            value="{{ $user->account_number }}" placeholder="8023451256" />
                        @error('account_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="bank" class="form-label">Bank</label>
                        <select name="bank_name" id="bank_name" class="select2 form-select">
                            <option value="{{ $user->bank_name }}">{{ $user->bank_name }}</option>
                            <option value="AB Microfinance Bank Nigeria Limited">AB Microfinance Bank Nigeria
                                Limited</option>
                            <option value="AB Microfinance Bank Nigeria Limited">AB Microfinance Bank Nigeria
                                Limited</option>
                            <option value="Access Bank Plc">Access Bank Plc</option>
                            <option value="Citibank Nigeria Limited">Citibank Nigeria Limited</option>
                            <option value="Coronation Merchant Bank Limited">Coronation Merchant Bank Limited
                            </option>
                            <option value="C24 Limited">C24 Limited</option>
                            <option value="Diamond Bank Plc">Diamond Bank Plc</option>
                            <option value="Ecobank Nigeria Plc">Ecobank Nigeria Plc</option>
                            <option value="Enterprise Bank Limited">Enterprise Bank Limited</option>
                            <option value="Fidelity Bank Plc">Fidelity Bank Plc</option>
                            <option value="First Bank of Nigeria Limited">First Bank of Nigeria Limited</option>
                            <option value="First City Monument Bank Plc">First City Monument Bank Plc</option>
                            <option value="Grobank Limited">Grobank Limited</option>
                            <option value="Guaranty Trust Bank Plc">Guaranty Trust Bank Plc</option>
                            <option value="Heritage Banking Company Limited">Heritage Banking Company Limited
                            </option>
                            <option value="Infiniti Mortgage Bank Limited">Infiniti Mortgage Bank Limited
                            </option>
                            <option value="Jaiz Bank Plc">Jaiz Bank Plc</option>
                            <option value="Keystone Bank Limited">Keystone Bank Limited</option>
                            <option value="Kuda Bank Limited">Kuda Bank Limited</option>
                            <option value="Mainstreet Bank Limited">Mainstreet Bank Limited</option>
                            <option value="Nova Merchant Bank Limited">Nova Merchant Bank Limited</option>
                            <option value="Page Financials">Page Financials</option>
                            <option value="Parallex Bank Limited">Parallex Bank Limited</option>
                            <option value="Polaris Bank Limited">Polaris Bank Limited</option>
                            <option value="Providus Bank Limited">Providus Bank Limited</option>
                            <option value="Rand Merchant Bank Nigeria Limited">Rand Merchant Bank Nigeria
                                Limited</option>
                            <option value="Renmoney">Renmoney</option>
                            <option value="Rosabon Financial Services Limited">Rosabon Financial Services
                                Limited</option>
                            <option value="Specta">Specta</option>
                            <option value="Stanbic IBTC Bank Plc">Stanbic IBTC Bank Plc</option>
                            <option value="Standard Chartered Bank Nigeria Limited">Standard Chartered Bank
                                Nigeria Limited</option>
                            <option value="Sterling Alternative Finance">Sterling Alternative Finance</option>
                            <option value="Sterling Bank Plc">Sterling Bank Plc</option>
                            <option value="Suntrust Bank Nigeria Limited">Suntrust Bank Nigeria Limited
                            </option>
                            <option value="Taj Bank Limited">Taj Bank Limited</option>
                            <option value="Titan Trust Bank Limited">Titan Trust Bank Limited</option>
                            <option value="Union Bank of Nigeria Plc">Union Bank of Nigeria Plc</option>
                            <option value="United Bank for Africa Plc">United Bank for Africa Plc</option>
                            <option value="Unity Bank Plc">Unity Bank Plc</option>
                            <option value="VFD Microfinance Bank Limited">VFD Microfinance Bank Limited
                            </option>
                            <option value="Wema Bank Plc">Wema Bank Plc</option>
                            <option value="zenith">Zenith Bank</option>
                        </select>
                    </div>
                    {{-- <div class="mb-3 col-md-6">
                        <label for="address" class="form-label">Home Address</label>
                        <input type="text" class="form-control @error('home_address') is-invalid @enderror"
                            id="home_address" name="home_address" value="{{ old('home_address') }}"
                            placeholder="Enter your address" required autofocus />
                        @error('home_address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div> --}}
                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="gender">Gender</label>
                        <input class="form-control" type="text" value="{{ $user->gender }}" readonly>
                        {{-- <select id="gender" name="gender" class="select2 form-select">
                          <option value="{{ $user->gender }}">{{ $user->gender }}</option>
                          <option value="male">Male</option>
                          <option value="female">Female</option>
                        </select> --}}
                    </div>
                    <div class="mb-3 col-md-6">
                      <label for="text" class="form-label">Phone Number</label>
                      <input class="form-control @error('phone_number') is-invalid @enderror" type="text"
                          id="email" name="phone_number" value="{{ $user->phone_number }}"
                          placeholder="08000000000" required readonly/>
                      @error('phone_number')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
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
