@props(['currentPage', 'totalPages', 'query'])

@if ($totalPages > 1)
    <div class="flex justify-center gap-2 my-8">
        {{-- Previous Page --}}
        <a href="{{ route('search', ['query' => $query, 'page' => max(1, $currentPage - 1)]) }}"
            class="px-4 py-2 bg-gray-200 rounded-lg {{ $currentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-300' }}">
            ←
        </a>

        {{-- Page Numbers --}}
        @for ($i = max(1, $currentPage - 2); $i <= min($currentPage + 2, $totalPages); $i++)
            <a href="{{ route('search', ['query' => $query, 'page' => $i]) }}"
                class="px-4 py-2 rounded-lg {{ $i === $currentPage ? 'bg-blue-500 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
                {{ $i }}
            </a>
        @endfor

        {{-- Next Page --}}
        <a href="{{ route('search', ['query' => $query, 'page' => min($totalPages, $currentPage + 1)]) }}"
            class="px-4 py-2 bg-gray-200 rounded-lg {{ $currentPage === $totalPages ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-300' }}">
            →
        </a>
    </div>
@endif
