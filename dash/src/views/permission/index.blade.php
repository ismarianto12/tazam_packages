@extends('dash::layouts.main', ['title'=>'Daftar Permission', 'routeName'=>"dash.permission.create"])

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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $permission)
                        <tr>
                            <td>{{ $permission->id }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>
                                <a href="/it/projects/ $Project->id }}">
                                    <i class="fa fa-eye fa-fw" style="font-size:1.3rem"></i>
                                </a>
                                <a href="/it/projects/create">
                                    <i class="fa fa-edit fa-fw" style="font-size:1.3rem"></i>
                                </a>
                                <a href="/it/projects/create">
                                    <i class="fa fa-trash fa-fw" style="font-size:1.3rem"></i>
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