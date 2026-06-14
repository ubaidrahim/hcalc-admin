@foreach ($query as $item)
    @php
        $avg = $item->averageRating();
        $total = $item->feedbacks->count();
    @endphp
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$item->id}}</td>
        <td>{{$item->title}}</td>
        <td>{{$item->description}}</td>
        <td>{{$item->category->title ?? ''}}</td>
        <td>
            <span class="text-nowrap">
                <i class="ri ri-star-fill text-warning"></i> {{number_format($avg,1)}}/5.0
            </span><br>
            <strong>Total: {{$total}}</strong> 
        </td>
        <td>
            <label class="form-check form-switch" for="active_checkbox{{$item->id}}">
                <input type="checkbox" class="form-check-input status_enable_disable" role="switch"
                        id="active_checkbox{{$item->id}}" value="{{$item->id}}"
                            {{$item->status == 1 ? 'checked' : ''}}><i class="slider round"></i>
            </label>
        </td>
        <td>@include('calculators.partials._action',['query' => $item])</td>
    </tr>
@endforeach