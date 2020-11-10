<div class="">
<p class="position-relative p-0 m-0">
<input type="text" name="{{ $name }}[from]" id="{{ $id }}_from"
       form="{{ $formId }}"
       autocomplete="off"
       class="{{ $class }}" value="{{ request($name.'.from') }}" title="{{ $titleSetOnColumn ?? $title }}" placeholder="{{ __('From date') }}"
       @foreach($dataAttributes as $k => $v)
       data-{{ $k }}={{ $v }}
        @endforeach
>
</p>
<p class="position-relative p-0 m-0">
<input type="text" name="{{ $name }}[to]" id="{{ $id }}_to"
       form="{{ $formId }}"
       autocomplete="off"
       class="{{ $class }}" value="{{ request($name.'.to') }}" title="{{ $titleSetOnColumn ?? $title }}" placeholder="{{ __('To date') }}"
       @foreach($dataAttributes as $k => $v)
       data-{{ $k }}={{ $v }}
        @endforeach
>
</p>
</div>