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
							<input name="nik" id="nik" placeholder="Input NIK" type="text" class="form-control" value="{{ old('NIK', @$user->NIK) }}">
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
							<select name="unit" id="unit" class="form-control select2 unit">
								<option value="{{@$user->unit == '' ? '' : $user->unit}}">{{@$unit[0]->branch_name == "" ? "" : $unit[0]->branch_name}}</option>
							</select>
						</div>
					</div>
					<div class="position-relative row form-group"><label for="status" class="col-sm-2 col-form-label">Select Status</label>
						<div class="col-sm-10">
							<select name="status" id="status" class="form-control select2 status">
							<option value="{{@$user->status == '' ? '' : $user->status}}" >{{@$status[0]->status == '' ? '' : $status[0]->par_name}}</option>
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
			  <a href="#" class="btn btn-danger remove_field_button">Remove App</a>
			  <button class="btn btn-info" type="button" data-toggle="collapse" data-target=".multi-collapseall" aria-expanded="false" aria-controls="multiCollapseExample">show/hide All</button>
			</p>
			</div>
		
		</div>
            
			
		<div class="card">
			<div class="card-body">
				<div class="input_fields_wrap">
					@if(!empty($userApps[0]))
					<!-- {{$no = 1}} -->
					@foreach($userApps as $row)
				
					<div class="box">
					
						<div class="form-row">
							<div class="form-group">
								<label>&nbsp</label><br>
								<a href="#" class="btn btn-info add_field_button">{{@$no}}</a>
							</div>
							<div class="col">
								<div class="form-group">
									<label>Select Application</label>
									<div class="input-group">
										<select class="form-control select2 app{{@$no}} apps{{@$no}}" name="apps" id="inputGroupSelect04">
											<option value="{{@$row->app_id}}" {{ @!empty(@$row->app_id) ? 'selected' : '' }}>{{ @!empty(@$row->app_name) ? @$row->app_name : '' }}</option>
										</select>
										<div class="input-group-append">
											<button class="btn btn-primary" type="button" data-toggle="collapse" data-target=".multi-collapse{{@$no}}" aria-expanded="false" aria-controls="multiCollapseExample">show/hide</button>
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
						<div class="form-row collapse multi-collapse{{@$no}} multi-collapseall" id="multiCollapseExample">
							<div class="col-4">
							<div class="form-group addsuser">
							<label class="form-label" for="validationTextarea2">Additional field</label>
							</div>
							</div>
							<div class="col-8">
								<div class="form-row">
									<div class="col">
										<div class="form-group">
											<label>Select Role</label>
											<div class="input-group">
												<select class="form-control select2 roles{{@$no}}" multiple="" name="roles[]" style="width:100%!important">
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
												<select disabled class="form-control select2 permissions{{@$no}}" multiple="" name="roles[]" style="width:100%!important">
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
												<select class="form-control select2 permissionsadd{{@$no}}" multiple="" name="permissions[]" style="width:100%!important">
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
												<select class="form-control select2 unit{{@$no}}" multiple="" name="unit[]" style="width:100%!important">
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<br>
						
					</div>
					<!-- {{$no++}} -->
					@endforeach
					@endif
				</div>
			</div>
		</div>
		

		@if(empty($userApps[0]))
		<div class="box">
		
			<div class="form-row">
				<div class="form-group">
					<label>&nbsp</label><br>
					<a href="#" class="btn btn-info add_field_button">1</a>
				</div>
				<div class="col">
					<div class="form-group">
						<label>Select Application</label>
						<div class="input-group">
							<select class="form-control select2 app apps" name="apps" id="inputGroupSelect04">
							</select>
							<div class="input-group-append">
								<button class="btn btn-primary" type="button" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample">show/hide</button>
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
			<div class="form-row collapse multi-collapse multi-collapseall" id="multiCollapseExample">
				<div class="col-4">
				<div class="form-group addsuser">
				<label class="form-label" for="validationTextarea2">Additional field</label>
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
					<!-- <br> -->
					<!-- <button type="submit" class="btn btn-default btn-block">Submit data</button> -->
					<div class="form-row">
						<div class="col">
							<div class="form-group">
								<label>Select Branchs Access</label>
								<div class="input-group">
									<select class="form-control select2 unit" multiple="" name="unit[]" style="width:100%!important">
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<br>
			
		</div>
		@endif

		<div class="text-right">
			<button class="btn btn-primary">Submit</button>
		</div>

	</div>
</div>


@endsection

@section("foot")
<script type="text/javascript">
$(document).ready(function(){
    
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
				$('.roles').html(html).trigger("change");

			}
		});
		}
		return false;
	}); 

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

	$('.roles').change(function(){ 
		var app_id = $('.app').val();
		var role_id = $('.roles').val();
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
	
	@if(!empty($userApps[0]))
	<!-- {{$no = 1}} -->
	@foreach($userApps as $row)
	
	$('.app{{$no}}').change(function(){ 
		var app_id = $(this).val();
		var html_2 = '';
		
		if (app_id == ''){
			$(".roles{{$no}}").html(html_2).trigger("change");
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
				$('.roles{{$no}}').html(html);
				for(i=0; i<data.length; i++){
				html += '<option selected="selected" value='+data[i].role_id+'>'+data[i].name+'</option>';
				}
				$('.roles{{$no}}').html(html);

			}
		});
		}
		return false;
	}); 

	$('.roles{{$no}}').change(function(){ 
		var role_id = $(this).val();
		var app_id = $('.app{{$no}}').val();
				
		if (role_id == ''){
			$(".permissions{{$no}}").val(null).trigger("change");
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
				$('.permissions{{$no}}').html(html);

			}
		});
		}
		return false;
	});

	$('.roles{{$no}}').change(function(){ 
		var app_id = $('.app{{$no}}').val();
		var role_id = $('.roles{{$no}}').val();
		var html_2 = '';
		
		if (app_id == ''){
			$(".permissionsadd{{$no}}").html(html_2).trigger("change");
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
				$('.permissionsadd{{$no}}').html(html);
				for(i=0; i<data.length; i++){
				html += '<option selected="selected" value='+data[i].role_id+'>'+data[i].name+'</option>';
				}
				$('.permissionsadd{{$no}}').html(html);

			}
		});
		}
		return false;
	}); 

	$('.app{{$no}}').change(function(){ 
		var app_id = $(this).val();
		var html_2 = '';
		
		if (app_id == ''){
			$(".addsuser{{$no}}").html(html_2).trigger("change");
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
					$('.addsuser{{$no}}').html(html_2);
				}else{
					$('.addsuser{{$no}}').html(html);
					html += '<label class="form-label" for="validationTextarea2">Additional field</label>';
					for(i=0; i<data.length; i++){
					// html += '<option value='+data[i].role_id+'>'+data[i].name+'</option>';
					html += `<div class="form-group">
					<input name="" id="" placeholder="${data[i].label_name}" type="text" class="form-control">
					</div>
					`;
					}
					$('.addsuser{{$no}}').html(html);
				}
				

			}
		});
		}
		return false;
	}); 

	<!-- {{$no++}} -->
	@endforeach
	@endif

	
});
</script>

<script>
    $(document).ready(function()
    {
        $(function()
        {
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

			$(".unit").select2(
            {
                placeholder: "Select Unit",
                // minimumInputLength: 3,
                // maximumSelectionLength: 4,
                allowClear: true,
                ajax: {
                    url: "{{ route('ums.app.unit') }}",
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

			$(".status").select2(
			{
				placeholder: "Select Status",
				allowClear: true,
				ajax: {
					url: "{{ route('ums.app.status') }}",
					dataType: 'json',
					delay: 250,
					data: function(params) {
					return {
						q:params.term,
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
            
			
			@if(!empty($userApps[0]))
			<!-- {{$no = 1}} -->
			@foreach($userApps as $row)
			$(".apps{{$no}}").select2(
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

			$(".unit{{$no}}").select2(
            {
                placeholder: "Select Unit",
                // minimumInputLength: 3,
                // maximumSelectionLength: 4,
                allowClear: true,
                ajax: {
                    url: "{{ route('ums.app.unit') }}",
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

			$(".status{{$no}}").select2(
			{
				placeholder: "Select Status",
				allowClear: true,
				ajax: {
					url: "{{ route('ums.app.status') }}",
					dataType: 'json',
					delay: 250,
					data: function(params) {
					return {
						q:params.term,
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

			<!-- {{$no++}} -->
			@endforeach
			@endif

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
		var total_fields = wrapper[0].children.length + 1;
		if(total_fields < max_fields){
			$(wrapper).append(`
			<div class="box${total_fields}">
				<div class="form-row">
					<div class="form-group">
						<label>&nbsp</label><br>
						<a href="#" class="btn btn-info add_field_button">${total_fields}</a>
					</div>
					<div class="col">
						<div class="form-group">
							<label>Select Application</label>
							<div class="input-group">
								<select class="form-control select2 app${total_fields} apps${total_fields}" name="apps" id="inputGroupSelect04">
								</select>
								<div class="input-group-append">
									<button class="btn btn-primary" type="button" data-toggle="collapse" data-target=".multi-collapse${total_fields}" aria-expanded="false" aria-controls="multiCollapseExample">show/hide</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-row collapse multi-collapse${total_fields} multi-collapseall" id="multiCollapseExample">
					<div class="col-4">
					<div class="form-group addsuser${total_fields}">
					</div>
					</div>
					<div class="col-8">
						<div class="form-row">
							<div class="col">
								<div class="form-group">
									<label>Select Role</label>
									<div class="input-group">
										<select class="form-control select2 roles${total_fields}" multiple="" name="roles[]" style="width:100%!important">
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
										<select disabled class="form-control select2 permissions${total_fields}" multiple="" name="roles[]" style="width:100%!important">
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
										<select class="form-control select2 permissionsadd${total_fields}" multiple="" name="permissions[]" style="width:100%!important">
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="form-row">
							<div class="col">
								<div class="form-group">
									<label>Select Unit Access</label>
									<div class="input-group">
										<select class="form-control select2 unit${total_fields}" multiple="" name="unit[]" style="width:100%!important">
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<br>
			</div>
			`);

			var roles			= ".roles"+total_fields+"";
			var permissions		= ".permissions"+total_fields+"";
			var permissionsadd	= ".permissionsadd"+total_fields+"";
			var app				= ".app"+total_fields+"";
			var apps			= ".apps"+total_fields+"";
			var unit			= ".unit"+total_fields+"";
			var addsuser		= ".addsuser"+total_fields+"";
		
			$(apps).select2(
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

			$(unit).select2(
			{
				placeholder: "Select Unit",
				// minimumInputLength: 3,
				// maximumSelectionLength: 4,
				allowClear: true,
				ajax: {
					url: "{{ route('ums.app.unit') }}",
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

			$(roles).select2(
			{
				placeholder: "Select Role",
				// minimumInputLength: 3,
				// maximumSelectionLength: 4,
				allowClear: true,
			});

			$(permissions).select2(
			{
				placeholder: "Select Permission",
				// minimumInputLength: 3,
				// maximumSelectionLength: 4,
				allowClear: true,
			});

			$(permissionsadd).select2(
			{
				placeholder: "Select Permission",
				// minimumInputLength: 3,
				// maximumSelectionLength: 4,
				allowClear: true,
			});

			$(roles).change(function(){ 
				var role_id = $(this).val();
				var app_id = $(app).val();
						
				if (role_id == ''){
					$(permissions).val(null).trigger("change");
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
						$(permissions).html(html);

					}
				});
				}
				return false;
			});

			$(app).change(function(){ 
				var app_id = $(this).val();
				var html_2 = '';
				
				if (app_id == ''){
					$(roles).html(html_2).trigger("change");
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
						$(roles).html(html);
						for(i=0; i<data.length; i++){
						html += '<option value='+data[i].role_id+'>'+data[i].name+'</option>';
						}
						$(roles).html(html);

					}
				});
				}
				return false;
			}); 

			$(roles).change(function(){ 
				var app_id = $(app).val();
				var role_id = $(roles).val();
				var html_2 = '';
				
				if (app_id == ''){
					$(permissionsadd).html(html_2).trigger("change");
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
						$(permissionsadd).html(html);
						for(i=0; i<data.length; i++){
						html += '<option value='+data[i].role_id+'>'+data[i].name+'</option>';
						}
						$(permissionsadd).html(html);

					}
				});
				}
				return false;
			}); 

			$(app).change(function(){ 
				var app_id = $(this).val();
				var html_2 = '';
				
				if (app_id == ''){
					$(addsuser).html(html_2).trigger("change");
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
							$(addsuser).html(html_2);
						}else{
							$(addsuser).html(html);
							html += '<label class="form-label" for="validationTextarea2">Additional field</label>';
							for(i=0; i<data.length; i++){
							// html += '<option value='+data[i].role_id+'>'+data[i].name+'</option>';
							html += `<div class="form-group">
							<input name="" id="" placeholder="${data[i].label_name}" type="text" class="form-control">
							</div>
							`;
							}
							$(addsuser).html(html);
						}
						

					}
				});
				}
				return false;
			}); 
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