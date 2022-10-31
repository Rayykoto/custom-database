@extends('layouts.backend')

@extends('components.navbar')

@section('content')

    <h2>Dashboard</h2>
    
    <div class="card">

        <div class="card-header">New Database</div>

        <div class="card-body">

            <form action="{{ route('master.table-group.add') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="name">Table Name</label>
                    <div class="input-group">
                        <input type="text" name="name" id="name" class="form-control">
                        <button class="btn btn-primary" type="submit">Add</button>
                    </div>
                </div>
            </form>
            <hr class="hr-3">
            <form id="field_data_edit" class="container-fluid" action="{{ route('master.table-group.manage') }}" method="post">
                @csrf
                <input type="hidden" class="control-label" name="data_id" />
                <div class="form-group" style="overflow-x: auto;">
                    <table class="table table-striped table-bordered">
                        <thead style="background:black;color:white;">
                            <th>No</th>
                            <th>Field Name</th>
                            <th>Created Date</th>
                            <th>Manage</th>
                            <th class="b">Show/Hide</th>
                        </thead>
                        <tbody>
                            @foreach ($group as $index => $h)
                            {{-- <input type="text" class="form-control" id="managedata_type" name="managedata_type"> --}}
                            <tr>
                                <td>{{ $index +1 }}</td>
                                <td>{{ $h->description }}</td>
                                <td>{{ $h->created_at }}</td>
                                <td align="center"><a href="" class="btn btn-primary btn-sm">Manage</a></td>
                                <td align="center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="show_group[]" data-toggle="toggle" data-width="100" data-onstyle="success" data-offstyle="danger" value="{{$h->name}}" @if($h->is_show == 1) checked="checked" @endif >
                                        {{-- <label class="custom-control-label" for="customSwitch1">Toggle this switch element</label> --}}
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-title"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" >UPDATE</button>
                </div>
            </form>
        </div>

    </div>
@endsection