<div class="modal fade" id="modal-manageForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Manage Form : {{ $table_name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="overflow-x: auto;">
                <form id="field_data_edit" class="container-fluid" action="{{ route('master.forms.manage') }}" method="post">
                    @csrf
                    <input type="hidden" class="control-label" name="table" value="{{ $table }}" />
                    <input type="hidden" class="control-label" name="data_id" />
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="table" name="table" value="{{ $table }}">
                        <table class="table table-striped table-bordered">
                            <thead style="background:black;color:white;">
                                <th>No</th>
                                <th>Field Name</th>
                                <th>Data Type</th>
                                <th>Show Field</th>
                            </thead>
                            <tbody>
                                @foreach ($header as $index => $h)
                                {{-- <input type="text" class="form-control" id="managedata_type" name="managedata_type"> --}}
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>{{ $h->field_description }}</td>
                                     {{-- {{ $t->data_type }} --}}
                                    <td>
                                        <select class="js-states browser-default select2" name="managedata_type[]" id="managedata_type">
                                            @foreach($field as $f)
                                                <option value="{{ $f->data_type }}" {{$h->data_type == $f->data_type  ? 'selected' : ''}}>{{ $f->name }}</option>
                                            @endforeach
                                        </select>
                                        {{-- {{ $h->data_type }} --}}
                                    </td>
                                    <td>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" name="is_show[]" data-toggle="toggle" {{-- data-on="Shown" data-off="Hidden" --}} value="{{$h->field_name}}" @if($h->is_show == 1) checked="checked" @endif >
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
    </div>
</div>