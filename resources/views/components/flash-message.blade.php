@props([
    'type' => 'success',
    'message' => null,
])

@php
    $classes = match ($type) {
        'success' => 'bg-green-100 border-green-300 text-green-800',
        'warning' => 'bg-yellow-100 border-yellow-300 text-yellow-800',
        'danger', 'error' => 'bg-red-100 border-red-300 text-red-800',
        'info' => 'bg-blue-100 border-blue-300 text-blue-800',
        default => 'bg-gray-100 border-gray-300 text-gray-800',
    };
@endphp

@if ($message)
    <div {{ $attributes->merge(['class' => "border px-4 py-3 rounded {$classes}"]) }}>
        {{ $message }}
    </div>
@endif
