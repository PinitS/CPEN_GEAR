@extends('layouts.master')


@section('contents')

<div class="row">
    <div class="col-12">
        <div class="card bg-white">
            <div class="card-header">
                <h4 class="card-title text-dark">User Information</h4>
                <button type="button" class="btn btn-info gear-bnt-add-user">Add <span class="btn-icon-right"><i
                            class="fa fa-plus color-info"></i></span>
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="data_table_user" style="min-width: 845px">
                        <thead>
                        <tr>
                            <th class="text-dark">#</th>
                            <th class="text-dark">Username</th>
                            <th class="text-dark">Email</th>
                            <th class="text-dark">Status</th>
                            <th class="text-dark">Amount</th>
                            <th class="text-dark">Manage</th>
                        </tr>
                        </thead>
                        <tbody class="data-section_user">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade gear-modal-add" id="exampleModalCenter">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add user</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="mb-1"><strong>Username</strong></label>
                    <input type="text" class="form-control gear-modal-add-username" id="username"
                           name="username" placeholder="username" required>
                </div>
                <div class="form-group">
                    <label class="mb-1"><strong>Email</strong></label>
                    <input type="email" class="form-control gear-modal-add-email" id="email" name="email"
                           placeholder="hello@example.com" required>
                </div>
                <div class="form-group">
                    <label class="mb-1"><strong>Password</strong></label>
                    <input type="password" class="form-control gear-modal-add-password" id="password"
                           name="password" value="12345678" required>
                </div>
                <div class="form-group">
                    <label class="mb-1"><strong>Confirm Password</strong></label>
                    <input type="password" class="form-control gear-modal-add-password_confirmation "
                           id="cf_password" name="cf_password" value="12345678" required>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary gear-btn-modal-add-save">Register</button>
            </div>

        </div>
    </div>
</div>

    {{--modal update--}}
<div class="modal fade gear-modal-edit " id="exampleModalCenter">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="mb-1"><strong>Status</strong></label>
                    <select class="form-control gear-edit-status" id="gear-edit-status">
                        <option value="1">Admin</option>
                        <option value="0">Member</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="mb-1"><strong>Username</strong></label>
                    <input type="text" class="form-control gear-edit-username" value="">
                </div>

                <div class="form-group">
                    <label class="mb-1"><strong>Email</strong></label>
                    <input type="email" class="form-control gear-edit-email" value="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary gear-btn-modal-edit-save">Save changes</button>
            </div>

        </div>
    </div>
</div>
    {{--modal update--}}

@endsection

@section('script')
<script>
    var id = 0;
    var user_table = $('#data_table_user').DataTable();

    $(document).ready(function () {
        addDataInTable();
    });

    function addDataInTable()
    {
        $.ajax({
                type: "get",
                url: "{!! url('user/getUsers') !!}",
                beforeSend: function () {
                    $('#pnt-loading').show();
                },
                success: function (data) {
                    console.log(data)
                    if (data.status) {
                        user_table.destroy();
                        $('.data-section_user').html(null);
                        $.each(data.dataUser, function (index, value) {
                            var text_status = "";
                            (value.status > 0 ? text_status = "<span class='badge badge-pill badge-danger'>Admin</span>" : text_status = "<span class='badge badge-pill badge-primary'>Member</span>")
                            var localHtml =
                            '<tr><td>' +
                            (index+1) +
                            '</td><td>'+
                            value.name +
                            '</td><td>'+
                            value.email +
                            '</td><td>'+
                            text_status +
                            '</td><td>'+
                            value.amount +
                            '</td><td>'+
                            "<div class = 'd-flex'>" +
                            "<button  class='btn btn-secondary text-white gear-btn-reset shadow btn-xs sharp mr-1' value = '" + value.id + "'><i class='fa fa-key'></i></button>" +
                            "<button  class='btn btn-warning text-white gear-btn-edit shadow btn-xs sharp mr-1' value = '" + value.id + "'><i class='fa fa-pencil-square-o'></i></button>" +
                            "<button  class='btn btn-danger gear-btn-delete shadow btn-xs sharp mr-1' value = '" + value.id + "' ><i class= 'fa fa-trash'></i></button>"
                            $('.data-section_user').append(localHtml);
                        });
                        user_table = $('#data_table_user').DataTable();
                        $('#pnt-loading').hide();
                    }
                }
            });
    }

    $(document).off('click', '.gear-bnt-add-user').on('click', '.gear-bnt-add-user', (e) => {
        $('.gear-modal-add-username').val(''),
        $('.gear-modal-add-email').val(''),
        $('.gear-modal-add').modal();
    });

    $(document).off('click', '.gear-btn-modal-add-save').on('click', '.gear-btn-modal-add-save', (e) => {
        if($('.gear-modal-add-password').val() == $('.gear-modal-add-password_confirmation').val())
        {
            $.ajax({
                type: "post",
                url: "{!! url('user/create') !!}",
                data: {
                    name: $('.gear-modal-add-username').val(),
                    email: $('.gear-modal-add-email').val(),
                    password: $('.gear-modal-add-password').val(),
                    '_token': window.token,
                },
                beforeSend: function () {
                    $('#pnt-loading').show();
                },
                success: function (data) {
                    console.log(data)
                    if (data.status) {
                        sweetAlert('success' , 'Add User Success fully')
                    }
                    else{
                        sweetAlert('error' , 'Something went wrong!')
                    }
                    addDataInTable();
                    $('.gear-modal-add').modal('hide');
                    $('#pnt-loading').hide();
                },
                error: function (jqXHR, exception) {
                    if (jqXHR.status !== 200) {
                        $('#pnt-loading').hide();
                        sweetAlert('error' , 'Something went wrong!')
                    }
                },
            });
        }
        else
        {
            sweetAlert('error' , 'Password and confirmation do not match')
        }


    });

    $(document).off('click', '.gear-btn-edit').on('click', '.gear-btn-edit', (e) => {
        window.id = $(e.currentTarget).val();
        $.ajax({
                type: "get",
                url: "{!! url('user/getOneUser') !!}/" +  window.id,
                beforeSend: function () {
                    $('#pnt-loading').show();
                },
                success: function (data) {
                    $('.gear-edit-status').val(data.dataUser.status).change();
                    $('.gear-edit-username').val(data.dataUser.name);
                    $('.gear-edit-email').val(data.dataUser.email);
                    $('.gear-modal-edit').modal('show');
                    $('#pnt-loading').hide();
                },
            });
    });

    $(document).off('click', '.gear-btn-modal-edit-save').on('click', '.gear-btn-modal-edit-save', (e) => {

        console.log($('.gear-edit-status').val());
        $.ajax({
                type: "post",
                url: "{!! url('user/update') !!}/" + window.id,
                data: {
                    status: $('.gear-edit-status option:selected').val(),
                    name: $('.gear-edit-username').val(),
                    email: $('.gear-edit-email').val(),
                    '_token': window.token,
                },
                beforeSend: function () {
                    $('#pnt-loading').show();
                },
                success: function (data) {
                    console.log(data)
                    if (data.status) {
                        sweetAlert('success' , 'Update User Success fully')
                    }
                    else{
                        sweetAlert('error' , 'Something went wrong!')
                    }
                    addDataInTable();
                    $('.gear-modal-edit').modal('hide');
                    $('#pnt-loading').hide();
                },
                error: function (jqXHR, exception) {
                    if (jqXHR.status !== 200) {
                        $('#pnt-loading').hide();
                        sweetAlert('error' , 'Something went wrong!')
                    }
                },
            });
    });

    $(document).off('click', '.gear-btn-reset').on('click', '.gear-btn-reset', (e) => {
        window.id = $(e.currentTarget).val();
        $('.gear-modal-reset-password').modal('show');
    });

    $(document).off('click', '.pnt-btn-modal-reset-password-save').on('click', '.pnt-btn-modal-reset-password-save', (e) => {
        console.log($('.gear-reset-password').val())
        console.log($('.gear-reset-password_confirmation').val())
        console.log(window.id)
        if($('.gear-reset-password').val() == $('.gear-reset-password_confirmation').val())
        {
            $.ajax({
                type: "post",
                url: "{!! url('user/resetPassword') !!}/" + window.id,
                data: {
                    password: $('.gear-reset-password').val(),
                    '_token': window.token,
                },
                beforeSend: function () {
                    $('#pnt-loading').show();
                },
                success: function (data) {
                    console.log(data)
                    if (data.status == "only")
                    {
                        sweetAlert('success' , 'Please Login..')
                        location.reload();
                    }
                    else if (data.status == "other") {
                        sweetAlert('success' , 'Reset Password Success fully')
                    }
                    else{
                        sweetAlert('error' , 'Something went wrong!')
                    }
                    $('.gear-modal-reset-password').modal('hide');
                    $('#pnt-loading').hide();
                },
                error: function (jqXHR, exception) {
                    if (jqXHR.status !== 200) {
                        $('#pnt-loading').hide();
                        sweetAlert('error' , 'Something went wrong!')
                    }
                },
            });
        }
        else
        {
            sweetAlert('error' , 'Password and confirmation do not match')
        }
    });


    $(document).off('click', '.gear-btn-delete').on('click', '.gear-btn-delete', (e) => {
        window.id = $(e.currentTarget).val();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "get",
                    url: "{!! url('user/delete') !!}/" +  window.id,
                    beforeSend: function () {
                        $('#pnt-loading').show();
                    },
                    success: function (data) {
                        addDataInTable();
                        $('#pnt-loading').hide();
                        Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                )
                    },
                });
            }
        })
    });

</script>

@endsection
