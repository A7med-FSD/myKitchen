@props(['active' => false])

@php
    $classes = "flex items-center gap-3 px-5 py-3 transition-colors";
    $classes .= $active ? ' bg-zinc-200 text-zinc-500 border-r-4 border-zinc-500' : ' text-zinc-700 hover:bg-gray-200';
@endphp

<a {{$attributes->merge(['class' => $classes])}}>
    {{$slot}}
</a>
