<ul class="list-unstyled navbar__list">
	<li>
        <a class="active" href="{{ route('dashboard') }}">
            <i class="ion-ios-gear-outline"></i>Dashboard
        </a>
    </li>
	@foreach ($navbars as $items)
		@if (count($items->Detail) > 0)
			<li class="has-sub">
				<a class="js-arrow" href="#">
                    <i class="ion-social-buffer-outline"></i>$items->PermissionName
                </a>

                <ul class="list-unstyled navbar__sub-list js-sub-list">
                	@foreach ($items->Detail as $itemdetails)
                		<li>
                            <a href="{{route($itemdetails->Link)}}">Active</a>
                        </li>
                	@endforeach
                </ul>
			</li>
		@else
			<li>
	            <a href="{{route($itemdetails->Link)}}">
	                <i class="$itemdetails->Icon"></i>$itemdetails->Link</a>
	        </li>
		@endif

	@endforeach
</ul>