@extends('layouts.app')
@section('title','Site Settings')
@section('table','website_settings')

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

    <h3 class="mb-4">Site Settings</h3>

    <div class="row mb-4">
      <div class="col-md-12">
        <div class="card p-5">
            <div class="row">
               
            <div class="col-md-4">
                <div class="settings-card p-4 text-center">
                    <form id="imagesForm" action="{{route('settings.website.updateImages')}}" method="POST">
                    <!-- Favicon Section -->
                    <h5 class="mb-3">Favicon</h5>
                    <div class="logo-upload mb-4">
                        <img id="previewFavicon" 
                            src="{{ getWebsiteSetting('favicon') != '' ? asset(getWebsiteSetting('favicon')) : asset('assets/img/illustrations/blank.png') }}" 
                            alt="Favicon" 
                            class="mb-2" 
                            style="max-width:64px; height:64px;">
                        
                        <!-- Hidden file input -->
                        <input type="file" id="faviconInput" name="favicon" accept="image/*" style="display:none;">
                        
                        <div>
                            <button type="button" class="btn btn-primary btn-sm" id="uploadFaviconBtn">Upload Favicon</button>
                            <button type="button" class="btn btn-outline-danger btn-sm" id="removeFaviconBtn">Remove</button>
                        </div>
                    </div>

                    <hr>

                    <!-- Header Logo Section -->
                    <h5 class="mb-3">Header Logo</h5>
                    <div class="logo-upload">
                        <img id="previewLogo" 
                            src="{{ getWebsiteSetting('header_logo') != '' ? asset(getWebsiteSetting('header_logo')) : asset('assets/img/illustrations/blank.png') }}" 
                            alt="Logo" 
                            class="mb-3" 
                            style="max-width:150px;">
                        
                        <!-- Hidden file input -->
                        <input type="file" id="logoInput" name="header_logo" accept="image/*" style="display:none;">
                        
                        <div>
                            <button type="button" class="btn btn-primary btn-sm" id="uploadBtn">Upload Header Logo</button>
                            <button type="button" class="btn btn-outline-danger btn-sm" id="removeBtn">Remove</button>
                        </div>
                    </div>
                </form>
                </div>
                </div>
               <!-- Right Section -->
               <div class="col-md-8">
                  <div class="settings-card">
                     <form action="{{route('settings.website.store')}}" method="POST">
                        <div class="mb-3">
                           <label class="form-label">Site Title</label>
                           <input type="text" class="form-control" placeholder="Enter site title" name="site_title" value="{{getWebsiteSetting('site_title')}}">
                        </div>

                        <div class="mb-3">
                           <label class="form-label">Phone Number</label>
                           <input type="tel" class="form-control" placeholder="+1 234-567-890" name="phone_number" value="{{getWebsiteSetting('phone_number')}}">
                        </div>

                        <div class="mb-3">
                           <label class="form-label">Email</label>
                           <input type="email" class="form-control" placeholder="admin@example.com" name="site_email" value="{{getWebsiteSetting('site_email')}}">
                        </div>

                        <div class="mb-3">
                           <label class="form-label">Address</label>
                           <textarea class="form-control" rows="2" placeholder="Enter address" name="site_address">{{getWebsiteSetting('site_address')}}</textarea>
                        </div>

                        <div class="mb-3 same-height">
                           <label class="form-label">Country</label>
                           <select class="form-select select2" name="country">
                              @foreach ($countries as $item)
                                <option value="{{ $item }}" {{ getWebsiteSetting('country') == $item ? 'selected' : '' }}>
                                    {{ $item }}
                                </option>
                                @endforeach
                           </select>
                        </div>

                        <div class="mb-3">
                           <label class="form-label">Date Format</label>
                           <select class="form-select" id="date_format" name="date_format">
                              @foreach($formats as $format => $example)
                                <option value="{{ $format }}" {{ getWebsiteSetting('date_format') == $format ? 'selected' : '' }}>
                                    {{ $example }}
                                </option>
                            @endforeach
                           </select>
                        </div>
                        <div class="mb-3 same-height">
                           <label class="form-label">Time Zone</label>
                           <select class="form-select select2" id="timezone" name="timezone">
                              @foreach($timezones as $tz)
                                <option value="{{ $tz }}" {{ getWebsiteSetting('timezone') == $tz ? 'selected' : '' }}>
                                    {{ $tz }}
                                </option>
                            @endforeach
                           </select>
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

<script src="{{asset('js/localjs/sitesettings.js')}}"></script>
@endpush
