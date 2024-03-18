@props(['active'])

@php
$classes = ($active ?? false)
    ? 'inline-flex items-center px-4 pt-4 border-b-2 border-transparent text-sm font-medium leading-5 text-white focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out text-xl'
    : 'inline-flex items-center px-4 pt-4 border-b-2 border-transparent text-sm font-medium leading-5 text-white hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out text-xl';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
