@extends('dash::layouts.main', ['title'=>'User', 'routeName'=>"dash.user.create"])

@section('head')
@endsection

@section("content")
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				@include('dash::components.messages')
				<form action="{{ isset($user) ? route('dash.user.update', @$user->id) : route('dash.user.store') }}" method="POST">
					@csrf
					{{ isset($user) ? method_field('PATCH') : "" }}
					<div class="position-relative row form-group">
						<label for="name" class="col-sm-2 col-form-label">Full Name</label>
						<div class="col-sm-10">
							<input name="name" id="name" placeholder="Input Full Name" type="text" class="form-control" value="{{ old('name', @$user->name) }}">
						</div>
					</div>
					<div class="position-relative row form-group">
						<label for="username" class="col-sm-2 col-form-label">Username</label>
						<div class="col-sm-10">
							<input name="username" id="username" placeholder="Input username" type="text" class="form-control" value="{{ old('username', @$user->username) }}">
						</div>
					</div>
					<div class="position-relative row form-group">
						<label for="email" class="col-sm-2 col-form-label">Email</label>
						<div class="col-sm-10">
							<input name="email" id="email" placeholder="Input Email" type="email" class="form-control" value="{{ old('email', @$user->email) }}">
						</div>
					</div>
					<div class="position-relative row form-group">
						<label for="password" class="col-sm-2 col-form-label">Password</label>
						<div class="col-sm-10">
							<input name="password" id="password" placeholder="Input Password" type="password" class="form-control">
						</div>
					</div>
					<div class="position-relative row form-group">
						<label for="password_confirmation" class="col-sm-2 col-form-label">Password Confirmation</label>
						<div class="col-sm-10">
							<input name="password_confirmation" id="password_confirmation" placeholder="Input Password Confirmation" type="password" class="form-control">
						</div>
					</div>
					<div class="position-relative row form-group"><label for="status" class="col-sm-2 col-form-label">Select Status</label>
						<div class="col-sm-10">
							<select name="status" id="status" class="form-control">
								<option value="1" {{ (old('status', @$user->status) == "1" ? "selected":"") }}>Active</option>
								<option value="0" {{ (old('status', @$user->status) == "0" ? "selected":"") }}>Inactive</option>
							</select>
						</div>
					</div>
					<div class="position-relative row form-group">
						<label for="exampleSelect" class="col-sm-2 col-form-label">Select Role</label>

						<div class="col-sm-10">
							<div class="position-relative form-group">
								<div>
									@foreach($roles as $role)
									<div class="custom-checkbox custom-control">
										<input type="checkbox" id="{{ $role->name }}" name="roles[]" class="custom-control-input" value="{{ $role->id }}" @if(old('roles')) @foreach(old('roles') as $oldRole) @if($oldRole==$role->id)
										checked
										@endif
										@endforeach
										@endif
										@if(@$user->roles)
										@foreach($user->roles as $oldRole)
										@if($oldRole->id == $role->id)
										checked
										@endif
										@endforeach
										@endif
										>

										<label class="custom-control-label" for="{{ $role->name }}">{{ $role->name }}</label>

									</div>
									@endforeach
								</div>
							</div>
						</div>


					</div>
					<div class="position-relative row form-check">
						<div class="col-sm-10 offset-sm-2">
							<button class="btn btn-secondary">Submit</button>
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