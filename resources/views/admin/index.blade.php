@extends('layouts.app')
@section('title','Admin Accounts')
@section('table','users')

@push('styles')
<style>
  .card p { margin:0; }

  .iconMenu i
  {
    cursor:pointer;
  }
  .iconMenu i:hover
  {
    color:var(--bs-primary);
  }

</style>
@endpush
@section('content')
{{-- kanwal --}}
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">

    <h3 class="mb-4">Add Accounts</h3>

    <div class="row mb-4">
      <div class="col-md-4">
        <div class="card p-3 text-center">
          <h5>Total Accounts</h5>
          <h2 id="countTotal">0</h2>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card p-3 text-center">
          <h5>Active Accounts</h5>
          <h2 id="countActive">0</h2>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card p-3 text-center">
          <h5>Inactive Accounts</h5>
          <h2 id="countInactive">0</h2>
        </div>
      </div>
    </div>

    <div class="col-md-12">
        <div class="card p-4">

          <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary" id="btnAddAdmin">+ Add Account</button>
          </div>

          <div class="table-responsive">
            <table class="table" id="tableid">
              <thead>
                <tr>
                  <th></th>
                  <th>Name</th>
                  <th>Login Email</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="adminList"></tbody>
            </table>
          </div>
      </div>
    </div>

    @include('admin.partials.form')
    @include('admin.partials.change-password')

  </div>
</div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="{{asset('js/localjs/admin.js')}}"></script>
@endpush
