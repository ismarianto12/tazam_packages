<!-- {{$par = '_token='.csrf_token().'&app_id='.$roles[0]->app_id}} -->
@extends('ums::layouts.main', ['title'=>'Daftar Role', 'routeName'=>'ums.app.create_role', 'par'=>$par])

@section('head')
@include('dash::components.css-datatables')
@endsection

@section("content")
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">

                <table id="table01" class="table table-striped table-bordered table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Role ID</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->role_id }}</td>
                            <td class="text-center"><span class="badge badge-{{ $role->status == '1' ? 'success' : 'danger' }}">{{ $role->status == '1' ? 'active' : 'inactive' }}</span></td>
                            <td class="text-center">
                                <a class="btn btn-sm icon-left btn-icon btn-{{$role->status == '0' ? 'success' : 'danger'}}" href="{{ route('ums.role.active_inactive', ['_token' => csrf_token(), 'role_id' => $role->role_id, 'app_id' => $role->app_id, 'status' => $role->status]) }}" class="btn btn-link float-left">
                                    <i class="fa fa-{{$role->status == '0' ? 'eye' : 'eye-slash'}} fa-fw" style="font-size:1rem"></i>
                                </a>
                                <a class="btn btn-sm btn-info icon-left" href="{{ route('ums.app.edit_role', ['_token' => csrf_token(), 'role_id' => $role->role_id, 'app_id' => $role->app_id]) }}" class="btn btn-link float-left">
                                    <i class="fa fa-edit fa-fw" style="font-size:1rem"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>


@endsection

@section("foot")
@include('dash::components.js-datatables')
@include('dash::components.js-id-datatables', ['id' => 'table01'])
@endsection