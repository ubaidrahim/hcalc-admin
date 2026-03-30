@extends('layouts.app')
@section('title','Footer Content')
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h3 class="mb-4">Footer Content</h3>
    <div class="row g-6 mb-6">
        <!-- Float label (Outline) -->
        <div class="col-md-4">
            <div class="card">
                <h5 class="card-header">Column 1</h5>
                <div class="card-body">
                    <form method="POST" action="{{route('content.footer.store')}}">
                        <div class="form-floating form-floating-outline mb-5">
                            <input
                                type="text"
                                class="form-control"
                                id="columnOneTitle"
                                name="colOneTitle"
                                value="@getFooterContent('colOneTitle')"
                                aria-describedby="ColumnOneTitle" />
                            <label for="columnOneTitle">Title</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea
                                class="form-control"
                                id="heroDesc"
                                name="colOneDesc"
                                aria-describedby="heroDescDesc">@getFooterContent('colOneDesc')</textarea>
                            <label for="heroDesc">Description</label>
                            <div id="heroDescDesc" class="form-text">
                                Brief description
                            </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text"
                                class="form-control"
                                id="ColumnOneLinkText"
                                name="colOneLinkText"
                                value="@getFooterContent('colOneLinkText')"
                                aria-describedby="ColumnOneLinkText">
                            <label for="heroDesc">Link Text</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text"
                                class="form-control"
                                id="ColumnOneLinkUrl"
                                name="colOneLinkUrl"
                                value="@getFooterContent('colOneLinkUrl')"
                                aria-describedby="ColumnOneLinkText">
                            <label for="ColumnOneLinkText">Link Url</label>
                        </div>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <h5 class="card-header">Column 2</h5>
                <div class="card-body">
                    <form method="POST" action="{{route('content.footer.store')}}">
                        <div class="form-floating form-floating-outline mb-5">
                            <input
                                type="text"
                                class="form-control"
                                id="columnTwoTitle"
                                name="colTwoTitle"
                                value="@getFooterContent('colTwoTitle')"
                                aria-describedby="ColumnTwoTitle" />
                            <label for="ColumnTwoTitle">Title</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea
                                class="form-control"
                                id="ColumnTwoDescription"
                                name="colTwoDesc"
                                aria-describedby="ColumnTwoDescription">@getFooterContent('colTwoDesc')</textarea>
                            <label for="ColumnTwoDescription">Description</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text"
                                class="form-control"
                                id="ColumnTwoLinkText"
                                name="colTwoLinkText"
                                value="@getFooterContent('colTwoLinkText')"
                                aria-describedby="ColumnTwoLinkText">
                            <label for="heroDesc">Link Text</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <input type="text"
                                class="form-control"
                                id="ColumnTwoLinkUrl"
                                name="colTwoLinkUrl"
                                value="@getFooterContent('colTwoLinkUrl')"
                                aria-describedby="ColumnTwoLinkUrl">
                            <label for="ColumnTwoLinkUrl">Link Url</label>
                        </div>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <h5 class="card-header">Column 3</h5>
                <div class="card-body">
                    <form method="POST" action="{{route('content.footer.store')}}">
                        <div class="form-floating form-floating-outline mb-5">
                            <input
                                type="text"
                                class="form-control"
                                id="columnThreeTitle"
                                name="colThreeTitle"
                                value="@getFooterContent('colThreeTitle')"
                                aria-describedby="ColumnThreeTitle" />
                            <label for="ColumnThreeTitle">Title</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea
                                class="form-control"
                                id="ColumnThreeDescription"
                                name="colThreeDesc"
                                aria-describedby="ColumnThreeDescription">@getFooterContent('colThreeDesc')</textarea>
                            <label for="ColumnThreeDescription">Description</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <input
                                type="text"
                                class="form-control"
                                id="ColumnThreeLinkText"
                                name="colThreeLinkText"
                                value="@getFooterContent('colThreeLinkText')"
                                aria-describedby="ColumnThreeLinkText">
                            <label for="heroDesc">Link Text</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <input
                                type="text"
                                class="form-control"
                                id="ColumnThreeLinkUrl"
                                name="colThreeLinkUrl"
                                value="@getFooterContent('colThreeLinkUrl')"
                                aria-describedby="ColumnThreeLinkUrl">
                            <label for="ColumnThreeLinkUrl">Link Url</label>
                        </div>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Footer Information</h5>
                <div class="card-body">
                    <form method="POST" action="{{route('content.footer.store')}}">
                        <div class="form-floating form-floating-outline mb-5">
                            <textarea
                                class="form-control"
                                id="pageTitle"
                                name="brief"
                                aria-describedby="pageNote">@getFooterContent('brief')</textarea>
                            <label for="pageTitle">Footer Brief</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-5">
                            <input
                                type="text"
                                class="form-control"
                                id="footerNote"
                                name="footerNote"
                                value="@getFooterContent('footerNote')"
                                aria-describedby="fotterNote" />
                            <label for="footerNote">Footer Note</label>
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
<script src="{{asset('js/localjs/footer.js')}}"></script>
@endpush