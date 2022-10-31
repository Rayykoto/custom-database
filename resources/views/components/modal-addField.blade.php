<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Column</h5>
                <button type="button" class="close" data-dismiss="modal-create" id="modal-create" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label class="control-label">Name</label>
                    <input type="text" class="form-control" id="field_name" name="field_name">
                    <input type="hidden" class="form-control" id="table" name="table" value="{{ $table }}">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-title"></div>
                </div>

                <div>
                    @foreach ($field as $fields)
                        <input type="radio" name="data_type" value="{{ $fields->data_type }}">&nbsp{{ $fields->name }}<br>
                    @endforeach
               </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="store">Save</button>
            </div>
        </div>
    </div>
</div>