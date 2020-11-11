@extends('layouts.master')

@section('contents')


<div class="row">
    <div class="col-12">
        <div class="card bg-white">
            <div class="card-header">
                <h4 class="card-title text-dark">Category Information</h4>
                <button type="button" class="btn btn-warning gear-modal-add-open">Add <span class="btn-icon-right"><i
                            class="fa fa-plus color-warning"></i></span>
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="data_table_category" style="min-width: 845px">
                        <thead>
                        <tr>
                            <th class="text-dark">#</th>
                            <th class="text-dark">Type</th>
                            <th class="text-dark">Category</th>
                            <th class="text-dark">Manage</th>
                        </tr>
                        </thead>
                        <tbody class="data-section_category">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade gear-modal-add">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="mb-1"><strong>Type</strong></label>
                    <select class="form-control gear-add-type" id="gear-edit-status">
                        <option value="1">INCOME</option>
                        <option value="0">EXPENSE</option>
                    </select>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Category</span>
                    </div>
                    <input type="text" class="form-control gear-modal-add-name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-warning gear-add-category-save">Add Category</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade gear-modal-edit">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="mb-1"><strong>Type</strong></label>
                    <select class="form-control gear-edit-type" id="gear-edit-status">
                        <option value="1">INCOME</option>
                        <option value="0">EXPENSE</option>
                    </select>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Category</span>
                    </div>
                    <input type="text" class="form-control gear-edit-name">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-warning gear-edit-save">Save changes</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    var id = 0;
    var category_table = $('#data_table_category').DataTable();

    function addDataInTable()
    {
        $.ajax({
                type: "get",
                url: "{!! url('category/getCategories') !!}",
                beforeSend: function () {
                    $('#pnt-loading').show();
                },
                success: function (data) {
                    if (data.status) {
                        category_table.destroy();
                        $('.data-section_category').html(null);
                        $.each(data.categories, function (index, value) {
                            console.log(value.id)
                            var localHtml =
                            '<tr><td>' +
                            (index+1) +
                            '</td><td>'+
                            (value.type == 0 ? "EXPENSE" : "INCOME") +
                            '</td><td>'+
                            value.name +
                            '</td><td>'+
                            "<div class = 'd-flex'>" +
                            "<button  class='btn btn-warning text-white gear-btn-edit shadow btn-xs sharp mr-1' value = '" + value.id + "'><i class='fa fa-pencil-square-o'></i></button>";
                            if(value.delete_active == 0)
                            {
                                localHtml += "<button  class='btn btn-danger gear-btn-delete shadow btn-xs sharp mr-1' value = '" + value.id + "' ><i class= 'fa fa-trash'></i></button>";
                            }
                            $('.data-section_category').append(localHtml);
                        });
                        category_table = $('#data_table_category').DataTable();
                        $('#pnt-loading').hide();
                    }
                }
            });
    }

    $(document).ready(function () {
        addDataInTable();
    });

    $(document).off('click', '.gear-modal-add-open').on('click', '.gear-modal-add-open', (e) => {
        $('.gear-add-type').val(0).change();
        $('.gear-modal-add-name').val('');
        $('.gear-modal-add').modal();
    });

    $(document).off('click', '.gear-add-category-save').on('click', '.gear-add-category-save', (e) => {
        if($('.gear-modal-add-name').val() != '')
        {
            $.ajax({
                type: "post",
                url: "{!! url('category/create') !!}",
                data: {
                    name: $('.gear-modal-add-name').val(),
                    type: $('.gear-add-type option:selected').val(),
                    '_token': window.token,
                },
                beforeSend: function () {
                    $('#pnt-loading').show();
                },
                success: function (data) {
                    console.log(data)
                    if (data.status) {
                        sweetAlert('success' , 'Add Category Success fully')
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
            sweetAlert('error' , 'Category Name went wrong!')
        }

    });

    $(document).off('click', '.gear-btn-edit').on('click', '.gear-btn-edit', (e) => {
        console.log($(e.currentTarget).val())
        window.id = $(e.currentTarget).val();
        $.ajax({
                type: "get",
                url: "{!! url('category/getCategory') !!}/" +  window.id,
                beforeSend: function () {
                    $('#pnt-loading').show();
                },
                success: function (data) {
                    $('.gear-edit-name').val(data.category.name);
                    $('.gear-edit-type').val(data.category.type).change();
                    $('.gear-modal-edit').modal('show');
                    $('#pnt-loading').hide();
                },
            });
    });

    $(document).off('click', '.gear-edit-save').on('click', '.gear-edit-save', (e) => {
        if($('.gear-edit-name').val() != '')
        {
            $.ajax({
                type: "post",
                url: "{!! url('category/update') !!}/" + window.id,
                data: {
                    name: $('.gear-edit-name').val(),
                    type: $('.gear-edit-type option:selected').val(),
                    '_token': window.token,
                },
                beforeSend: function () {
                    $('#pnt-loading').show();
                },
                success: function (data) {
                    console.log(data)
                    if (data.status) {
                        sweetAlert('success' , 'Update Category Success fully')
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
        }
        else
        {
            sweetAlert('error' , 'Category Name went wrong!')
        }
    });

    $(document).off('click', '.gear-btn-delete').on('click', '.gear-btn-delete', (e) => {
        console.log($(e.currentTarget).val());
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
                    url: "{!! url('category/delete') !!}/" +  window.id,
                    beforeSend: function () {
                        $('#pnt-loading').show();
                    },
                    success: function (data) {
                        console.log(data)
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
