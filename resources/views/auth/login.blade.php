@extends('layouts.app')
@section('title','Login')
@push('styles')
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}" />
@endpush
@section('content')
    <div class="position-relative">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-6 mx-4">
          <!-- Login -->
          <div class="card p-sm-7 p-2">
            <!-- Logo -->
            <div class="app-brand justify-content-center mt-5">
              <a href="index.html" class="app-brand-link gap-3">
                <span class="app-brand-logo demo">
                  <img src="{{ asset('assets/img/logo.png') }}" alt="HCalculator"  height="30">
                </span>
              </a>
            </div>
            <!-- /Logo -->

            <div class="card-body mt-1">
              <h4 class="mb-1">Welcome to HCalculator! 👋🏻</h4>
              <p class="mb-5">Please sign-in to your account and start the adventure</p>

              <form id="formAuthentication" class="mb-5" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-floating form-floating-outline mb-5 form-control-validation">
                  <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="Enter your email address"
                    autofocus />
                  <label for="email">Email Address</label>
                </div>
                <div class="mb-5">
                  <div class="form-password-toggle form-control-validation">
                    <div class="input-group input-group-merge">
                      <div class="form-floating form-floating-outline">
                        <input
                          type="password"
                          id="password"
                          class="form-control"
                          name="password"
                          placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                          aria-describedby="password" />
                        <label for="password">Password</label>
                      </div>
                      <span class="input-group-text cursor-pointer"
                        ><i class="icon-base ri ri-eye-off-line icon-20px"></i
                      ></span>
                    </div>
                  </div>
                </div>
                <div class="mb-5 pb-2 d-flex justify-content-between pt-2 align-items-center">
                  <div class="form-check mb-0">
                    <input class="form-check-input" type="checkbox" id="remember-me" />
                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                  </div>
                  <a href="#" class="float-end mb-1">
                    <span>Forgot Password?</span>
                  </a>
                </div>
                <div class="mb-5">
                  <button class="btn btn-primary d-grid w-100" type="submit">login</button>
                </div>
              </form>
            </div>
          </div>
          <!-- /Login -->
          <img
            src="{{asset('assets/img/illustrations/tree-3.png')}}"
            alt="auth-tree"
            class="authentication-image-object-left d-none d-lg-block" />
          <img
            src="{{asset('assets/img/illustrations/auth-basic-mask-light.png')}}"
            class="authentication-image d-none d-lg-block scaleX-n1-rtl"
            height="172"
            alt="triangle-bg" />
          <img
            src="{{asset('assets/img/illustrations/tree.png')}}"
            alt="auth-tree"
            class="authentication-image-object-right d-none d-lg-block" />
        </div>
      </div>
    </div>
@endsection
@push('scripts')
<script>
  $('form').on('submit', function (e) {
    e.preventDefault();
    var form = $(this)[0];
    var submit_btn = $(this).find('button[type="submit"]');
    submit_btn.prop('disabled', true);
    if (!form.checkValidity()) {
        form.reportValidity();
        submit_btn.prop('disabled', false);
        return false;
    } else {
        // submit_btn.prop('disabled', true);
        let url = $(this).attr('action');
        let type = $(this).attr('method');
        let data = new FormData(form);
        SendAjaxRequestToServer(type, url, data, '', formSaved, submit_btn, submit_btn);
        // form.submit();
    }
});

function formSaved(response) {
    if (response.status == 1) {
        toastr.success('Login Successful', 'Success');
        window.location = response.goto;
    } else {
        toastr.error(response.message, 'Error');
    }
}
</script>
@endpush