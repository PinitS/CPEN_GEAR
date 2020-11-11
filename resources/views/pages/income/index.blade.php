@extends('layouts.master')

@section('contents')
{{-- <div class="card">
    <div class="card-header">
        <h4 class="card-title">Pick-Date picker</h4>
    </div>
    <div class="card-body">
        <p class="mb-1">Default picker</p>
        <input name="datepicker" class="datepicker-default pnt-pick form-control" id="datepicker">
    </div>
</div> --}}

<div class="card gear-card-add">
    <div class="card-header">
        <h4 class="card-title">INCOME/EXPENSE</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-2 col-sm-12">
                <label></label>
                <select class="form-control gear-add-type mt-2">
                    @if (Auth::user()->status == 1)
                    <option value="1" selected>INCOME</option>
                    @endif
                    <option value="0">EXPENSE</option>
                </select>
            </div>
            <div class="col-md-3 col-sm-12">
                <label>Category</label>
                <select class="form-control gear-add-category">
                </select>
            </div>
            <div class="col-md-2 col-sm-12">
                <label>Amount</label>
                <input type="number" class="form-control gear-add-amount">
            </div>
            <div class="col-md-3 col-sm-12">
                <label>Date</label>
                <input name="datepicker" class="datepicker-default gear-add-pick form-control" id="datepicker">
            </div>
            <div class="col-md-2 col-sm-12">
                <label>Remark</label>
                <input type="text" class="form-control gear-add-remark" value ="#">
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-sm-12 mx-auto">
                <label></label>
                <button type="button" class="btn light btn-success btn-block gear-history-save mt-2">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="card gear-card-edit" style="display: none">
    <div class="card-header">
        <h4 class="card-title">Edit INCOME/EXPENSE</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-2 col-sm-12">
                <label></label>
                <select class="form-control gear-edit-type mt-2">
                    @if (Auth::user()->status == 1)
                    <option value="1" selected>INCOME</option>
                    @endif
                    <option value="0">EXPENSE</option>
                </select>
            </div>
            <div class="col-md-3 col-sm-12">
                <label>Category</label>
                <select class="form-control gear-edit-category">
                </select>
            </div>
            <div class="col-md-2 col-sm-12">
                <label>Amount</label>
                <input type="number" class="form-control gear-edit-amount">
            </div>
            <div class="col-md-3 col-sm-12">
                <label>Date</label>
                <input name="datepicker" class="datepicker-default gear-edit-pick form-control" id="datepicker">
            </div>
            <div class="col-md-2 col-sm-12">
                <label>Remark</label>
                <input type="text" class="form-control gear-edit-remark" value ="#">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-sm-12 mx-auto">
                <label></label>
                <button type="button" class="btn light btn-danger  gear-history-close mt-2">Close</button>
                <button type="button" class="btn light btn-warning  gear-history-edit-save mt-2">Save changes</button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card bg-white">
            <div class="card-header">
                <h4 class="card-title text-dark">History Information</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="data_table_hisroty" style="min-width: 845px">
                        <thead>
                        <tr>
                            <th class="text-dark">#</th>
                            <th class="text-dark">Type</th>
                            <th class="text-dark">Category</th>
                            <th class="text-dark">Amount</th>
                            <th class="text-dark">Remark</th>
                            <th class="text-dark">Date</th>
                            <th class="text-dark">Manage</th>
                        </tr>
                        </thead>
                        <tbody class="data-section_hisroty">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection



@section('script')

<script>

    var timeToData = moment().format('YYYY-MM-DD');
    var history_table = $('#data_table_hisroty').DataTable();
    var type_id = $('.gear-add-type option:selected').val();
    var gear_add_category = $('.gear-add-category');
    var gear_edit_category = $('.gear-edit-category');

    var id = 0;

    $(document).ready(function () {

        $('.gear-add-pick').val(moment().format("DD MMMM  YYYY"));
        addDataInTable();
        getDropDown();
        // console.log(timeToData);
        console.log('type id = ',window.type_id)
    });

    function getDropDown()
    {
        console.log('getddd');
        $.ajax({
                type: "get",
                url: "{!! url('category/getDropdownCategory') !!}/" + window.type_id,
                beforeSend: function () {
                    $('#pnt-loading').show();
                },
                success: function (data) {
                    // console.log(data)
                    if (data.status) {
                        window.gear_add_category.empty();
                        window.gear_edit_category.empty();
                        var category = "";
                        $.each(data.categories, function (index, value) {
                            category += "<option value='" + value.id + "'> <strong>" + value.name + "</strong></option>"

                        });
                        window.gear_add_category.append(category);
                        window.gear_add_category.selectpicker('refresh');
                        window.gear_edit_category.append(category);
                        window.gear_edit_category.selectpicker('refresh');
                        $('#pnt-loading').hide();
                    }
                }
            });
    }

    function addDataInTable()
    {
            $.ajax({
                type: "get",
                url: "{!! url('income/getHistory') !!}",
                beforeSend: function () {
                    $('#pnt-loading').show();
                },
                success: function (data) {
                    // console.log(data)
                    if (data.status) {
                        history_table.destroy();
                        $('.data-section_hisroty').html(null);
                        $.each(data.dataHistory, function (index, value) {
                            // console.log(value.id)
                            var localHtml =
                            '<tr><td>' +
                            (index+1) +
                            '</td><td>'+
                            (value.type == 0 ? "EXPENSE" : "INCOME") +
                            '</td><td>'+
                            value.category_name +
                            '</td><td>'+
                            value.amount +
                            '</td><td>'+
                            value.remark +
                            '</td><td>'+
                            moment(value.time_date).format("DD MMMM  YYYY") +
                            '</td><td>'+
                            "<div class = 'd-flex'>" +
                            "<button  class='btn btn-warning text-white gear-btn-edit shadow btn-xs sharp mr-1' value = '" + value.id + "'><i class='fa fa-pencil-square-o'></i></button>"+
                            "<button  class='btn btn-danger gear-btn-delete shadow btn-xs sharp mr-1' value = '" + value.id + "' ><i class= 'fa fa-trash'></i></button>";

                            $('.data-section_hisroty').append(localHtml);
                        });
                        history_table = $('#data_table_hisroty').DataTable();
                        $('#pnt-loading').hide();
                    }
                }
            });
    }



    $(document).off('change', '.gear-add-pick').on('change', '.gear-add-pick', (e) => {
        var show = moment($('.gear-add-pick').val()).format("DD MMMM  YYYY");
        $('.gear-add-pick').val(show)
        timeToData = moment($('.gear-add-pick').val()).format('YYYY-MM-DD');
    });

    $(document).off('change', '.gear-edit-pick').on('change', '.gear-edit-pick', (e) => {
        var showedit = moment($('.gear-edit-pick').val()).format("DD MMMM  YYYY");
        $('.gear-edit-pick').val(showedit)
        timeToData = moment($('.gear-edit-pick').val()).format('YYYY-MM-DD');
    });

    $(document).off('click', '.gear-history-save').on('click', '.gear-history-save', (e) => {
        // console.log(timeToData)
        window.type_id = $('.gear-add-type option:selected').val()
        console.log('type id = ',window.type_id)

        if($('.gear-add-amount').val() != '' && $('.gear-add-amount').val() > 0)
        {
            $.ajax({
                type: "post",
                url: "{!! url('income/create') !!}",
                data: {
                    type: window.type_id,
                    category_id : $('.gear-add-category option:selected').val(),
                    category_name : $('.gear-add-category option:selected').text(),
                    amount : $('.gear-add-amount').val(),
                    remark : $('.gear-add-remark').val(),
                    date : timeToData,
                    '_token': window.token,
                },
                beforeSend: function () {
                    $('#pnt-loading').show();
                },
                success: function (data) {
                    // console.log(data)
                    $('.gear-add-remark').val('#');
                    $('.gear-add-amount').val('');
                    addDataInTable();
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
            sweetAlert('error' , 'Please Insert Amount!')
        }


    });

    $(document).off('click', '.gear-add-type').on('click', '.gear-add-type', (e) => {
        window.type_id = $('.gear-add-type option:selected').val();
        getDropDown();
    });

    $(document).off('click', '.gear-btn-edit').on('click', '.gear-btn-edit', (e) => {
        window.id = $(e.currentTarget).val();
        console.log(window.id)
        $('.gear-card-add').hide(150);
        $('.gear-card-edit').show(150);
        getDropDown();
        $.ajax({
                type: "get",
                url: "{!! url('income/getHistoryById') !!}/" +  window.id,
                beforeSend: function () {
                    $('#pnt-loading').show();
                },
                success: function (data) {
                console.log(data)

                $('.gear-edit-category option:selected').val(data.dataHistory.category_id).change();
                $('.gear-edit-type option:selected').val(data.dataHistory.type).change();
                var get_time = moment(data.dataHistory.time_date).format("DD MMMM  YYYY");
                $('.gear-edit-pick').val(get_time);
                $('.gear-edit-remark').val(data.dataHistory.remark);
                $('.gear-edit-amount').val(data.dataHistory.amount);
                $('#pnt-loading').hide();
                },
            });
    });

    $(document).off('click', '.gear-btn-delete').on('click', '.gear-btn-delete', (e) => {
        console.log($(e.currentTarget).val())
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
                    url: "{!! url('income/delete') !!}/" +  window.id,
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

    $(document).off('click', '.gear-history-close').on('click', '.gear-history-close', (e) => {
        $('.gear-card-add').show(150);
        $('.gear-card-edit').hide(150);
    });

    $(document).off('click', '.gear-history-edit-save').on('click', '.gear-history-edit-save', (e) => {
        console.log(timeToData)
        window.type_id = $('.gear-edit-type option:selected').val()
        console.log('type id = ',window.type_id)
        console.log($('.gear-edit-category option:selected').val());

        if($('.gear-edit-amount').val() != '' && $('.gear-edit-amount').val() > 0)
        {
            $.ajax({
                type: "post",
                url: "{!! url('income/update') !!}/"+ window.id,
                data: {
                    type: window.type_id,
                    category_id : $('.gear-edit-category option:selected').val(),
                    category_name : $('.gear-edit-category option:selected').text(),
                    amount : $('.gear-edit-amount').val(),
                    remark : $('.gear-edit-remark').val(),
                    date : timeToData,
                    '_token': window.token,
                },
                beforeSend: function () {
                    $('#pnt-loading').show();
                },
                success: function (data) {
                    console.log(data)
                    $('.gear-card-add').show(150);
                    $('.gear-card-edit').hide(150);
                    addDataInTable();
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
            sweetAlert('error' , 'Please Insert Amount!')
        }


    });


</script>
@endsection
