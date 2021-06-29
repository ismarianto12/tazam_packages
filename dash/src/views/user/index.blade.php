@extends('dash::layouts.main', ['title'=>'Daftar User', 'routeName'=>"dash.user.create"])

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
                            <th>Username</th>
                            <th>Roles</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->getRoleNames() }}</td>
                            <td>{{ $user->status }}</td>
                            <td>
                                <a href="/it/projects/ $Project->id }}" class="btn btn-link float-left">
                                    <i class="fa fa-eye fa-fw" style="font-size:1.3rem"></i>
                                </a>
                                <a href="{{ route('dash.user.edit', $user->id) }}" class="btn btn-link float-left">
                                    <i class="fa fa-edit fa-fw" style="font-size:1.3rem"></i>
                                </a>
                                <form action="{{ route('dash.user.destroy', $user->id) }}" method="POST" class="float-left">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-link btn-default">
                                        <i class="fa fa-trash fa-fw" style="font-size:1.3rem"></i>
                                    </button>
                                </form>
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