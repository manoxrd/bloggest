@if ($paginator->hasPages())
  <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}">

    <div class="sm:hidden"></div>

    <div class="sm:flex-1 sm:flex sm:gap-2 sm:items-center sm:justify-between flex flex-col items-center gap-4">

      <div>
        <p class="text-sm text-gray-700 leading-5 dark:text-gray-600">
          {!! __('Showing') !!}
          @if ($paginator->firstItem())
            <span class="font-medium">{{ $paginator->firstItem() }}</span>
            {!! __('to') !!}
            <span class="font-medium">{{ $paginator->lastItem() }}</span>
          @else
            {{ $paginator->count() }}
          @endif
          {!! __('of') !!}
          <span class="font-medium">{{ $paginator->total() }}</span>
          {!! __('results') !!}
        </p>
      </div>

      <div class="rounded-md overflow-hidden w-fit">
        <span class="inline-flex rtl:flex-row-reverse shadow-sm rounded-md">

          {{-- Pagination Elements (current page +/- 1) --}}
          @php
            $startPage = max(1, $paginator->currentPage() - 1);
            $endPage = min($paginator->lastPage(), $paginator->currentPage() + 1);
          @endphp

          @if ($startPage > 1)
            <a href="{{ $paginator->url(1) }}"
              class="inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 focus:outline-none focus:ring ring-gray-300 transition ease-in-out duration-150 dark:bg-secondary dark:border-secondary dark:text-primary"
              aria-label="{{ __('Go to page :page', ['page' => 1]) }}">
              1
            </a>

            @if ($startPage > 2)
              <span aria-disabled="true">
                <span
                  class="inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5 dark:bg-gray-100 dark:border-gray-600 dark:text-gray-300">...</span>
              </span>
            @endif
          @endif

          @for ($page = $startPage; $page <= $endPage; $page++)
            @if ($page === $paginator->currentPage())
              <span aria-current="page">
                <span
                  class="inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-gray-200 border border-gray-300 cursor-default leading-5 dark:bg-secondary dark:border-secondary dark:text-primary brightness-80">{{ $page }}</span>
              </span>
            @else
              <a href="{{ $paginator->url($page) }}"
                class="inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 focus:outline-none focus:ring transition ease-in-out duration-150 dark:bg-secondary dark:text-primary dark:border-secondary dark:active:bg-secondary"
                aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                {{ $page }}
              </a>
            @endif
          @endfor

          @if ($endPage < $paginator->lastPage())
            @if ($endPage < $paginator->lastPage() - 1)
              <span aria-disabled="true">
                <span
                  class="inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5 dark:bg-secondary dark:border-secondary dark:text-primary">...</span>
              </span>
            @endif

            <a href="{{ $paginator->url($paginator->lastPage()) }}"
              class="inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 focus:outline-none focus:ring ring-gray-300 transition ease-in-out duration-150 dark:bg-secondary dark:border-secondary dark:text-primary"
              aria-label="{{ __('Go to page :page', ['page' => $paginator->lastPage()]) }}">
              {{ $paginator->lastPage() }}
            </a>
          @endif

        </span>
      </div>
    </div>
  </nav>
@endif
