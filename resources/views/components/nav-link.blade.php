@props(['active' => false])

@php
    $classes = "transition-colors duration-200 ease-in inline-flex items-center gap-2 px-5 py-2 rounded-full text-sm font-bold";
    $classes .= $active ? ' text-white bg-gray-800 shadow-md' : ' text-gray-700 bg-gray-200 hover:bg-gray-300';
@endphp

<a {{$attributes->merge(['class' => $classes])}}>
    {{$slot}}
</a>
