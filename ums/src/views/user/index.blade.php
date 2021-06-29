@extends('dash::layouts.main', ['title'=>'Daftar User', 'routeName'=>"ums.user.create"])

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
                            <th>NIK</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->NIK }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td class="text-center"><span class="badge badge-{{ $user->status == '1' ? 'success' : 'danger' }}">{{ $user->status == '1' ? 'active' : 'inactive' }}</span></td>
                            <td class="text-center">
                                <a class="btn btn-sm btn-icon btn-{{$user->status == '0' ? 'success' : 'danger'}}" href="{{ route('ums.user.active_inactive', ['_token' => csrf_token(), 'status' => $user->status, 'id' => $user->id]) }}" class="btn btn-link float-left">
                                    <i class="fas fa-{{$user->status == '0' ? 'eye' : 'eye-slash'}} fa-fw" style="font-size:1rem"></i>
                                </a>
                                <a class="btn btn-sm btn-icon btn-info" href="{{ route('ums.user.edit', $user->id) }}" class="btn btn-link float-left">
                                    <i class="fas fa-edit fa-fw" style="font-size:1rem"></i>
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