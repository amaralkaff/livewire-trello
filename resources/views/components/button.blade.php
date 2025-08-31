@props(['variant' => 'primary', 'type' => 'submit'])

@php
$baseClasses = 'inline-flex items-center px-4 py-2 border rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none transition ease-in-out duration-150';

$variants = [
    'primary' => 'bg-gray-800 border-transparent text-white hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2',
    'secondary' => 'bg-white border-gray-300 text-gray-700 shadow-sm hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25',
    'danger' => 'bg-red-600 border-transparent text-white hover:bg-red-500 active:bg-red-700 focus:ring-2 focus:ring-red-500 focus:ring-offset-2'
];

$classes = $baseClasses . ' ' . $variants[$variant];
@endphp

<button {{ $attributes->merge(['type' => $type, 'class' => $classes]) }}>
    {{ $slot }}
</button>