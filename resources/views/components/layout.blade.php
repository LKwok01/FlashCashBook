<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title : 'FlashCash' }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="flex min-h-screen">
    
    <aside class="bg-gray-200 p-4 w-[250px] m-0">
        <h2 class="text-xl font-bold mb-2">FlashCashBook</h2>
        <ul class="w-full">
            <x-nav-link href="/" :active="request()->routeIs('dashboard')">Dashboard</x-nav-link>
            <x-nav-link href="/daily" :active="request()->routeIs('daily')">Daily Activity</x-nav-link>
            <x-nav-link href="/inventory" :active="request()->routeIs('inventory')">Inventory</x-nav-link>
            <x-nav-link href="/cash" :active="request()->routeIs('cash')">Cash Management</x-nav-link>
            <x-nav-link href="/reports" :active="request()->routeIs('reports')">Reports</x-nav-link>
        </ul>
    </aside>
    <main class="flex-1 m-1">
    {{$slot}}
    </main>


</body>
</html>