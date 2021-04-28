<input type="text" name="{{ $name }}" id="{{ $id }}"
       form="{{ $formId }}"
       class="{{ $class }}" value="{{ request($name) ?: request(str_replace('.', '_', $name)) }}" title="{{ $titleSetOnColumn ?? $title }}" placeholder="{{ $titleSetOnColumn ?? $title }}"
       @foreach($dataAttributes as $k => $v)
       data-{{ $k }}={{ $v }}
        @endforeach
>