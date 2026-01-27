@extends('layouts.app')
@section('title', 'Calculators')
@section('content')

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
</style>

<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">

    <h3 class="mb-4">Calculator</h3>

    <div class="row mb-4">
      <div class="col-md-4">
        <div class="card p-3 text-center">
          <h5>Total Calculator</h5>
          <h2 id="countTotal">0</h2>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card p-3 text-center">
          <h5>Active Calculator</h5>
          <h2 id="countActive">0</h2>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card p-3 text-center">
          <h5>Inactive Calculator</h5>
          <h2 id="countInactive">0</h2>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-end mb-3">
      <button class="btn btn-primary" id="btnAddcalculator">+ Add Calculator</button>
    </div>

    <div class="table-responsive">
      <table class="table" id="tableid">
        <thead>
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>Sub-Category</th>
            <th>Description</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="calculatorList"></tbody>
      </table>
    </div>

    @include('calculators.form')

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Confirm Delete</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">Are you sure you want to delete this?</div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/localjs/calculators.js')}}"></script>\
@endpush
