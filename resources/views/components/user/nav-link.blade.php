@props(['active' => false])

@php
    $classes = "block px-6 py-3 font-medium transition-colors ";
    $classes .= $active ? 'text-yellow-700' : 'text-gray-700  hover:text-yellow-700';
@endphp

<a {{$attributes->merge(['class' => $classes])}}>
    {{$slot}}
</a>
