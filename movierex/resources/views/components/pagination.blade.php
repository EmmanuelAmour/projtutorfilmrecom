@props(['currentPage', 'totalPages'])

@php
    $route = Route::current(); // Current route
    $routeName = $route->getName(); // Current route name
    $routeParams = $route->parameters(); // Get required route params like ['genre' => 'action']
    $queryParams = request()->query(); // Get query string params like ['sort' => 'latest']
@endphp

@if ($totalPages > 1)
    <div class="flex justify-center gap-2 my-8">
        {{-- Previous Page --}}
        <a href="{{ route($routeName, array_merge($routeParams, ['page' => max(1, $currentPage - 1)] + $queryParams)) }}"
            class="px-4 py-2 bg-gray-200 rounded-lg {{ $currentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-300' }}">
            ←
        </a>

        {{-- Page Numbers --}}
        @for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++)
            <a href="{{ route($routeName, array_merge($routeParams, ['page' => $i] + $queryParams)) }}"
                class="px-4 py-2 rounded-lg {{ $i === $currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
                {{ $i }}
            </a>
        @endfor

        {{-- Next Page --}}
        <a href="{{ route($routeName, array_merge($routeParams, ['page' => min($totalPages, $currentPage + 1)] + $queryParams)) }}"
            class="px-4 py-2 bg-gray-200 rounded-lg {{ $currentPage === $totalPages ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-300' }}">
            →
        </a>
    </div>
@endif
