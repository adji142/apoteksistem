@if ($paginator->hasPages())
    <div class="post-nav nav-res pad-top-10">
        <div class="row">
            <div class="col-md-8 offset-md-2  col-xs-12 ">
                <div class="page-num text-center">
                    <ul>
                        {{-- Previous Page Link --}}
                        @if (!$paginator->onFirstPage())
                            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><i class="ion-ios-arrow-left"></i></a></li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $paginator->currentPage())
                                        <li class="active"><a href="#">{{ $page }}</a></li>
                                    @else
                                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach
                            @endif
                        
                        @endforeach
                        
                        {{-- Next Page Link --}}
                        @if ($paginator->hasMorePages())
                            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><i class="ion-ios-arrow-right"></i></a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
