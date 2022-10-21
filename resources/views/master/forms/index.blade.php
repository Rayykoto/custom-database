@extends('layouts.backend')

@extends('components.navbar')

@section('content')

<div class="container-sm">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-md mt-3">
                <div class="card-body">
                    <select class="form-control" id="formindex_froup" name="formindex_froup">
                        @foreach($group as $index => $g)
                            <option value="{{ $g->name }}">{{ $g->description }}</option>
                        @endforeach
                    </select>
                    <br>
                    <table id="formindex_table" class="table table-bordered table-striped">
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</table>

{{ $forms->links() }}

<script>
    $('#formindex_froup').on('change', function (e) {
        var group = this.value;
        let token   = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            url: group+`/get_tables`,
            type: "GET",
            cache: false,
            data: {
                "group": group,
                "_token": token
            },
            success:function(response){
                $('#formindex_table').html(response);
                console.log(token);
                //show success message
                // Swal.fire({
                //     type: 'success',
                //     icon: 'success',
                //     title: 'created',
                //     showConfirmButton: false,
                //     timer: 3000
                // });

                // window.location.reload()

                //data post
                // let post = `
                //     <tr id="index_${response.data.id}">
                //         <td>${response.data.title}</td>
                //         <td class="text-center">
                //             <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                //             <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a>
                //         </td>
                //     </tr>
                // `;
                
                // //append to table
                // $('#table-posts').prepend(post);
                
                // //clear form
                // $('#name').val('');
                // $('#table').val('');

                // //close modal
                // $('#modal-create').modal('hide');

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
        //console.log(group);
        console.log(token);
    });
</script>

@endsection