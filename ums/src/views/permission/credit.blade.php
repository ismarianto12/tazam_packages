@extends('dash::layouts.main', ['title'=>'Permission', 'routeName'=>""])

@section('head')
@endsection

@section("content")
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				@include('dash::components.messages')
				<form action="{{ isset($permission) ? route('ums.app.update_permission') : route('ums.app.store_permission') }}" method="POST">
					@csrf
					<!-- {{ isset($permission) ? method_field('PATCH') : "" }} -->
					<div class="position-relative row form-group">
						<label for="name" class="col-sm-2 col-form-label">Name</label>
						<div class="col-sm-10">
							<input maxlength="250" name="name" id="name" placeholder="Input permission name" type="text" class="form-control" value="{{ old('name', @$permission->name) }}">
							<input hidden name="app_id" id="app_id" placeholder="Input permission app_id" type="text" class="form-control" value="{{ old('app_id', @$app_id) }}">
							<input hidden name="id" id="app_id" placeholder="Input id" type="text" class="form-control" value="{{ old('id', @$permission->id) }}">
						</div>
					</div>
					<div class="position-relative row form-group">
						<label for="guard_name" class="col-sm-2 col-form-label">Guard Name</label>
						<div class="col-sm-10">
							<input maxlength="250" name="guard_name" id="guard_name" placeholder="Input Guard Name" type="text" class="form-control" value="{{ old('guard_name', @$permission->guard_name) }}">
						</div>
					</div>
					<div class="position-relative row form-group">
						<label for="permission_id" class="col-sm-2 col-form-label">Permission ID</label>
						<div class="col-sm-10">
							<input maxlength="250" name="permission_id" id="permission_id" placeholder="Input permission ID" type="text" class="form-control" value="{{ old('permission_id', @$permission->permission_id) }}">
						</div>
					</div>
					<div class="position-relative row form-group"><label for="status" class="col-sm-2 col-form-label">Select Status</label>
						<div class="col-sm-10">
							<select name="status" id="status" class="form-control">
								<option value="1" {{ (old('status', @$permission->status) == "1" ? "selected":"") }}>Active</option>
								<option value="0" {{ (old('status', @$permission->status) == "0" ? "selected":"") }}>Inactive</option>
							</select>
						</div>
					</div>

					
					
					<div class="position-relative row form-check">
						<div class="col-sm-10 offset-sm-2">
							<button class="btn btn-info">Submit</button>
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