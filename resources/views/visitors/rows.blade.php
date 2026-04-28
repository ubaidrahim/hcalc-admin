@foreach ($query as $item)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td> {{$item->id}} </td>
        <td> {{$item->ip}} </td>
        <td> {{$item->city ?? ''}} </td>
        <td> {{$item->country ?? ''}} </td>
        <td> {{count($item->pageviews)}} </td>
        <td> {{count($item->calculations)}} </td>
        <td> {{\Carbon\Carbon::parse($item->created_at)->format(formatted_date())}} </td>
        <td>@include('visitors.last_activity',['activity' => $item->last_activity])</td>
    </tr>
@endforeach