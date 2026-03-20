
<li class="list-group-item accordion-item menuitem p-0 mb-2"  data-index="{{$count}}" data-id="0">
    <div class="item-wrap">
    <h2 class="accordion-header p-3 d-flex">
    <button
        type="button"
        class="accordion-button menubtn"
        data-bs-toggle="collapse"
        data-bs-target="#menuItem{{$count}}"
        aria-expanded="true"
        aria-controls="menuItem{{$count}}">
        {{ $menuitem ? $menuitem->title : '<Add Title>'}}
    </button>
    <button class="btn btn-sm remove-menuitem" type="button">X</button>
    </h2>

    <div id="menuItem{{$count}}"
    class="accordion-collapse collapse"
    data-bs-parent="#menuItems">
        <div class="accordion-body">
            <input type="hidden" name="item[{{$count}}][id]" value="{{ $menuitem ? $menuitem->id : 0 }}">
            <input type="hidden" class="item-order" name="item[{{ $count }}][order]" value="{{ $count }}">
            <input type="hidden" class="item-type" name="item[{{ $count }}][type]" value="{{ $type }}">
            <input type="hidden" class="item-parent" name="item[{{ $count }}][parent_id]" value="{{$parent}}">
            <input type="hidden" class="item-remove" name="item[{{ $count }}][remove]" value="0">
            <label class="form-label">Title</label>
            <input type="text" class="form-control form-control-sm itemTitle" @if($menuitem) value="{{$menuitem->title}}" @endif name="item[{{$count}}][title]">
            @switch($type)
                @case(\App\Models\MenuLink::TYPE_CUSTOM_LINK)        
                    <label class="form-label">Link URL</label>
                    <input type="text" class="form-control form-control-sm" name="item[{{$count}}][url]" @if($menuitem) value="{{$menuitem->url}}" @endif>
                    @break
                @case(\App\Models\MenuLink::TYPE_CATEGORY)
                    <select name="item[{{$count}}][category_id]" class="form-select form-select-sm select2">
                        @foreach (\App\Models\Category::where('status',1)->get() as $cat)
                            <option @if($menuitem && $menuitem->category_id == $cat->id) selected @endif value="{{$cat->id}}">{{$cat->title}}</option>
                        @endforeach
                    </select>
                    @break
                @case(\App\Models\MenuLink::TYPE_CALCULATOR)
                    <select name="item[{{$count}}][calculator_id]" class="form-select form-select-sm select2">
                        @foreach (\App\Models\Calculator::where('status',1)->get() as $cal)
                            <option value="{{$cal->id}}" @if($menuitem && $menuitem->calculator_id == $cal->id) selected @endif>{{$cal->title}}</option>
                        @endforeach
                    </select>
                    @break
                @case(\App\Models\MenuLink::TYPE_CATEGORY_CALCULATORS)
                    
                    @break
                @default
                    
            @endswitch
        </div>
    </div>
    </div>
    @if($type == \App\Models\MenuLink::TYPE_CUSTOM_LINK && $parent == 0)
    <ul class="nested-menu list-group mt-2">
        @if($menuitem && count($menuitem->children) > 0)
            @foreach ($menuitem->children as $i => $menulink)
                @include('menu.item',['type' => $menulink->type, 'count' => $count + $i + 1, 'parent' => $count,'menuitem' => $menulink])
                
            @endforeach
        @endif
    </ul>
    @endif
</li>