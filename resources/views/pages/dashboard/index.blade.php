@extends('layouts.master')

@section('contents')


<div class="row ">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header border-0 pb-0">
                <h4 class="card-title">Expense Timeline History</h4>
            </div>
            <div class="card-body">
                <div id="DZ_W_TimeLine1" class="widget-timeline dz-scroll style-1" style="height:250px;">
                    <ul class="timeline text-card-timeline">
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Histories Bar Chart</h4>
            </div>
            <div class="card-body">
                <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                        <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                        <div class=""></div>
                    </div>
                </div>
                <canvas id="myChart" width="414" height="207" class="chartjs-render-monitor"
                        style="display: block; width: 414px; height: 207px;"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row ">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">History Line Chart</h4>
            </div>
            <div class="card-body">
                <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                        <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                        <div class=""></div>
                    </div>
                </div>
                <canvas id="myChart_line" width="414" height="207" class="chartjs-render-monitor"
                        style="display: block; width: 414px; height: 207px;"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Expense Category Chart</h4>
            </div>
            <div class="card-body">
                <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                        <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                        <div class=""></div>
                    </div>
                </div>
                <canvas id="myChart_doughnut" width="250" height="175" class="chartjs-render-monitor"
                        style="display: block; width: 414px; height: 207px;"></canvas>
            </div>
        </div>
    </div>


</div>

<div class="row">
    <div class="col-12">
        <div class="card bg-white">
            <div class="card-header">
                <h4 class="card-title text-dark">Histories Information</h4>
                <button type="button" class="btn btn-outline-warning gear-export">Export</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="data_table" style="min-width: 845px">
                        <thead>
                        <tr>
                            <th class="text-dark">#</th>
                            <th class="text-dark">Type</th>
                            <th class="text-dark">Category</th>
                            <th class="text-dark">User</th>
                            <th class="text-dark">Amount</th>
                            <th class="text-dark">Remark</th>
                            <th class="text-dark">Date</th>
                        </tr>
                        </thead>
                        <tbody class="data-section">
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

    var timelineCard = $('.text-card-timeline');
    var dataExpense = [];
    var dataIncome = [];
    var dataExpenseSum = [];
    var dataIncomeSum = [];
    var dataDonutName = [];
    var dataDonutValue = [];
    var data_table = $('#data_table').DataTable();


    $(document).ready(function () {
        dashBoard();
    });

    function dashBoard()
    {
        $.ajax({
                type: "get",
                url: '{!! url('dashboard/getAllDashboard') !!}',
                beforeSend: function () {
                    $('#pnt-loading').show();
                },
                success: function (data) {
                    console.log(data);

                    var dataTimeline = '';
                    var cnt = 0;
                    var date = '';
                    const color = ["primary", "info", "danger", "success", "warning"];
                    $.each(data.dataSet.timeline, function (index, value) {
                        if (cnt > color.length - 1) {
                            cnt = 0;
                        }
                        date = moment(value.time_date).fromNow();
                        dataTimeline += "<li><div class='timeline-badge " + color[cnt] + "'></div><a class='timeline-panel text-muted'><span>" +  date + "<strong>" + " By " + value.user_name + "</strong>" + "</span><h6 class='mb-0'>" + value.amount.toLocaleString()  + "</h6></a></li>"
                        cnt++;
                    });
                    window.timelineCard.append(dataTimeline);


                    window.data_table.destroy();
                    $('.data-section').html(null);
                    $.each(data.dataSet.history, function (index, value) {
                        var historyHtml =
                            '<tr><td>' +
                            (index+1) +
                            '</td><td>'+
                            (value.type == 0 ? "EXPENSE" : "INCOME") +
                            '</td><td>'+
                            value.category_name +
                            '</td><td>'+
                            value.user_name +
                            '</td><td>'+
                            value.amount +
                            '</td><td>'+
                            value.remark +
                            '</td><td>'+
                            moment(value.time_date).format("DD MMMM  YYYY") +
                            '</td></tr>';
                        $('.data-section').append(historyHtml);
                    });
                    data_table = $('#data_table').DataTable();

                    window.dataExpense = data.dataSet.expense;
                    window.dataIncome = data.dataSet.income;
                    window.dataExpenseSum = data.dataSet.expenseSum;
                    window.dataIncomeSum = data.dataSet.incomeSum;
                    window.dataDonutName = data.dataSet.nameCatSet;
                    window.dataDonutValue = data.dataSet.sumCatSet;
                    callDoughnutChart(data.dataSet.nameCatSet, data.dataSet.color, data.dataSet.sumCatSet)
                    callBarChart();
                    callLineChart();
                    $('#pnt-loading').hide();
                }
            });
    }


    function callBarChart() {
            var ctx = document.getElementById('myChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Fab', 'Mach', 'April', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: "EXPENSE",
                        backgroundColor: 'rgba(255, 99, 132 , 0.2)',
                        borderColor: 'rgba(255, 99, 132)',
                        data: window.dataExpense
                    },
                    {
                        label: "INCOME",
                        backgroundColor: 'rgba(255, 206, 86 , 0.2)',
                        borderColor: 'rgba(255, 206, 86)',
                        data: window.dataIncome
                    },
                    ]
                },
                // Configuration options go here
                options: {}
            });
        }

        function callLineChart() {
            var ctx = document.getElementById('myChart_line').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fab', 'Mach', 'April', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: "EXPENSE",
                        backgroundColor: 'rgba(255, 99, 132 , 0.2)',
                        borderColor: 'rgba(255, 99, 132)',
                        data: window.dataExpenseSum
                    },
                    {
                        label: "INCOME",
                        backgroundColor: 'rgba(255, 206, 86 , 0.2)',
                        borderColor: 'rgba(255, 206, 86)',
                        data: window.dataIncomeSum
                    },
                    ]
                },
                // Configuration options go here
                options: {}
            });
        }

        function callDoughnutChart(name, color, data) {
            var ctx_Dough = document.getElementById('myChart_doughnut').getContext('2d');
            var chart_DoughnutChart = new Chart(ctx_Dough, {
                type: 'doughnut',
                data: {
                    labels: name,
                    datasets: [{
                        label: name,
                        backgroundColor: color,
                        data: data
                    }]
                },
                options: {}
            });
        }

</script>


@endsection
