@props(['active' => false])

@php
    $classes = "block px-6 py-3 font-medium transition-colors ";
    $classes .= $active ? 'bg-yellow-50 text-yellow-700 border-l-4 border-yellow-400' : 'text-gray-700 hover:bg-yellow-50 hover:text-yellow-700';
@endphp

<a {{$attributes->merge(['class' => $classes])}}>
    {{$slot}}
</a>
