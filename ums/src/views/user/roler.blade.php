@extends('dash::layouts.main', ['title'=>'Role user'])

@section('head')
    <link rel="stylesheet" type="text/css" href="{{ pkg_asset('ums', 'icon_font/css/icon_font.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ pkg_asset('ums', 'css/jquery.transfer.css?v=0.0.3') }}" />
    <style>
        .transfer-demo {
            width: 640px;
            height: 400px;
            margin: 0 auto;
        }
    </style>
@endsection

@section("content")
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<form action="{{ isset($role) ? route('ums.role.update', @$role->id) : route('ums.role.store') }}" role="form" method="post">
					@csrf
					{{ isset($role) ? method_field('PATCH') : "" }}

					@include('dash::components.messages')

					<div class="position-relative row form-group"><label for="name" class="col-sm-2 col-form-label">User</label>
						<div class="col-sm-10"><input name="name" id="name" placeholder="Input Name" type="text" class="form-control" value="{{ @$role->name }}"></div>
					</div>
					<!-- <div class="position-relative row form-group">
						<label for="exampleSelect" class="col-sm-2 col-form-label">Select</label>
						<div class="col-sm-10">
							<select name="status" id="for" class="form-control">
								<option value="1">Active</option>
								<option value="0" {{ @$role->status == 0 ? 'selected="selected"' : '' }}>Inactive</option>
							</select>
						</div>
					</div> -->
					<div class="position-relative row form-group">
						<label for="exampleSelect" class="col-sm-2 col-form-label">Select</label>

                        <div>
                            <!-- <div id="transfer1" class="transfer-demo"></div>
                            <div id="transfer2" class="transfer-demo"></div>
                            <div id="transfer3" class="transfer-demo"></div> -->
                            <div class="col-sm-10" id="transfer4" class="transfer-demo"></div>
                        </div>

						


					</div>
					<div class="position-relative row form-check">
						<div class="col-sm-10 offset-sm-2">
							<button type="submit" class="btn btn-secondary">Submit</button>
							<a class="btn btn-warning" href="{{ route('ums.role.index') }}">Back</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


@endsection

@section("foot")
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
<script type="text/javascript" src="{{ pkg_asset('ums', 'js/jquery.transfer.js?v=0.0.6') }}"></script>
<script>
var groupDataArray2 = [
        {
            "groupName": "Admin",
            "groupData": [
                {
                    "city": "inquiry",
                    "value": 643,
                    "selected": false
                },
                {
                    "city": "user",
                    "value": 422,
                    "selected": false
                }
            ]
        },
        {
            "groupName": "Guest",
            "groupData": [
                {
                    "city": "home",
                    "value": 132,
                    "selected": true
                },
                {
                    "city": "input",
                    "value": 112,
                    "selected": true
                }
            ]
        }
    ];

    var settings4 = {
        "groupDataArray": groupDataArray2,
        "groupItemName": "groupName",
        "groupArrayName": "groupData",
        "itemName": "city",
        "valueName": "value",
        "callable": function (items) {
            console.dir(items)
        }
    };

    var transfer = $("#transfer4").transfer(settings4);
    // get selected items
    var items = transfer.getSelectedItems()
    console.log("Manually get selected items: %o", items);
</script>
@endsection
