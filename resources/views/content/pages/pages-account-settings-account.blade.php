@extends('layouts/contentNavbarLayout')

@section('title', 'Register Agent')

@section('page-script')
<script src="{{asset('assets/js/pages-account-settings-account.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Agent /</span> Register Agent
</h4>

<div class="row">
  <div class="col-md-12">
    {{-- <ul class="nav nav-pills flex-column flex-md-row mb-3">
      <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Account</a></li>
      <li class="nav-item"><a class="nav-link" href="{{url('pages/account-settings-notifications')}}"><i class="bx bx-bell me-1"></i> Notifications</a></li>
      <li class="nav-item"><a class="nav-link" href="{{url('pages/account-settings-connections')}}"><i class="bx bx-link-alt me-1"></i> Connections</a></li>
    </ul> --}}
    <div class="card mb-4">
      <h5 class="card-header">Create Agent Account</h5>
      <!-- Account -->
      <div class="card-body">
        <div class="d-flex align-items-start align-items-sm-center gap-4">
          <img src="{{asset('assets/img/avatars/1.png')}}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
          <div class="button-wrapper">
            <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
              <span class="d-none d-sm-block">Upload new photo</span>
              <i class="bx bx-upload d-block d-sm-none"></i>
              <input type="file" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg" />
            </label>

            <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
          </div>
        </div>
      </div>
      <hr class="my-0">
      <div class="card-body">
        <form method="POST" onsubmit="return false">
          <div class="row">
            <div class="mb-3 col-md-6">
              <label for="name" class="form-label">Name</label>
              <input class="form-control" type="text" id="name" name="name" value="John" autofocus />
            </div>
            <div class="mb-3 col-md-6">
              <label for="email" class="form-label">E-mail</label>
              <input class="form-control" type="text" id="email" name="email" placeholder="john.doe@example.com" />
            </div>
            <div class="mb-3 col-md-6">
              <label for="phoneNumber" class="form-label">Phone Number</label>
              <input class="form-control" type="text" id="phone_number" name="phone_number" placeholder="08000000012" />
            </div>
            <div class="mb-3 col-md-6">
              <label for="account_number" class="form-label">Account Number</label>
              <input class="form-control" type="text" id="account_number" name="account_number" placeholder="8023451256" />
            </div>
            <div class="mb-3 col-md-6">
              <label for="bank" class="form-label">Bank</label>
               <select id="bank_name" class="select2 form-select">
                <option value="">Select</option>
                <option value="AB Microfinance Bank Nigeria Limited">AB Microfinance Bank Nigeria Limited</option>
                <option value="AB Microfinance Bank Nigeria Limited">AB Microfinance Bank Nigeria Limited</option>
                <option value="Access Bank Plc">Access Bank Plc</option>
                <option value="Citibank Nigeria Limited">Citibank Nigeria Limited</option>
                <option value="Coronation Merchant Bank Limited">Coronation Merchant Bank Limited</option>
                <option value="C24 Limited">C24 Limited</option>
                <option value="Diamond Bank Plc">Diamond Bank Plc</option>
                <option value="Ecobank Nigeria Plc">Ecobank Nigeria Plc</option>
                <option value="Enterprise Bank Limited">Enterprise Bank Limited</option>
                <option value="Fidelity Bank Plc">Fidelity Bank Plc</option>
                <option value="First Bank of Nigeria Limited">First Bank of Nigeria Limited</option>
                <option value="First City Monument Bank Plc">First City Monument Bank Plc</option>
                <option value="Grobank Limited">Grobank Limited</option>
                <option value="Guaranty Trust Bank Plc">Guaranty Trust Bank Plc</option>
                <option value="Heritage Banking Company Limited">Heritage Banking Company Limited</option>
                <option value="Infiniti Mortgage Bank Limited">Infiniti Mortgage Bank Limited</option>
                <option value="Jaiz Bank Plc">Jaiz Bank Plc</option>
                <option value="Keystone Bank Limited">Keystone Bank Limited</option>
                <option value="Kuda Bank Limited">Kuda Bank Limited</option>
                <option value="Mainstreet Bank Limited">Mainstreet Bank Limited</option>
                <option value="Nova Merchant Bank Limited">Nova Merchant Bank Limited</option>
                <option value="Page Financials">Page Financials</option>
                <option value="Parallex Bank Limited">Parallex Bank Limited</option>
                <option value="Polaris Bank Limited">Polaris Bank Limited</option>
                <option value="Providus Bank Limited">Providus Bank Limited</option>
                <option value="Rand Merchant Bank Nigeria Limited">Rand Merchant Bank Nigeria Limited</option>
                <option value="Renmoney">Renmoney</option>
                <option value="Rosabon Financial Services Limited">Rosabon Financial Services Limited</option>
                <option value="Specta">Specta</option>
                <option value="Stanbic IBTC Bank Plc">Stanbic IBTC Bank Plc</option>
                <option value="Standard Chartered Bank Nigeria Limited">Standard Chartered Bank Nigeria Limited</option>
                <option value="Sterling Alternative Finance">Sterling Alternative Finance</option>
                <option value="Sterling Bank Plc">Sterling Bank Plc</option>
                <option value="Suntrust Bank Nigeria Limited">Suntrust Bank Nigeria Limited</option>
                <option value="Taj Bank Limited">Taj Bank Limited</option>
                <option value="Titan Trust Bank Limited">Titan Trust Bank Limited</option>
                <option value="Union Bank of Nigeria Plc">Union Bank of Nigeria Plc</option>
                <option value="United Bank for Africa Plc">United Bank for Africa Plc</option>
                <option value="Unity Bank Plc">Unity Bank Plc</option>
                <option value="VFD Microfinance Bank Limited">VFD Microfinance Bank Limited</option>
                <option value="Wema Bank Plc">Wema Bank Plc</option>
                <option value="zenith">Zenith Bank</option>
              </select>           
            </div>
            <div class="mb-3 col-md-6">
              <label for="address" class="form-label">Home Address</label>
              <input type="text" class="form-control" id="Home_Address" name="home_address" placeholder="Lagos,Nigeria" />
            </div>
            <div class="mb-3 col-md-6">
              <label class="form-label" for="gender">Gender</label>
              <select id="gender" class="select2 form-select">
                <option value="">Select</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>
            </div>
          </div>
          <div class="mt-2">
            <button type="submit" class="btn btn-primary me-2">SAVE</button>
            <button type="reset" class="btn btn-outline-secondary">CANCEL</button>
          </div>
        </form>
      </div>
      <!-- /Account -->
    </div>
    {{-- <div class="card">
      <h5 class="card-header">Delete Account</h5>
      <div class="card-body">
        <div class="mb-3 col-12 mb-0">
          <div class="alert alert-warning">
            <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your account?</h6>
            <p class="mb-0">Once you delete your account, there is no going back. Please be certain.</p>
          </div>
        </div>
        <form id="formAccountDeactivation" onsubmit="return false">
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="accountActivation" id="accountActivation" />
            <label class="form-check-label" for="accountActivation">I confirm my account deactivation</label>
          </div>
          <button type="submit" class="btn btn-danger deactivate-account">Deactivate Account</button>
        </form>
      </div>
    </div> --}}
  </div>
</div>
@endsection
