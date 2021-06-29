@extends('dash::layouts.main', ['title'=>'Apps User Access', 'routeName'=>""])

@section('head')
<link rel="stylesheet" type="text/css" href="{{ pkg_asset('dash', 'dependencies/select2/select2.min.css') }}" />
@endsection

@section("content")
<div class="row">
	<div class="col-md-12">

		<form action="{{ empty($app[0]) ? route('ums.access.store') : route('ums.access.update', @$user->id) }}" method="POST">
		@csrf
		<input name="user_id" hidden value="{{ @$user->id}}">
		<div class="card">
			<div class="card-body">
				<div class=row>
					<div class=col>
						<div class="position-relative row form-group">
							<label for="nik" class="col-sm-4 col-form-label">NIK</label>
							<div class="col-sm-8">
								<input disabled id="nik"  type="text" class="form-control" value="{{ @$user->NIK }}">
							</div>
						</div>
						<div class="position-relative row form-group">
							<label for="name" class="col-sm-4 col-form-label">Full Name</label>
							<div class="col-sm-8">
								<input disabled id="name" type="text" class="form-control" value="{{ @$user->name }}">
							</div>
						</div>
						<div class="position-relative row form-group">
							<label for="email" class="col-sm-4 col-form-label">Email</label>
							<div class="col-sm-8">
								<input disabled id="email"  type="email" class="form-control" value="{{ @$user->email }}">
							</div>
						</div>
					</div>
					<div class=col>
						<div class="position-relative row form-group">
							<label for="nik" class="col-sm-4 col-form-label">Username</label>
							<div class="col-sm-8">
								<input disabled id="nik"  type="text" class="form-control" value="{{ @$user->username }}">
							</div>
						</div>
						<div class="position-relative row form-group">
							<label for="name" class="col-sm-4 col-form-label">Contact Number</label>
							<div class="col-sm-8">
								<input disabled id="phone" type="text" class="form-control" value="{{ @$user->phone }}">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="card">
			<div class="card-body">
				<div class="input_fields_wrap">
					<div class="box">
			
						<div class="form-row">
							<div class="col">
								<div class="form-group">
									<label>Select Application</label>
									<div class="input-group">
										<select required="required" class="form-control select2 app apps" name="app_id" id="inputGroupSelect04">
										@if(!empty($app))
											@foreach ($app as $row)
											<option value="{{ empty($row->id) ? '' : $row->id }}" {{ empty($row->id) ? '' : 'selected' }}>{{ empty($row->app_name) ? '' : $row->app_name }}</option>
											@endforeach
										@endif
										</select>
										<!-- <div class="input-group-append">
											<button class="btn btn-primary" type="button" data-toggle="collapse" data-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample">show/hide</button>
										</div> -->
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
						<div class="form-row">
							<div class="col-4">
							<div class="form-group addsuser">
							<label class="form-label" for="validationTextarea2">Additional field</label>
								@if(!empty($userschema))
									@foreach($userschema as $row)
									<input maxlength="{{ $row->length }}" placeholder="{{ $row->label_name }}" type="{{ $row->type_input }}" {{ $row->attribute }} {{ $row->mandatory }} name="value[{{ $row->field_name }}]" value="{{ $row->value }}" {{ $row->mandatory }} id="" class="form-control">
									@endforeach
								@endif
							</div>
							</div>
							<div class="col-8">
								<div class="form-row">
									<div class="col">
										<div class="form-group">
											<label>Select Role</label>
											<div class="input-group">
												<select required="required" class="form-control select2 role roles" multiple="" name="role_id[]" style="width:100%!important">
												@if(!empty($roles))
													@foreach ($roles as $row)
													{{ $rolee[] = $row['role_id'] }}
													<option value="{{ empty($row->role_id) ? '' : $row->role_id }}" {{ empty($row->role_id) ? '' : 'selected' }}>{{ empty($row->role_name) ? '' : $row->role_name }}</option>
													@endforeach
												@endif
												{{ $role_array = !empty($roles) ? implode(',',$rolee) : '0'}}
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
												<select disabled class="form-control select2 permissions" multiple="" name="" style="width:100%!important">
												@if($permissions)
													@foreach ($permissions as $row)
													<option value="{{ empty($row->permission_id) ? '' : $row->permission_id }}" {{ empty($row->permission_id) ? '' : 'selected' }}>{{ empty($row->permission_name) ? '' : $row->permission_name }}</option>
													@endforeach
												@endif
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
												<select class="form-control select2 permission permissionsadd" multiple="" name="permission_id[]" style="width:100%!important">
												@if($permissionAdd != null)
													@foreach ($permissionAdd as $row)
													{{ @$permissionss[] = $row['role_id'] }}
													<option value="{{ empty($row->permission_id) ? '' : $row->permission_id }}" {{ empty($row->permission_id) ? '' : 'selected' }}>{{ empty($row->name) ? '' : $row->name }}</option>
													@endforeach
												@endif
												{{ @$permission_array = @$permissionAdd == null ? '0' : implode(',',$permissionss)}}
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
												<select required class="form-control select2 unit" multiple="" name="branch_id[]" style="width:100%!important">
												@if(!empty($branches))
													@foreach ($branches as $row)
													<option value="{{ empty($row->branch_code) ? '' : $row->branch_code }}" {{ empty($row->branch_code) ? '' : 'selected' }}>{{ empty($row->branch_name) ? '' : $row->branch_name }}</option>
													@endforeach
												@endif
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<br>
						
					</div>
					
					<div class="text-right">
						<button class="btn btn-primary">Submit</button>
					</div>
				</div>
			</div>
		</div>
		</form>
		
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
				$('.unit').html(html);
				for(i=0; i<data.length; i++){
				html += '<option value='+data[i].role_id+'>'+data[i].name+'</option>';
				}
				$('.roles').html(html).trigger("change");
				$('.roles').removeClass("role").select2();
				$('.roles').removeClass("permission").select2();

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
				html += '<option value='+data[i].permission_id+'>'+data[i].name+'</option>';
				}
				$('.permissionsadd').html(html);
				$('.permissionsadd').removeClass("permission").select2();

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
					<input placeholder="${data[i].label_name}" type="${data[i].type_input}" ${data[i].attribute} name="value[${data[i].field_name}]" value="${data[i].default_value}" ${data[i].mandatory} id="" placeholder="${data[i].label_name}" class="form-control">
					</div>
					`;
					}
					$('.addsuser').html(html);
					$('.permissionsadd').removeClass("permission").select2();
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
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: function(params) {
                    return {
						"_token": "{{ csrf_token() }}",
						"user_id": {{@$user->id}},
						"app_id": {{@$app[0]->id == '' ? 0 : $app[0]->id}},
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

			$(".role").select2(
            {
                placeholder: "Select Role",
                // minimumInputLength: 3,
                // maximumSelectionLength: 4,
                allowClear: true,
                ajax: {
                    url: "{{ route('ums.access.roles') }}",
                    dataType: 'json',
                    delay: 250,
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: function(params) {
                    return {
						"_token": "{{ csrf_token() }}",
						q: params.term,
						app_id: {{empty($app[0]) ? "0" : $app[0]->id }},
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
			
			$(".permission").select2(
            {
                placeholder: "Select Permission",
                // minimumInputLength: 3,
                // maximumSelectionLength: 4,
                allowClear: true,
                ajax: {
                    url: "{{ route('ums.access.permissions') }}",
                    dataType: 'json',
                    delay: 250,
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: function(params) {
                    return {
						"_token": "{{ csrf_token() }}",
						q: params.term,
						app_id: {{empty($app[0]) ? "0" : $app[0]->id }},
						role_id: [{{$role_array}}],
						permission_id: [{{$permission_array}}],
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
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: function(params) {
                    return {
						"_token": "{{ csrf_token() }}",
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
				// minimumInputLength: 3,
                // maximumSelectionLength: 4,
				allowClear: true,
				ajax: {
					url: "{{ route('ums.app.status') }}",
					dataType: 'json',
					delay: 250,
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					data: function(params) {
					return {
						"_token": "{{ csrf_token() }}",
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
            
		});
    });

</script>

<script src="{{ pkg_asset('dash', 'dependencies/select2/select2.full.min.js') }}"></script>
@endsection