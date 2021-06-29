@extends('dash::layouts.main', ['title'=>'User', 'routeName'=>"ums.user.create"])

@section('head')
<link rel="stylesheet" type="text/css" href="{{ pkg_asset('dash', 'dependencies/select2/select2.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ pkg_asset('ums', 'dependencies/dual_listbox/bootstrap-duallistbox.css') }}">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="{{ pkg_asset('ums', 'dependencies/dual_listbox/jquery.bootstrap-duallistbox.js') }}"></script>
@endsection

@section("content")
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				@include('dash::components.messages')
				<form action="{{ isset($user) ? route('ums.user.update', @$user->id) : route('ums.user.store') }}" method="POST">
					@csrf
					{{ isset($user) ? method_field('PATCH') : "" }}
					<div class="position-relative row form-group">
						<label for="nik" class="col-sm-2 col-form-label">NIK</label>
						<div class="col-sm-10">
							<input name="nik" id="nik" placeholder="Input NIK" type="text" class="form-control" value="{{ old('nik', @$user->nik) }}">
						</div>
					</div>
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
					<div class="position-relative row form-group"><label for="unit" class="col-sm-2 col-form-label">Select Unit</label>
						<div class="col-sm-10">
							<select name="unit" id="unit" class="form-control">
								<option value="" selected>Choose...</option>
								@foreach($units as $unit)
								<option value="{{ $unit->branch_code }}">{{ $unit->branch_code }} - {{ $unit->branch_name }}</option>
								@endforeach
							</select>
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

					
					
					<div class="position-relative row form-check">
						<div class="col-sm-10 offset-sm-2">
							<button class="btn btn-info">Submit</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<h2 class="section-title">User Access Applications</h2>
            <p class="section-lead">
              You can provide user access on the card.
			</p>
			
			<div class="card">
				<div class="card-body">
				
					<div id="box">
						<div class="form-row">
							<div class="col">
								<div class="form-group">
									<label>Select Application</label>
									<div class="input-group">
										<select class="form-control select2" name="apps[]" id="inputGroupSelect04">
											<option value="" selected>Choose...</option>
											@foreach($apps as $app)
											<option value="{{ $app->app_id }}">{{ $app->app_name }}</option>
											@endforeach
										</select>
										<div class="input-group-append">
											<button class="btn btn-primary" type="button" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2">show/hide</button>
										</div>
										<div class="input-group-append">
											<button style="width:40px!important" class="btn btn-success" type="button">+</button>
										</div>
									</div>
								</div>
							</div>
							<!-- <div class="">
								<label class="form-label" for="validationTextarea2">&nbsp</label>
								<br>
								<span><a href="#nama_item" id="" class="btn btn-info">+</a></span>
							</div> -->
						</div>
						<div class="form-row collapse multi-collapse" id="multiCollapseExample1">
							<div class="col-4">
							<div class="form-group">
							<label class="form-label" for="validationTextarea2">Additional field</label>
							@foreach($userAppsDataSchemes as $userAppsDataScheme)
								<div class="form-group">
									<!-- <label>kode marketing</label> -->
									<input name="{{ $userAppsDataScheme->field_name}}" id="" placeholder="{{$userAppsDataScheme->label_name}}" type="text" class="form-control">
								</div>
							@endforeach
							</div>
							</div>
							<div class="col-8">
								<div class="form-row">
									<div class="col">
										<div class="form-group">
											<label>Select Role</label>
											<div class="input-group">
												<select class="form-control select2 roles" multiple="" name="roles[]" style="width:100%!important">
													@foreach($roles as $role)
													<option value="{{ $role->role_id }}">{{ $role->name }}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col">
										<div class="form-group">
										<label>Select Permissions</label>
										<div class="input-group">
										<select class="permissions" multiple="multiple" size="10" name="duallistbox_demo1[]" title="duallistbox_demo1[]">
											@foreach($permissions as $permission)
											<option selected="selected" value="{{ $permission->id }}">{{ $permission->name }}</option>
											@endforeach
										</select>
										</div>
										</div>
									</div>
								</div>
								<!-- <br> -->
								<!-- <button type="submit" class="btn btn-default btn-block">Submit data</button> -->
								<script>
								var demo1 = $('.permissions').bootstrapDualListbox();
								$("#demoform").submit(function() {
									alert($('.permissions"]').val());
									return false;
								});
								</script>
								<div class="form-row">
									<div class="col">
										<div class="form-group">
											<label>Select Branchs Access</label>
											<div class="input-group">
												<select class="form-control select2" multiple="" name="unit[]" style="width:100%!important">
													@foreach($units as $unit)
													<option value="{{ $unit->branch_code }}">{{ $unit->branch_code }} - {{ $unit->branch_name }}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<br>
					</div>
					
				</div>
			</div>

            
	</div>
</div>


@endsection

@section("foot")
<script type="text/javascript">
$(document).ready(function(){
    
	$('.roles').change(function(){ 
		var role_id=$(this).val();
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			url:"{{ route('ums.role.permissions') }}", // if you say $(this) here it will refer to the ajax call not $('.roles')
			method : "GET",
			data : {
				"_token": "{{ csrf_token() }}",
				role_id: role_id
				},
			async : true,
			dataType : 'json',
			success: function(data){
				// console.log(data);
				
				var html = '';
				var i;
				for(i=0; i<data.length; i++){
					html += '<option selected="selected" data-sortindex="'+[i]+'" value='+data[i].permission_id+'>'+data[i].name+'</option>';
				}
				$('.permissions').html(html);
			}
		});
		return false;
	}); 

});
</script>

<!-- <script>
	var $roles = $('.roles');
	var $permissions = $(".permissions");

	$roles.select2().on('change', function() {
		$.ajax({
			url:"../api/locations/" + $roles.val(), // if you say $(this) here it will refer to the ajax call not $('.roles')
			type:'GET',
			success:function(data) {
				$permissions.empty();
				$.each(data, function(value, key) {
					$permissions.append($("<option></option>").attr("value", value).text(key)); // name refers to the objects value when you do you ->lists('name', 'id') in laravel
				});
				$permissions.select2(); //reload the list and select the first option
			}
		});
	}).trigger('change');
</script> -->
<script src="{{ pkg_asset('dash', 'dependencies/select2/select2.full.min.js') }}"></script>
@endsection