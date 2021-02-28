@if($type === 'toolbar')

    @if(call_user_func($renderIf) === true)
        <a href="{{ is_callable($url) ? $url() : $url }}"
           title="{{ $title }}"
           class="{{ $class }}"
           @foreach($dataAttributes as $k => $v)
           data-{{ $k }}={{ $v }}
                @endforeach
        >
            @if($icon)
                <i class="fa {{ $icon }}"></i>
            @endif
            {{ is_callable($name) ? call_user_func($name, $gridName, $gridItem) : $name }}
        </a>
    @endif
@else

    @if(call_user_func($renderIf, $gridName, $gridItem) === true)
        <a href="{{ is_callable($url) ? call_user_func($url, $gridName, $gridItem) : $url }}"
           title="{{ $title }}"
           class="{{ $class }}"
           @foreach($dataAttributes as $k => $v)
           data-{{ $k }}={{ $v }}
                @endforeach
        >
            @if($icon)
                <i class="fa {{ $icon }}"></i>
            @endif
            {{ is_callable($name) ? call_user_func($name, $gridName, $gridItem) : $name }}
        </a>
    @endif
@endif
