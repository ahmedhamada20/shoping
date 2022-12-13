<div class="modal fade confirmation-model" id="delete-user-modal">
    <div class="modal-dialog">
        <div class="modal-content">
        <input type="hidden" value="" id="form-changestatus-url">

            <form id="delete-user-form" method="POST">
            @csrf
                

                <input type="hidden" value="" name="id" id="userid">
                <input type="hidden" value="" name="status" id="change_user_status">

                <div class="modal-body">
                    <div class="mt-15 text-center mb-15">
				<img src="{{asset('images/alert-danger.png')}}" style="height: 100px;">
				<p class="logout-title">Are you sure?</p>
			</div>
                    <div class="mt20 text-center">
                        <strong class="delete-form-name"></strong> will be <span class="status-to-change-text"></span>.
                    </div>
                </div>

                <div class="modal-footer">

                    <div class="btnintable bottom_btns pd0">
                        <button type="submit" class="btn btn-green">Confirm</button>
                        <button type="button" class="btn btn-red" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    
    $('body').on('click', '.change-status-form', function(e) {
        var id = $(this).data('id');
        $('#userid').val(id);
        $('.delete-form-name').html($(this).data('name'));
        $('#change_user_status').val($(this).data('status'));
        $('.status-to-change-text').html($(this).data('text-status'));
        $("#delete-user-form").attr('action', $('#form-changestatus-url').val());
        $('#delete-user-modal').modal();
    });

    $('body').on('click', '.delete-driver', function(e) {
        
        var id = $(this).data('id');
        $('#userid').val(id);
        $('.delete-form-name').html($(this).data('name'));
        $('#change_user_status').val($(this).data('status'));
        $('.status-to-change-text').html($(this).data('text-status'));
        $("#delete-user-form").attr('action', $('#form-changestatus-url').val());
        $('#delete-user-modal').modal();
    });

    // $('body').on('click', '.delete-lead', function(e) {
    //     var name = $(this).closest('tr').find('td:eq(1)').html();
    //     $('.delete-lead-name').html(name);
    //     $("#delete-user-form").attr('action', $(this).data('url'));
    //     $('#delete-user-modal').modal();
    // });

    $(document).ready(function() {
        $("#delete-user-form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function(response) {
                    $('#delete-user-modal').modal("hide");
                    console.log(response);
                    if (response.status == 'success') {
                        // printAjaxSuccessMsg(response.message);
                        alert(response.message);
                    } else {
                        // printAjaxErrorMsg(response.message);
                    }

                    $('#drivers-table').DataTable().ajax.reload();
                }
            });
        });
    });
</script>
