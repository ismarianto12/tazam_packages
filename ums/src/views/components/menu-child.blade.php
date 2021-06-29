<ul>
	@foreach($menus as $menu)
		@if($menu->link == '' || auth()->user()->can($menu->link))
		<li>
			<a href="{{ $menu->link !== '' ? route($menu->link) : '#' }}"><i class="metismenu-icon {{ $menu->icon }}"></i>{{ $menu->name }}
				@if(count($menu->childs))
					<i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
				@endif
			</a>
			@if(count($menu->childs))
				@include('dash::components.menu-child',['menus' => $menu->childs])
			@endif
		</li>
		@endif
	@endforeach
</ul>