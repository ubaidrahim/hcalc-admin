<div class="dropdown">
    <button class="btn btn-outline-primary btn-icon btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown"
                        aria-expanded="false"><i class="icon-base ri ri-more-2-line"></i></button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><button class="dropdown-item waves-effect editBtn" type="button" data-id="{{ $query->id }}">Edit</button></li>
        <li><button class="dropdown-item waves-effect delete_record" type="button" data-url="{{route('sitescripts.destroy',[$query->id])}}">Delete</button></li>
      </ul>
</div>