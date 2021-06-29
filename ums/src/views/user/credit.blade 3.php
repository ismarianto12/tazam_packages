@extends('dash::layouts.main', ['title'=>'User', 'routeName'=>"ums.user.create"])

@section('head')
<link rel="stylesheet" type="text/css" href="{{ pkg_asset('dash', 'dependencies/select2/select2.min.css') }}" />
<!-- <link rel="stylesheet" type="text/css" href="{{ pkg_asset('ums', 'dependencies/dual_listbox/bootstrap-duallistbox.css') }}"> -->
<!-- <script src="http://cia.test/theme/js_ext/jquery-2.1.1.min.js"></script> -->
<!-- <script src="http://cia.test/theme/js_ext/jquery-2.1.1.min.js"></script> -->
<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
<!-- <script src="{{ pkg_asset('ums', 'dependencies/dual_listbox/jquery.bootstrap-duallistbox.js') }}"></script> -->
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
							<select name="unit" id="unit" class="form-control select2">
								<option value="" selected>Choose...</option>
								@foreach($units as $unit)
								<option value="{{ $unit->branch_code }}">{{ $unit->branch_code }} - {{ $unit->branch_name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="position-relative row form-group"><label for="status" class="col-sm-2 col-form-label">Select Status</label>
						<div class="col-sm-10">
							<select name="status" id="status" class="form-control select2">
								<option value="1" {{ (old('status', @$user->status) == "1" ? "selected":"") }}>Active</option>
								<option value="0" {{ (old('status', @$user->status) == "0" ? "selected":"") }}>Inactive</option>
							</select>
						</div>
					</div>

					
					
					<!-- <div class="position-relative row form-check">
						<div class="col-sm-10 offset-sm-2">
							<button class="btn btn-info">Submit</button>
						</div>
					</div> -->
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col">
			<h2 class="section-title">User Access Applications</h2>
			<p class="section-lead">
			  You can provide user access on the card.
			  <a href="#" class="btn btn-success add_field_button">Add App</a>
			  <a href="#" class="btn btn-warning remove_field_button">Remove App</a>
			</p>
			</div>
		
		</div>
            
			
		<div class="input_fields_wrap">
		<div class="box">
			<div class="card">
				<div class="card-body">
				
					
						<div class="form-row">
							<div class="col">
								<div class="form-group">
									<label>Select Application</label>
									<div class="input-group">
										<select class="form-control select2 app" name="apps" id="inputGroupSelect04">
											<option value="" selected>Choose...</option>
											@foreach($apps as $app)
											<option value="{{ $app->app_id }}">{{ $app->app_name }}</option>
											@endforeach
										</select>
										<div class="input-group-append">
											<button class="btn btn-primary" type="button" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2">show/hide</button>
										</div>
										<!-- <div class="input-group-append">
											<button style="width:40px!important" id="add" class="btn btn-success add_field_button" type="button">+</button>
										</div> -->
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
							<div class="form-group addsuser">
							<!-- <label class="form-label" for="validationTextarea2">Additional field</label>
							@foreach($userAppsDataSchemes as $userAppsDataScheme)
								<div class="form-group">
									<label>kode marketing</label>
									<input name="{{ $userAppsDataScheme->field_name}}" id="" placeholder="{{$userAppsDataScheme->label_name}}" type="text" class="form-control">
								</div>
							@endforeach -->
							</div>
							</div>
							<div class="col-8">
								<div class="form-row">
									<div class="col">
										<div class="form-group">
											<label>Select Role</label>
											<div class="input-group">
												<select class="form-control select2 roles" multiple="" name="roles[]" style="width:100%!important">
													<!-- @foreach($roles as $role)
													<option value="{{ $role->role_id }}">{{ $role->name }}</option>
													@endforeach -->
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col">
									<div class="form-group">
											<label>detail permission</label>
											<div class="input-group">
												<select disabled class="form-control select2 permissions" multiple="" name="roles[]" style="width:100%!important">
													<!-- @foreach($permissions as $permission)
													<option value="{{ $permission->id }}">{{ $permission->name }}</option>
													@endforeach -->
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col">
									<div class="form-group">
											<label>additional permission</label>
											<div class="input-group">
												<select class="form-control select2 permissionsadd" multiple="" name="permissions[]" style="width:100%!important">
													<!-- @foreach($permissions as $permission)
													<option value="{{ $permission->id }}">{{ $permission->name }}</option>
													@endforeach -->
												</select>
											</div>
										</div>
									</div>
								</div>
								<!-- <br> -->
								<!-- <button type="submit" class="btn btn-default btn-block">Submit data</button> -->
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

		<div class="text-right">
			<button class="btn btn-primary">Submit</button>
		</div>

	</div>
</div>


@endsection

@section("foot")
<script type="text/javascript">
$(document).ready(function(){
    
	$('.roles').change(function(){ 
		var role_id = $(this).val();
		var app_id = $('.app').val();
				
		if (role_id == ''){
			$(".permissions").val(null).trigger("change");
		}else{

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			url:"{{ route('ums.role.permissions') }}",
			method : "GET",
			data : {
				"_token": "{{ csrf_token() }}",
				role_id: role_id,
				app_id: app_id
				},
			async : true,
			dataType : 'json',
			success: function(data){
				
				var html = '';
				var i;
				for(i=0; i<data.length; i++){
				html += '<option selected="selected" value='+data[i].permission_id+'>'+data[i].name+'</option>';
				}
				$('.permissions').html(html);

			}
		});
		}
		return false;
	});

	$('.app').change(function(){ 
		var app_id = $(this).val();
		var html_2 = '';
		
		if (app_id == ''){
			$(".roles").html(html_2).trigger("change");
		}else{

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			url:"{{ route('ums.app.roles') }}",
			method : "GET",
			data : {
				"_token": "{{ csrf_token() }}",
				app_id: app_id
				},
			async : true,
			dataType : 'json',
			success: function(data){
				
				var html = '';
				var i;
				$('.roles').html(html);
				for(i=0; i<data.length; i++){
				html += '<option value='+data[i].role_id+'>'+data[i].name+'</option>';
				}
				$('.roles').html(html);

			}
		});
		}
		return false;
	}); 

	$('.roles').change(function(){ 
		var app_id = $('.app').val();
		var role_id = $('.roles').val();
		console.log(role_id);
		console.log(app_id);
		var html_2 = '';
		
		if (app_id == ''){
			$(".permissionsadd").html(html_2).trigger("change");
		}else{

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			url:"{{ route('ums.app.permissions') }}",
			method : "GET",
			data : {
				"_token": "{{ csrf_token() }}",
				app_id: app_id,
				role_id: role_id
				},
			async : true,
			dataType : 'json',
			success: function(data){
				
				var html = '';
				var i;
				$('.permissionsadd').html(html);
				for(i=0; i<data.length; i++){
				html += '<option value='+data[i].role_id+'>'+data[i].name+'</option>';
				}
				$('.permissionsadd').html(html);

			}
		});
		}
		return false;
	}); 

	$('.app').change(function(){ 
		var app_id = $(this).val();
		var html_2 = '';
		
		if (app_id == ''){
			$(".addsuser").html(html_2).trigger("change");
		}else{

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			url:"{{ route('ums.app.additionals') }}",
			method : "GET",
			data : {
				"_token": "{{ csrf_token() }}",
				app_id: app_id
				},
			async : true,
			dataType : 'json',
			success: function(data){
				
				var html = '';
				var i;
				if (app_id == ''){
					var html_2 = '';
					$('.addsuser').html(html_2);
				}else{
					$('.addsuser').html(html);
					html += '<label class="form-label" for="validationTextarea2">Additional field</label>';
					for(i=0; i<data.length; i++){
					// html += '<option value='+data[i].role_id+'>'+data[i].name+'</option>';
					html += `<div class="form-group">
					<input name="" id="" placeholder="${data[i].label_name}" type="text" class="form-control">
					</div>
					`;
					}
					$('.addsuser').html(html);
				}
				

			}
		});
		}
		return false;
	}); 

	
});
</script>

<script>
    $(document).ready(function()
    {
        $(function()
        {
            $('.select2').select2();

            $(".apps").select2(
            {
                placeholder: "Select Apps",
                // minimumInputLength: 3,
                // maximumSelectionLength: 4,
                allowClear: true,
                ajax: {
                    url: "{{ route('ums.app.list') }}",
                    dataType: 'json',
                    delay: 250,
					data: function(params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
					},
					processResults: function(data, page) {
						return {
							results: data
						};
					},
                    
                    cache: true
                }
            });

        });
    });

</script>

<script>
	var max_fields      = 10;
	var wrapper         = $(".input_fields_wrap"); 
	var add_button      = $(".add_field_button");
	var remove_button   = $(".remove_field_button");

	$(add_button).click(function(e){
		e.preventDefault();
		var total_fields = wrapper[0].children.length;
		if(total_fields < max_fields){
			$(wrapper).append(`
			<div class="box${total_fields}">
			<div class="card">
				<div class="card-body">
				
					
						<div class="form-row">
							<div class="col">
								<div class="form-group">
									<label>Select Application</label>
									<div class="input-group">
										<select class="form-control select2 app" name="apps" id="inputGroupSelect04">
											<option value="" selected>Choose...</option>
											@foreach($apps as $app)
											<option value="{{ $app->app_id }}">{{ $app->app_name }}</option>
											@endforeach
										</select>
										<div class="input-group-append">
											<button class="btn btn-primary" type="button" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2">show/hide</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="form-row collapse multi-collapse" id="multiCollapseExample1">
							<div class="col-4">
							<div class="form-group addsuser">
							</div>
							</div>
							<div class="col-8">
								<div class="form-row">
									<div class="col">
										<div class="form-group">
											<label>Select Role</label>
											<div class="input-group">
												<select class="form-control select2 roles" multiple="" name="roles[]" style="width:100%!important">
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col">
									<div class="form-group">
											<label>detail permission</label>
											<div class="input-group">
												<select disabled class="form-control select2 permissions" multiple="" name="roles[]" style="width:100%!important">
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col">
									<div class="form-group">
											<label>additional permission</label>
											<div class="input-group">
												<select class="form-control select2 permissionsadd" multiple="" name="permissions[]" style="width:100%!important">
												</select>
											</div>
										</div>
									</div>
								</div>
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
		`);
		}
	});
	
	$(remove_button).click(function(e){
		e.preventDefault();
		var total_fields = wrapper[0].children.length;
		if(total_fields>1){
			wrapper[0].children[total_fields-1].remove();
		}
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