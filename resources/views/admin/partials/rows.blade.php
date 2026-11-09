@foreach($query as $user)
<tr>
    <td>
        <ul class="list-unstyled m-0 avatar-group d-flex align-items-center">
        <li
            data-bs-toggle="tooltip"
            data-popup="tooltip-custom"
            data-bs-placement="top"
            class="avatar avatar-md pull-up"
            title="Lilian Fuller">
            <img src="{{asset($user->image ? $user->image : 'assets/img/illustrations/blank.png')}}" alt="Avatar" class="rounded-circle" />
        </li>
        
        </ul>
    </td>
    <td><span>{{$user->name}}</span></td>
    <td><span>{{$user->email}}</span></td>
    <td>
        @if(auth()->user()->id == $user->id)
        <span class="badge rounded-pill bg-label-success me-1">Active User</span>
        @else
        <label class="form-check form-switch" for="active_checkbox{{$user->id}}">
                <input type="checkbox" class="form-check-input status_enable_disable" role="switch"
                        id="active_checkbox{{$user->id}}" value="{{$user->id}}"
                            {{$user->status == 1 ? 'checked' : ''}}><i class="slider round"></i>
            </label>
        @endif
    </td>
    <td>
        <div class="dropdown">
        <button
            type="button"
            class="btn p-0 dropdown-toggle hide-arrow shadow-none"
            data-bs-toggle="dropdown">
            <i class="icon-base ri ri-more-2-line icon-18px"></i>
        </button>
        <div class="dropdown-menu">
            @if(auth()->user()->id == $user->id)
            <a class="dropdown-item editBtn" href="javascript:void(0);" data-id="{{$user->id}}">
            <i class="icon-base ri ri-pencil-line icon-18px me-1"></i>
                Edit User
            </a>
            <a class="dropdown-item changepass" href="javascript:void(0);" data-id="{{$user->id}}">
            <i class="icon-base ri ri-account-circle-line icon-18px me-1"></i>
                Change Password
            </a>
            @else
            <a class="dropdown-item delete_record" href="javascript:void(0);" data-url="{{route('settings.admin.destroy',[$user->id])}}">
            <i class="icon-base ri ri-delete-bin-6-line icon-18px me-1"></i>
            Remove User</a>
            @endif
        </div>
        </div>
    </td>
    </tr>
@endforeach