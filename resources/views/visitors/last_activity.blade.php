@if($activity)
@switch($activity->event_type)
    @case('page_view')
    <span class="badge rounded-pill bg-label-info me-1">{{ $activity->event_type }}</span>
        @break
    @case('calculation')
        <span class="badge rounded-pill bg-label-success me-1">{{ $activity->event_type }}</span>
        @break
    @default
        <span class="badge rounded-pill bg-label-primary me-1">{{ $activity->event_type }}</span>
@endswitch
<br>Dated: <i>{{\Carbon\Carbon::parse($activity->created_at)->format(formatted_date())}}</i>
<br>IP Address: <i>{{$activity->ip}}
@else
<span>--No Activity--</span>
@endif