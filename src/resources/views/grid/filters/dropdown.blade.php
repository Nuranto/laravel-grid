@php
$value = request($name) ?: request(str_replace('.', '_', $name));
if(is_string($value)) {
    $value = explode(',', $value);
}
$multiple = $multiple ?? false;
@endphp

<select name="{{ $name }}@if($multiple)[]@endif" id="{{ $id }}" form="{{ $formId }}" class="{{ $class }}" @if($multiple) multiple="mulitple" @endif>
    <option value=""></option>
    @foreach($data as $k => $v)
        @if($value !== null && in_array($k, $value))
            <option value="{{ $k }}" selected>{{ $v }}</option>
        @else
            <option value="{{ $k }}">{{ $v }}</option>
        @endif
    @endforeach
</select>