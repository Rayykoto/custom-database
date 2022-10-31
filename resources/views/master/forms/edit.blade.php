@extends('layouts.backend')

@extends('components.navbar')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-md mt-3">
                <div class="card-body">
                    <h2>Form {{ $table_name }}</h2>
                    {{-- {{ $table }} --}}
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="javascript:void(0)" class="btn btn-success btn-sm mb-3" id="btn-create-post">Add Column</a>&nbsp;
                            <a href="javascript:void(0)" class="btn btn-success btn-sm mb-3" id="btn-manage-form">Manage Form</a>
                        </div>
                        <div class="col-md-6" align="right">
                            <a href="javascript:void(0)" class="btn btn-success btn-sm mb-3" id="btn-add-post">Add Data</a>
                        </div>
                    </div>
                    <div class="form-group" style="overflow-x: auto;">
                        <table class="table table-bordered table-striped" >
                            <thead class=thead-dark>
                            @foreach ($title as $index => $t )
                                {{-- <td>{{ $form->count() * ($form->currentPage() -1) + $loop->iteration }}</td> --}}
                                <th>{{ $t->field_description }}</th>
                            @endforeach
    
                            <th>Aksi</th>
                            </thead>
    
                            <tbody>
    
                            @if ($form->count()>0)
                                @foreach ($form as $f)
                                <tr>
                                    @foreach ($title as $t)
                                        <?php $fields = $t->field_name; ?>
                                        <td>{{ $f->$fields }}</td>
                                    @endforeach
                                    <td>
                                        <a href="" id="btn-edit-post" data-toggle="modal" data-target="#modal-editRecord" selected_id="{{ $f->id }}" table_name="{{ $table_name }}" class="btn btn-primary btn-sm">EDIT</a>&nbsp
                                        <button type="button" class="btn btn-danger btn-sm btn_delete" table_name="{{ $table }}" id="{{ $f->id }}">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <x-modal-create> </x-modal-create> --}}
</table>
<!-- Modal Update -->
@include('components.modal-edit')

<!-- Modal Create -->
@include('components.modal-addField')

<!-- Modal Manage Form -->
@include('components.modal-manageForm')

<!-- Modal Add Data -->
<div class="modal fade" id="modal-addData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Data</h5>
                <button type="button" class="close" data-dismiss="modal-create" id="modal-create" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="field_data_add" class="container-fluid" action="{{ route('master.forms.add_record') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="table" name="table" value="{{ $table }}">
                        @foreach ($title as $index => $t )
                            <div class='container-fluid'>
                                <?php 
                                $input_type = "";
                                    switch ($t->data_type) {
                                        case "VARCHAR(255)":
                                            $input_type = '<input type="text" name="'.$t->field_name.'" id="'.$t->field_name.'" class="form-control form-control-user" ><br>';
                                            break;
                                        case "TEXT":
                                            $input_type = '<textarea name="'.$t->field_name.'" id="'.$t->field_name.'" class="form-control form-control-user" ></textarea><br>';
                                            break;
                                        case "BIGINT(20)":
                                            $input_type = '<input type="number" name="'.$t->field_name.'" id="'.$t->field_name.'" class="form-control form-control-user" required><br>';
                                            break;
                                        case "TIME":
                                            $input_type = '<input type="time" name="'.$t->field_name.'" id="'.$t->field_name.'" class="form-control form-control-user" required><br>';
                                            break;
                                        case "DATE":
                                            $input_type = '<input type="date" name="'.$t->field_name.'" id="'.$t->field_name.'" class="form-control form-control-user" required><br>';
                                            break;
                                        case "TIMESTAMP":
                                            $input_type = '<input type="text" name="'.$t->field_name.'" id="'.$t->field_name.'" class="form-control form-control-user" required><br>';
                                            break;
                                    }
                                    ?>
                                <label >{{ $t->field_description }}</label>
                                <?php echo $input_type; ?>
                            </div>
                        @endforeach
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-title"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="addData">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $(document).on('click', '.btn_delete', function(){
        var id = $(this).attr('id');
        var table_name = $(this).attr('table_name');
        let token   = $("meta[name='csrf-token']").attr("content");
        console.log(id);
        console.log(table_name);
        swal.fire({
            title: "Delete",
            text: "Are you sure you want to delete this?",
            icon: "warning",
            confirmButtonText: "Yes",
            showCancelButton: true,
        })
        .then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('master.forms.delete') }}",
                    data: {id:id,table_name:table_name,_token: token},
                    success: function (data) {
                        Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: 'Delete Success',
                            showConfirmButton: false,
                            timer: 3000
                        }).then(()=>{
                            window.location.reload();
                        });

                        //window.location.reload()
                    }
                });
            // } else {
                // swal.fire("We keep this data");
            }
        });
    });
});
    //button create post event
    $('body').on('click', '#btn-create-post', function () {
        //open modal
        $('#modal-create').modal('show');
    });

    $('body').on('click', '#btn-manage-form', function () {
        //open modal
        $('#modal-manageForm').modal('show');
    });

    $('body').on('click', '#btn-add-post', function () {
        //open modal
        $('#modal-addData').modal('show');
    });

    $('#select-options').on('change', function () {
        var values = $(this).val();
        console.log(values);
        $('#managedata_type').val(values);
    });

    //action create post
    $('#store').click(function(e) {
        e.preventDefault();

        //define variable
        let name   = $('#field_name').val();
        let table  = $('#table').val();
        let data_type  = $('input[name="data_type"]:checked').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        console.log(name);
        //ajax
        $.ajax({

            url: `addcolumn`,
            type: "POST",
            cache: false,
            data: {
                "name": name,
                "table": table,
                "data_type": data_type,
                "_token": token
            },
            success:function(response){

                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: 'created',
                    showConfirmButton: false,
                    timer: 3000
                }).then(()=>{
                    window.location.reload();
                });

                //window.location.reload()

                //data post
                let post = `
                    <tr id="index_${response.data.id}">
                        <td>${response.data.title}</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                            <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a>
                        </td>
                    </tr>
                `;

                //append to table
                $('#table-posts').prepend(post);

                //clear form
                $('#name').val('');
                $('#table').val('');

                //close modal
                $('#modal-create').modal('hide');

            },
            error:function(error){
                
                // if(error.responseJSON.name[0]) {

                //     //show alert
                //     $('#alert-name').removeClass('d-none');
                //     $('#alert-name').addClass('d-block');

                //     //add message to alert
                //     $('#alert-name').html(error.responseJSON.title[0]);
                // } 

            }

        });

    });
</script>
@endsection
