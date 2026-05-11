@props(['active' => false])

<a {{ $attributes->class([
    'flex items-center p-3 border border-gray-300/50 rounded-xl hover:bg-blue-100 transition',
    'font-bold text-blue-600' => $active,
    'text-gray-700' => !$active,
]) }}>
    {{ $slot }}
</a>
