@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Historical Data for {{ $symbol }}</h2>
    <p>From {{ $startDate }} to {{ $endDate }}</p>

    @if (isset($historicalData) && count($historicalData) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Open</th>
                    <th>High</th>
                    <th>Low</th>
                    <th>Close</th>
                    <th>Volume</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($historicalData as $dataPoint)
                    <tr>
                        <td>{{ $dataPoint['date'] }}</td>
                        <td>{{ $dataPoint['open'] }}</td>
                        <td>{{ $dataPoint['high'] }}</td>
                        <td>{{ $dataPoint['low'] }}</td>
                        <td>{{ $dataPoint['close'] }}</td>
                        <td>{{ $dataPoint['volume'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No historical data available.</p>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <canvas id="priceChart"></canvas>
<script>
    // Get the canvas element
    var ctx = document.getElementById('priceChart').getContext('2d');

    // Debug: Log data to console
    console.log('Historical Data:', <?php echo json_encode($historicalData); ?>);
    console.log('Open Prices:', <?php echo json_encode($openPrices); ?>);
    console.log('Close Prices:', <?php echo json_encode($closePrices); ?>);

    Chart.defaults.global.plugins.datalabels = {
    formatter: function(value, context) {
        // Customize label formatting if needed
        return value;
    },
    };

    Chart.defaults.global.plugins.tooltip = {
    // Customize tooltip options if needed
    };


    // Initialize the chart
    var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode(array_keys($historicalData)); ?>,
        datasets: [
            {
                label: 'Open Price',
                data: <?php echo json_encode($openPrices); ?>,
                borderColor: 'rgba(75, 192, 192, 1)',
                fill: false,
            },
            {
                label: 'Close Price',
                data: <?php echo json_encode($closePrices); ?>,
                borderColor: 'rgba(255, 99, 132, 1)',
                fill: false,
            },
        ],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                type: 'time', // Use time scale for X-axis if dates are in timestamp format
                time: {
                unit: 'day', // Display labels by day
                },
            },
        },
    },
    });

</script>

    


</div>
@endsection
