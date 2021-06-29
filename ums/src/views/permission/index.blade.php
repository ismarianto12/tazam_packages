@extends('dash::layouts.main', ['title'=>'Daftar Aplikasi', 'routeName'=>""])

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
                            <th>App Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($apps as $app)
                        <tr>
                            <td>{{ $app->app_id }}</td>
                            <td>{{ $app->app_name }}</td>
                            <td class="text-center"><span class="badge badge-{{ $app->status == '1' ? 'success' : 'danger' }}">{{ $app->status == '1' ? 'active' : 'inactive' }}</span></td>
                            <td class="text-center">
                                <!-- <a href="" class="btn btn-link float-left">
                                    <i class="fa fa-eye fa-fw" style="font-size:1.3rem"></i>
                                </a> -->
                                <a class="btn btn-sm btn-icon btn-info" href="{{ route('ums.permission.app', ['_token' => csrf_token(), 'app_id' => $app->id])}}" class="btn btn-link float-left">
                                    <i class="fas fa-edit fa-fw" style="font-size:1rem"></i>
                                </a>
                                <!-- <a href="" class="btn btn-link float-left">
                                    <i class="fa fa-trash fa-fw" style="font-size:1.3rem"></i>
                                </a> -->

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