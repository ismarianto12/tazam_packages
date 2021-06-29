{{$route = !empty($user) ? 'ums.user.create' : ''}}
@extends('dash::layouts.main', ['title'=>'User', 'routeName'=>"$route"])

@section('head')
<link rel="stylesheet" type="text/css" href="{{ pkg_asset('dash', 'dependencies/select2/select2.min.css') }}" />
@include('dash::components.css-datatables')
@endsection

@section("content")
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<form action="{{ isset($user) ? route('ums.user.update', @$user->id) : route('ums.user.store') }}" method="POST">
					@csrf
					{{ isset($user) ? method_field('PATCH') : "" }}
					<div class="position-relative row form-group">
						<label for="nik" class="col-sm-2 col-form-label">NIK</label>
						<div class="col-sm-10">
							<input maxlength="6" name="NIK" id="NIK" placeholder="Input NIK" type="text" class="form-control" value="{{ old('NIK', @$user->NIK) }}">
						</div>
					</div>
					<div class="position-relative row form-group">
						<label for="name" class="col-sm-2 col-form-label">Full Name</label>
						<div class="col-sm-10">
							<input maxlength="30" name="name" id="name" placeholder="Input Full Name" type="text" class="form-control" value="{{ old('name', @$user->name) }}">
						</div>
					</div>
					<div class="position-relative row form-group">
						<label for="username" class="col-sm-2 col-form-label">Username</label>
						<div class="col-sm-10">
							<input maxlength="30" name="username" id="username" placeholder="Input username" type="text" class="form-control" value="{{ old('username', @$user->username) }}">
						</div>
					</div>
					<div class="position-relative row form-group">
						<label for="email" class="col-sm-2 col-form-label">Email</label>
						<div class="col-sm-10">
							<input maxlength="50" name="email" id="email" placeholder="Input Email" type="email" class="form-control" value="{{ old('email', @$user->email) }}">
						</div>
					</div>
					<div class="position-relative row form-group">
						<label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
						<div class="col-sm-10">
							<input maxlength="100" name="jabatan" id="jabatan" placeholder="Input Jabatan" type="jabatan" class="form-control" value="{{ old('jabatan', @$user->jabatan) }}">
						</div>
					</div>
					<div class="position-relative row form-group">
						<label for="phone" class="col-sm-2 col-form-label">Contact Number</label>
						<div class="col-sm-10">
							<input maxlength="13" name="phone" id="phone" placeholder="Input Contact Number" type="phone" class="form-control" value="{{ old('phone', @$user->phone) }}">
						</div>
					</div>
					<div class="position-relative row form-group">
						<label for="password" class="col-sm-2 col-form-label">Password</label>
						<div class="col-sm-10">
							<input maxlength="30" name="password" id="password" placeholder="Input Password" type="password" class="form-control">
						</div>
					</div>
					<div class="position-relative row form-group">
						<label for="password_confirmation" class="col-sm-2 col-form-label">Password Confirmation</label>
						<div class="col-sm-10">
							<input maxlength="30" name="password_confirmation" id="password_confirmation" placeholder="Input Password Confirmation" type="password" class="form-control">
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

					
					
					<div class="position-relative row form-check">
						<div class="col">
							<button class="btn btn-info">Submit</button>
						</div>
					</div>
					<!-- <div class="text-right">
						<button class="btn btn-primary">Submit</button>
					</div> -->
				</form>
			</div>
		</div>

		@if(!empty($user))
		<div class="row">
			<div class="col">
			<h2 class="section-title">User Access Applications</h2>
			<p class="section-lead">
			  You can provide user access on the card.
			  <a href="{{ !empty($userApps) ? route('ums.access.create', ['_token' => csrf_token(), 'id' => $user->id]) : ''}}" class="btn btn-success {{ !empty($userApps) ? '' : 'disabled'}}">Add App</a>
			</p>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<!-- /.card-header -->
					<div class="card-body">

						<table id="table01" class="table table-striped table-bordered table-hover" style="width:100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>Application Name</th>
									<th>status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							@if(!empty($userApps))	
								@foreach($userApps as $apps)
								<tr>
									<td>{{ $apps->app_id }}</td>
									<td>{{ $apps->app_name }}</td>
									<td class="text-center"><span class="badge badge-{{ $apps->status_color }}">{{ $apps->status_name }}</span></td>
									<td class="text-center">
										<a class="btn btn-sm btn-icon btn-{{$apps->user_status == '1' ? 'danger' : 'success'}}" href="{{ route('ums.app.active_inactive', ['_token' => csrf_token(), 'id' => $user->id, 'app_id' => $apps->id, 'status' => $apps->user_status]) }}" class="btn btn-link float-left">
											<i class="fa fa-{{$apps->user_status == '0' ? 'eye' : 'eye-slash'}} fa-fw" style="font-size:1rem"></i>
										</a>
										<a class="btn btn-sm btn-icon btn-info" href="{{ route('ums.access.edit', ['_token' => csrf_token(), 'id' => $user->id, 'app_id' => $apps->id]) }}" class="btn btn-link float-left">
											<i class="fas fa-edit fa-fw" style="font-size:1rem"></i>
										</a>
										<!-- <a href="" class="btn btn-link btn-default">
											<i class="fa fa-trash fa-fw" style="font-size:1.3rem"></i>
										</a> -->
									</td>
								</tr>
								@endforeach
							@endif
							</tbody>
						</table>

						<!-- /.table-responsive -->
					</div>
					<!-- /.card-body -->
				</div>
			</div>
		</div>
		@endif
		
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

@include('dash::components.js-datatables')
@include('dash::components.js-id-datatables', ['id' => 'table01'])
<script src="{{ pkg_asset('dash', 'dependencies/select2/select2.full.min.js') }}"></script>
@endsection