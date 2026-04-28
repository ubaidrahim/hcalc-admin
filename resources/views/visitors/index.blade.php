@extends('layouts.app')
@section('title', 'Visitors')
@section('table','visitors')
@push('styles')
<style>
  .card p { margin:0; }

  .same-height .form-control,
  .same-height .select2-container .select2-selection--single {
      height: 40px !important;
  }

  .same-height .select2-container--default .select2-selection--single .select2-selection__rendered {
      line-height: 38px !important;
  }

  .same-height .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 38px !important;
  }
  .list-group-item {
    cursor: pointer;
    flex: 0 0 50%;
  }
</style>
@endpush
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">

    <h3 class="mb-4">Vistors</h3>

    <div class="row mb-4">
      <div class="col-md-4">
        <div class="card p-3 text-center border border-primary">
          <h5>Total Visitors</h5>
          <h2 id="countTotal">{{\App\Models\Visitor::count()}}</h2>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card p-3 text-center border border-warning">
          <h5>Total Activity <br><small>(Page Views)</small></h5>
          <h2 id="countActive">{{\App\Models\TrackVisitor::where('event_type','page_view')->count()}}</h2>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card p-3 text-center border border-info">
          <h5>Total Calculations</h5>
          <h2 id="countInactive">{{\App\Models\Calculation::count()}}</h2>
        </div>
      </div>
      <div class="col-md-12">
          <div class="card p-4">
            <h5 class="card-header">Visitors List</h5>
              <div class="table-responsive">
                <table class="table table-striped" id="tableid">
                  <thead>
                    <tr>
                      <th>SR #</th>
                      <th>ID</th>
                      <th>IP Address</th>
                      <th>City</th>
                      <th>Country</th>
                      <th>Total Page Views</th>
                      <th>Total Calculations</th>
                      <th>Created At</th>
                      <th>Last Activity</th>
                    </tr>
                  </thead>
                  <tbody id="visitorList"></tbody>
                </table>
              </div>
              <div class="my-3" id="paginationLinks"></div>
          </div>
      </div>
    </div>

  </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/localjs/visitors.js')}}"></script>\
@endpush
