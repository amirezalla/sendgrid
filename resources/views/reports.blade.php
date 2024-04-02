@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card our-user">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="flex-grow-1">
                            <p class="square-after f-w-600 header-text-primary"> Our Total Users Usage
                                <i class="fa fa-circle"></i>
                            </p>
                            <h4> 100% </h4>
                        </div>
                        @php
                            use App\Models\Smtp; // Adjust the namespace according to your application's structure
use Illuminate\Support\Facades\DB;

$smtpUsage = Smtp::select(
    'domain',
    'username',
    'usage',
    DB::raw('(`usage` / (SELECT SUM(`usage`) FROM smtp) * 100) AS usage_percentage'),
)->get();
$usagePercentages = $smtpUsage->pluck('usage_percentage');
$domains = $smtpUsage->pluck('domain');

                        @endphp

                        <div class="setting-list">
                            <a class="btn btn-sm btn-primary" href="/export-maillogs"><i class='fa fa-download'></i> Download
                                Log</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="smtp-chart">
                        <div id="smtpUsageChart"></div>
                        <div class="icon-donut">
                            <i class="feather feather-arrow-up-circle">
                        </div>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Domain</th>
                            <th>User</th>
                            <th>Usage</th>
                            <th>Usage Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($smtpUsage as $usage)
                            <tr>
                                <td>{{ $usage->domain }}</td>
                                <td>{{ $usage->username }}</td>
                                <td>{{ $usage->usage }}</td>
                                <td>{{ number_format($usage->usage_percentage, 2) }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>




    <script>
        var options = {
            chart: {
                type: 'bar',
                height: 350
            },
            series: [{
                name: 'Usage Percentage',
                data: @json($usagePercentages)
            }],
            xaxis: {
                categories: @json($domains)
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + "%"
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#smtpUsageChart"), options);
        chart.render();
    </script>
@endsection
