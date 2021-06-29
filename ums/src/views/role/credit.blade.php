@extends('dash::layouts.main', ['title'=>'Role'])

@section('head')
@endsection

@section("content")
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<form action="{{ isset($role) ? route('ums.app.update_role') : route('ums.app.store_role') }}" role="form" method="post">
					@csrf
					<!-- {{ isset($permission) ? method_field('PATCH') : "" }} -->
					@include('dash::components.messages')
					<div class="position-relative row form-group"><label for="name" class="col-sm-2 col-form-label">Role Name</label>
						<div class="col-sm-10">
							<input maxlength="250" name="name" id="name" placeholder="Input Name" type="text" class="form-control" value="{{ @$role->name }}">
							<input hidden name="app_id" id="app_id" placeholder="Input App ID" type="text" class="form-control" value="{{ @$app_id }}">
							<input hidden name="id" id="id" placeholder="Input ID" type="text" class="form-control" value="{{ @$role->id }}">
						</div>
					</div>
					<div class="position-relative row form-group"><label for="guard_name" class="col-sm-2 col-form-label">Guard Name</label>
						<div class="col-sm-10">
							<input maxlength="250" name="guard_name" id="guard_name" placeholder="Input Role ID" type="text" class="form-control" value="{{ @$role->guard_name }}">
						</div>
					</div>
					<div class="position-relative row form-group"><label for="role_id" class="col-sm-2 col-form-label">Role ID</label>
						<div class="col-sm-10">
							<input maxlength="250" name="role_id" id="role_id" placeholder="Input Role ID" type="text" class="form-control" value="{{ @$role->role_id }}">
						</div>
					</div>
					<div class="position-relative row form-group"><label for="hierarcy_id" class="col-sm-2 col-form-label">Hierarcy ID</label>
						<div class="col-sm-10">
							<input maxlength="250" name="hierarcy_id" id="hierarcy_id" placeholder="Input Hierarcy ID" type="text" class="form-control" value="{{ @$role->hierarcy_id }}">
						</div>
					</div>
					<div class="position-relative row form-group">
						<label for="exampleSelect" class="col-sm-2 col-form-label">Select</label>
						<div class="col-sm-10">
							<select name="status" id="for" class="form-control">
								<option value="1" {{ @$role->status == '1' || @$role->status == '' ? 'selected="selected"' : '' }}>Active</option>
								<option value="0">Inactive</option>
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
										<input type="checkbox" id="{{ @$permission->name }}" name="permissions[]" class="custom-control-input" value="{{ @$permission->permission_id }}" @if(@$role_permit != '') {{ in_array($permission->permission_id, $role_permit, false) ? "checked" : "" }} @endif>
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
							<a class="btn btn-warning" href="{{ route('ums.role.index') }}">Back</a>
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