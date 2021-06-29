@extends('dash::layouts.main', ['title'=>'Role'])

@section('head')
@endsection

@section("content")
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<form action="{{ isset($role) ? route('dash.role.update', @$role->id) : route('dash.role.store') }}" role="form" method="post">
					@csrf
					{{ isset($role) ? method_field('PATCH') : "" }}

					@include('dash::components.messages')

					<div class="position-relative row form-group"><label for="name" class="col-sm-2 col-form-label">Role Name</label>
						<div class="col-sm-10"><input name="name" id="name" placeholder="Input Name" type="text" class="form-control" value="{{ @$role->name }}"></div>
					</div>
					<div class="position-relative row form-group">
						<label for="exampleSelect" class="col-sm-2 col-form-label">Select</label>
						<div class="col-sm-10">
							<select name="status" id="for" class="form-control">
								<option value="1">Active</option>
								<option value="0" {{ @$role->status == 0 ? 'selected="selected"' : '' }}>Inactive</option>
							</select>
						</div>
					</div>
					<div class="position-relative row form-group">
						<label for="exampleSelect" class="col-sm-2 col-form-label">Select</label>

						<div class="col-sm-10">
							<div class="position-relative form-group">
								<div>
									@foreach($permissions as $permission)
									<div class="custom-checkbox custom-control">
										<input type="checkbox" id="{{ @$permission->name }}" name="permissions[]" class="custom-control-input" value="{{ @$permission->id }}" @if(@$role_permit) {{ in_array($permission->id, $role_permit, false) ? "checked" : "" }} @endif>
										<label class="custom-control-label" for="{{ @$permission->name }}">{{ @$permission->name }}</label>
									</div>
									@endforeach
								</div>
							</div>
						</div>


					</div>
					<div class="position-relative row form-check">
						<div class="col-sm-10 offset-sm-2">
							<button type="submit" class="btn btn-secondary">Submit</button>
							<a class="btn btn-warning" href="{{ route('dash.role.index') }}">Back</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


@endsection

@section("foot")

@endsection