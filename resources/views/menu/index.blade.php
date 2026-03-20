@extends('layouts.app')
@section('title','Menu Settings')
@push('styles')
<style>
  .sortable-placeholder {
    height: 50px;
    margin: 8px 0;
    border: 1px dashed #999;
    background: #f8f9fa;
}

.menuitem > .item-wrap {
    cursor: move;
}

#menuItems,
#menuItems ul {
    list-style: none;
    margin: 0;
    padding-left: 0;
}

#menuItems .nested-menu {
    margin-left: 25px;
    min-height: 0;
}

#menuItems .nested-menu:empty {
    display: none;
}

#menuItems .item-wrap {
    display: block;
}

.sortable-placeholder {
    height: 56px !important;
    border: 1px dashed #999;
    background: #f8f9fa;
    margin: 6px 0;
}

.nested-menu {
    margin-top: 10px;
    margin-left: 30px;
    padding-left: 0;
}
</style>
@endpush
@section('content')
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <h3 class="mb-4">Menu Settings</h3>
    <div class="row">
      <div class="col-md-12">
        <div class="card mb-3">
            <div class="card-body">
              <h5 class="mb-0 card-title">Choose a Menu to manage</h5>
            </div>
            <div class="card-body">
                <div class="row">
                  <select
                    class="form-select"
                    id="menuSelect">
                    <option value="" @if(!$menu) selected @endif>Choose...</option>
                    <option value="header" @if($menu && $menu == 'header') selected @endif>Header</option>
                    <option value="footer1" @if($menu && $menu == 'footer1') selected @endif>Footer</option>
                  </select>
                  {{-- <button class="btn btn-outline-primary" title="Select" type="button"><i class="icon-base ri ri-checkbox-multiple-line"></i></button> --}}
                </div>
            </div>
            <!-- /Notifications -->
          </div>
      </div>
      <div class="col-md-12">
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="mb-0 card-title">Add Item to Menu</h5>
            <div class="row">
              <div class="col-md-4">
                <div class="demo-inline-spacing mt-4">
                  <div class="list-group list-group-flush">
                    @foreach (\App\Models\MenuLink::MENU_TYPES as $key => $item)
                        <a href="javascript:void(0);" data-type="{{$key}}" class="list-group-item list-group-item-action addType">
                          {{$item}}
                        </a>
                    @endforeach
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <form action="{{route('settings.menu.store')}}" method="POST">
                  <input type="hidden" name="menu" value="{{$menu ?? ''}}">
                  <ul class="list-group accordion mt-4 nested-sortable-root" id="menuItems">
                    @if($menulinks && count($menulinks) > 0)
                    @php
                      $childrencount = 0;
                    @endphp
                    @foreach ($menulinks as $index => $menuitem)
                      @include('menu.item',['type' => $menuitem->type, 'count' => $childrencount + $index + 1, 'parent' => 0,'menuitem' => $menuitem])
                      @php
                        if(count($menuitem->children) > 0)
                        {
                          $childrencount = $childrencount + count($menuitem->children);
                        }
                      @endphp
                        
                    @endforeach
                    @else
                      <li>No items in menu.</li>
                    @endif
                  </ul>
                  <div class="d-flex @if(!$menu) d-none @endif" id="saveMenuBtn">
                    <button type="submit" class="btn btn-primary ms-auto waves-effect waves-light" @if(!$menu) disabled @endif>Save Menu</button>
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
<script src="{{asset('js/localjs/menu.js')}}"></script>
@endpush