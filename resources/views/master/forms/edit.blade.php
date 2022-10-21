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
                     <a href="javascript:void(0)" class="btn btn-success btn-sm mb-3" id="btn-create-post">Add Column</a>
                    <table class="table table-bordered table-striped">
                        <thead class=thead-dark>
                        @foreach ($title as $index => $t )
                            {{-- <td>{{ $form->count() * ($form->currentPage() -1) + $loop->iteration }}</td> --}}
                            <th>{{ $t->field_description }}</th>
                        @endforeach

                        <th>Aksi</th>
                        </thead>

                        <tbody>
                        
                        @foreach ($form as $f)
                        <tr>
                            @foreach ($title as $t)
                                <?php $fields = $t->field_name; ?>
                                <td>{{ $f->$fields }}</td>
                            @endforeach
                            <td><a href="" id="btn-edit-post" data-toggle="modal" data-target="#modal-editRecord" selected_id="{{ $f->id }}" table_name="{{ $table_name }}" class="btn btn-primary btn-sm">EDIT</a></td>
                        </tr>
                        @endforeach


                        </tbody>
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
                    <label for="name" class="control-label">Name</label>
                    <input type="text" class="form-control" id="name">
                    <input type="hidden" class="form-control" id="table" value="{{ $table }}">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-title"></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="store">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    //button create post event
    $('body').on('click', '#btn-create-post', function () {

        //open modal
        $('#modal-create').modal('show');
    });

    //action create post
    $('#store').click(function(e) {
        e.preventDefault();

        //define variable
        let name   = $('#name').val();
        let table  = $('#table').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({

            url: `addcolumn`,
            type: "POST",
            cache: false,
            data: {
                "name": name,
                "table": table,
                "_token": token
            },
            success:function(response){

                //show success message
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: 'created',
                    showConfirmButton: false,
                    timer: 3000
                });

                window.location.reload()

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
                
                if(error.responseJSON.name[0]) {

                    //show alert
                    $('#alert-name').removeClass('d-none');
                    $('#alert-name').addClass('d-block');

                    //add message to alert
                    $('#alert-name').html(error.responseJSON.title[0]);
                } 

            }

        });

    });
</script>
@endsection
