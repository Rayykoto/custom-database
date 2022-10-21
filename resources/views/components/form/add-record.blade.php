<div class="modal fade" id="modal-addRecord" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">EDIT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="field_data_edit" class="container-fluid" action="" method="post">
                @foreach ($title as $t )
                        <div class="form-group">
                    <label for="name" class="control-label">{{ $t->field_description }}</label>

                     <?php $fields = $t->field_name; ?>
                    <input type="text" class="form-control" name="{{ $t->field_name }}" id="{{ $t->field_name }}" value="{{ $t->field_description }}">

                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-title-edit"></div>
                </div>

                @endforeach
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="update">UPDATE</button>
            </div>
        </div>
    </div>
</div>
<?php
    $addressPoints  = array();
    $table_data     = array();
    $addressPoints  = $title;
    $table_data     = $form;
?>
<script>
$(document).ready(function() {
  $('#modal-edit').on('show.bs.modal', function (e) {
    var addressPoints = <?php echo json_encode($addressPoints); ?>;
    var table_data    = <?php echo json_encode($table_data); ?>;
    console.log(table_data);
    console.log(addressPoints);
	  // get information to update quickly to modal view as loading begins
    var opener=e.relatedTarget;//this holds the element who called the modal
    //we get details from attributes
    var data_id       = $(opener).attr('selected_id');
    console.log(data_id);
    $('#field_data_edit').find('[name="data_id"]').val(data_id);
    for (var j = 0; j < addressPoints.length; j++) {
      var b = addressPoints[j];
      for (var i = 0; i < table_data.length; i++) {
        var a = table_data[i];
        if (a.id == data_id){
          const field_pointer = b.field_name;
          var pointer_value = a[field_pointer];
          $('#field_data_edit').find('[name="'+field_pointer+'"]').val(pointer_value);
        }
      }
    }
	});
});
    //button create post event
    $('body').on('click', '#btn-edit-post', function () {

        let post_id = $(this).data('id');

        //fetch detail post with ajax
        $.ajax({
            url: `/master/forms/${post_id}/show`,
            type: "GET",
            cache: false,
            success:function(response){

                //fill data to form
                $('#post_id').val(response.data.name);
                $('#title-edit').val(response.data.title);
                $('#content-edit').val(response.data.content);

                //open modal
                $('#modal-edit').modal('show');
            }
        });
    });

    //action update post
    $('#update').click(function(e) {
        e.preventDefault();

        //define variable
        let field_name = $('#field_name').val();
        
        
        //ajax
        $.ajax({
            url: `${post_id }/update`,
            type: "PUT",
            cache: false,
            data: {
                {{-- "title": title,
                "content": content,
                "_token": token --}}
            },
            success:function(response){

                //show success message
                Swal.fire({
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 3000
                });

                //data post
                let post = `
                    <tr id="index_${response.data.id}">
                        <td>${response.data.title}</td>
                        <td>${response.data.content}</td>
                        <td class="text-center">
                            <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id}" class="btn btn-primary btn-sm">EDIT</a>
                            <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id}" class="btn btn-danger btn-sm">DELETE</a>
                        </td>
                    </tr>
                `;
                
                //append to post data
                $(`#index_${response.data.id}`).replaceWith(post);

                //close modal
                $('#modal-edit').modal('hide');
                

            },
            error:function(error){
                
                if(error.responseJSON.title[0]) {

                    //show alert
                    $('#alert-title-edit').removeClass('d-none');
                    $('#alert-title-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-title-edit').html(error.responseJSON.title[0]);
                } 

                if(error.responseJSON.content[0]) {

                    //show alert
                    $('#alert-content-edit').removeClass('d-none');
                    $('#alert-content-edit').addClass('d-block');

                    //add message to alert
                    $('#alert-content-edit').html(error.responseJSON.content[0]);
                } 

            }

        });

    });

</script>