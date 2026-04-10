@extends('layouts.app')
@section('title','Home Content')
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h3 class="mb-4">Homepage Content</h3>
    <div class="row g-6 mb-6">
        <!-- Float label (Outline) -->
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Page Meta Data</h5>
                <div class="card-body">
                    <form method="POST" action="{{route('content.home.store')}}">
                        <div class="form-floating form-floating-outline mb-5">
                            <input
                                type="text"
                                class="form-control"
                                id="pageTitle"
                                name="title"
                                value="@getHomeContent('title')"
                                aria-describedby="pageTitleDesc" />
                            <label for="pageTitle">Title</label>
                            <div id="pageTitleDesc" class="form-text">
                                Title for the Homepage
                            </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea
                                class="form-control"
                                id="pageMeta"
                                name="meta_description"
                                aria-describedby="pageMetaDesc">@getHomeContent('meta_description')</textarea>
                            <label for="pageMeta">Meta Description</label>
                            <div id="pageMetaDesc" class="form-text">
                                Meta Description for the Homepage
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header">Hero Section</h5>
                <div class="card-body">
                    <form method="POST" action="{{route('content.home.store')}}">
                        <div class="form-floating form-floating-outline mb-5">
                            <input
                                type="text"
                                class="form-control"
                                id="heroTitle"
                                name="hero_title"
                                value="@getHomeContent('hero_title')"
                                aria-describedby="heroTitleDesc" />
                            <label for="heroTitle">Title</label>
                            <div id="heroTitleDesc" class="form-text">
                                Hero Section Title content
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="file" id="heroBg" name="hero_bg" />
                                <label for="heroBg" class="form-label">Hero Background</label>
                            </div>
                            @php
                                $heroBg = (new class {
                                    use \App\Traits\ContentTrait;
                                })->getHomeContent('hero_bg');
                            @endphp
                            @if($heroBg && trim((string) $heroBg) !== '')
                            <div class="form-floating form-floating-outline mb-5 ms-auto">
                                <img src="{{ asset($heroBg) }}" alt="Hero Background" height="100" class="mb-3 rounded p-2 border border-primary ms-auto">
                                <label for="heroBg" class="form-label text-primary">Image Preview</label>
                            </div>
                            @endif
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea
                                class="form-control"
                                id="heroDesc"
                                name="hero_description"
                                aria-describedby="heroDescDesc">@getHomeContent('hero_description')</textarea>
                            <label for="heroDesc">Description</label>
                            <div id="heroDescDesc" class="form-text">
                                Brief description for hero section
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header">About Section</h5>
                <div class="card-body">
                    <form method="POST" action="{{route('content.home.store')}}">
                        <div class="form-floating form-floating-outline mb-5">
                            <input
                                type="text"
                                class="form-control"
                                id="aboutTitle"
                                name="about_title"
                                value="@getHomeContent('about_title')"
                                aria-describedby="aboutTitleDesc" />
                            <label for="aboutTitle">Title</label>
                            <div id="aboutTitleDesc" class="form-text">
                                About Section Title
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="form-floating form-floating-outline mb-5">
                                <input class="form-control" type="file" id="aboutImage" name="about_image" />
                                <label for="aboutImage" class="form-label">About Image</label>
                            </div>
                            @php
                                $aboutImage = (new class {
                                    use \App\Traits\ContentTrait;
                                })->getHomeContent('about_image');
                            @endphp
                            @if($aboutImage && trim((string) $aboutImage) !== '')
                            <div class="form-floating form-floating-outline mb-5 ms-auto">
                                <img src="{{ asset($aboutImage) }}" alt="About Image" height="100" class="mb-3 rounded p-2 border border-primary ms-auto">
                                <label for="aboutImage" class="form-label text-primary">Image Preview</label>
                            </div>
                            @endif
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea
                                class="form-control"
                                id="aboutDesc"
                                name="about_description"
                                aria-describedby="aboutDescDesc">@getHomeContent('about_description')</textarea>
                            <label for="aboutDesc">Description</label>
                            <div id="aboutDescDesc" class="form-text">
                                Brief description for hero section
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script src="{{asset('js/localjs/homecontent.js')}}"></script>
@endpush