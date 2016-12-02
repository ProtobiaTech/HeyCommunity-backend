@extends('layouts.dashboard')

@section('content')
<script src="{{ asset('bower-assets/chart.js/dist/Chart.min.js') }}"></script>
<div class="container">
    <div class="text-center">
        <br><br>
        <h2>The Trends</h2>
        <br>

        <canvas id="trend" width="400" height="140"></canvas>
        <script>
        var ctx = document.getElementById("trend");

        function renderTrendChart(data) {
            var trendChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.label,
                    datasets: data.datasets,
                }
            });
        }

        $.ajax({
            type: 'GET',
            url: '/dashboard/trend/all-tenant-trend',
            success: function(response, status, xhr) {
                renderTrendChart(response);
            },
            error: function() {
                alert('the trend render fail');
            }
        })
        </script>
    </div>
</div>
@endsection

