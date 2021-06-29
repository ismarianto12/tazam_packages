<div class="card-header">{{ $title }}
	@can($routeName)
	<a class="offset-lg-4 btn btn-success" href="{{ route($routeName) }}">
		<i class="fa fa-plus-square fa-fw"></i> Add
	</a>
	@endcan
</div>

@include('dash::components.messages')