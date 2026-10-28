@if ($paginator->hasPages())
    <style>
        .custom-pagination-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 14px;
            margin: 40px auto 10px;
            width: 100%;
        }
        .custom-pagination-container .pagination-meta {
            color: #64748b;
            font-size: 0.92rem;
            text-align: center;
            letter-spacing: 0.2px;
            font-weight: 500;
        }
        .custom-pagination-container .pagination-meta .highlight {
            color: #0f172a;
            font-weight: 800;
        }
        .custom-pagination-container .pagination-list {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            list-style: none;
            padding: 0;
            margin: 0;
            flex-wrap: wrap;
        }
        .custom-pagination-container .page-item {
            margin: 0;
        }
        .custom-pagination-container .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-width: 42px;
            height: 42px;
            padding: 0 18px;
            border-radius: 9999px;
            font-size: 0.88rem;
            font-weight: 700;
            color: #334155;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
            user-select: none;
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
        }
        .custom-pagination-container .page-link:hover {
            color: #0f172a;
            background: #f8fafc;
            border-color: #94a3b8;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
        }
        .custom-pagination-container .page-item.active .page-link {
            background: #0f172a;
            color: #ffffff;
            border-color: #0f172a;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.22);
            font-weight: 800;
            transform: translateY(-1px);
        }
        .custom-pagination-container .page-item.disabled .page-link {
            background: #f1f5f9;
            color: #94a3b8;
            border-color: #e2e8f0;
            opacity: 0.7;
            cursor: not-allowed;
            pointer-events: none;
            box-shadow: none;
            transform: none !important;
        }
        .custom-pagination-container .page-link.dots {
            border: none;
            background: transparent;
            cursor: default;
            min-width: 24px;
            padding: 0 4px;
            color: #94a3b8;
            box-shadow: none;
        }
        .custom-pagination-container svg,
        nav[role="navigation"] svg {
            width: 16px !important;
            height: 16px !important;
            max-width: 16px !important;
            max-height: 16px !important;
            display: inline-block !important;
            vertical-align: middle !important;
            flex-shrink: 0;
        }
    </style>

    <nav role="navigation" aria-label="Pagination Navigation" class="custom-pagination-container">
        <div class="pagination-meta">
            Showing <span class="highlight">{{ $paginator->firstItem() }}</span> to <span class="highlight">{{ $paginator->lastItem() }}</span> of <span class="highlight">{{ $paginator->total() }}</span> results
        </div>

        <ul class="pagination-list">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                        <span>Prev</span>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="page-link" aria-label="@lang('pagination.previous')">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                        <span>Prev</span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link dots">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a href="{{ $url }}" class="page-link">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="page-link" aria-label="@lang('pagination.next')">
                        <span>Next</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">
                        <span>Next</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
