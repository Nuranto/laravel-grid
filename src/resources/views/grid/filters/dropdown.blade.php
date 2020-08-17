@php
$value = request($name);
if(is_string($value)) {
    $value = explode(',', $value);
}
@endphp

<select name="{{ $name }}@if($multiple??false)[]@endif" id="{{ $id }}" form="{{ $formId }}" class="{{ $class }}" @if($multiple??false) multiple="mulitple" @endif>
    <option value=""></option>
    @foreach($data as $k => $v)
        @if($value !== null && in_array($k, $value))
            <option value="{{ $k }}" selected>{{ $v }}</option>
        @else
            <option value="{{ $k }}">{{ $v }}</option>
        @endif
    @endforeach
</select>