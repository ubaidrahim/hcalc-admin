@extends('layouts.app')
@section('title','Site Scripts')
@section('table','site_scripts')

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

    <h3 class="mb-4">Site Scripts</h3>

    <div class="row mb-4">
      <div class="col-md-4">
        <div class="card p-3 text-center">
          <h5>Total Scripts</h5>
          <h2 id="countTotal">0</h2>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card p-3 text-center">
          <h5>Active Categories</h5>
          <h2 id="countActive">0</h2>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card p-3 text-center">
          <h5>Inactive Categories</h5>
          <h2 id="countInactive">0</h2>
        </div>
      </div>
    </div>
    <div class="row mb-4">
      <div class="col-md-12">
        <div class="card p-4">
          <div class="d-flex justify-content-end mb-3">
            <div class="btn-group">
              <button class="btn btn-primary dropdown-toggle overflow-hidden d-sm-inline-flex d-block text-truncate" data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">+ Add New</button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><button class="dropdown-item waves-effect addBtn" type="button" data-type="gtag">GTAG Script</button></li>
                <li><button class="dropdown-item waves-effect addBtn" type="button" data-type="gmt">GMT Script</button></li>
                <li><button class="dropdown-item waves-effect addBtn" type="button" data-type="adsense">Adsense Script</button></li>
                <li><button class="dropdown-item waves-effect addBtn" type="button" data-type="meta_tag">Meta Tag</button></li>
                <li><button class="dropdown-item waves-effect addBtn" type="button" data-type="external_src">External URL Script</button></li>
              </ul>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-striped" id="tableid">
              <thead>
                <tr>
                  <th>SR #</th>
                  <th>Name</th>
                  <th>Type</th>
                  <th>Placement</th>
                  <th>Configuration</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="categoryList"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    @include('sitescripts.form')

  </div>
</div>
@endsection

@push('scripts')

<script src="{{asset('js/localjs/sitescripts.js')}}"></script>
@endpush
