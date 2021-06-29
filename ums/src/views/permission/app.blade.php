<!-- {{$par = '_token='.csrf_token().'&app_id='.$permissions[0]->app_id}} -->
@extends('ums::layouts.main', ['title'=>'Daftar Permission', 'routeName'=>'ums.app.create_permission', 'par'=>$par])

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
                            <th>Permission ID</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $permission)
                        <tr>
                            <td>{{ $permission->id }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->permission_id }}</td>
                            <td class="text-center"><span class="badge badge-{{ $permission->status == '1' ? 'success' : 'danger' }}">{{ $permission->status == '1' ? 'active' : 'inactive' }}</span></td>
                            <td class="text-center">
                            <a class="btn btn-sm icon-left btn-icon btn-{{$permission->status == '0' ? 'success' : 'danger'}}" href="{{ route('ums.permission.active_inactive', ['_token' => csrf_token(), 'permission_id' => $permission->permission_id, 'app_id' => $permission->app_id, 'status' => $permission->status]) }}" class="btn btn-link float-left">
                                    <i class="fa fa-{{$permission->status == '0' ? 'eye' : 'eye-slash'}} fa-fw" style="font-size:1rem"></i>
                                </a>
                                <a class="btn btn-sm btn-info icon-left"  href="{{ route('ums.app.edit_permission', ['_token' => csrf_token(), 'app_id' => $permission->app_id, 'permission_id' => $permission->permission_id]) }}" class="btn btn-link float-left">
                                    <i class="fas fa-edit" style="font-size:1rem"></i>
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