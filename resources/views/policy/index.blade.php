@extends('layouts.app')
@if($type == 'privacy_policy')
@section('title','Privacy Policy')
@else
@section('title','Terms of Use')
@endif
@section('table','policy_content')

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
{{-- kanwal --}}
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">

    <h3 class="mb-4">
        @if($type == 'privacy_policy')
        Privacy Policy
        @else
        Terms of Use
        @endif
    </h3>

    <div class="row mb-4">
      <div class="col-md-12">
        <div class="card p-5">
            <div class="row">
               <div class="col-md-12">
                  <div class="settings-card">
                     <form action="{{route('content.policy.store',$type)}}" method="POST">
                        <div class="mb-3">
                           <label class="form-label">Policy Title</label>
                           <input type="text" class="form-control" placeholder="Enter title" id="title" name="title" value="{{getPolicyContent('title',$type)}}">
                        </div>

                        <div class="mb-3">
                           <label class="form-label">Policy Content</label>
                           <textarea class="form-control custom-ckeditor" rows="2" id="content" placeholder="Content..." name="content">{{getPolicyContent('content',$type)}}</textarea>
                        </div>

                        
                        <div class="d-flex mb-3">
                            <button type="submit" class="btn btn-primary ms-auto">Save Settings</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
        </div>
    </div>

    </div>
</div>
</div>
@endsection
@push('scripts')

<script src="{{asset('js/localjs/policy.js')}}"></script>
@endpush
