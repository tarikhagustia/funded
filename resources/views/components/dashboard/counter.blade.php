<div class="card text-white {{ $color }}">
    <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
        <div>
            <div class="text-value-lg">{{ $value }}</div>
            <div>{{ $label }}</div>
        </div>
    </div>
    <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
        <div class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand"><div class=""></div></div>
            <div class="chartjs-size-monitor-shrink"><div class=""></div></div>
        </div>
        <canvas class="chart chartjs-render-monitor" id="{{ $id }}" height="70" style="display: block; width: 208px; height: 70px;" width="208"></canvas>
    </div>
</div>

@push('javascript')
<script>
    var cardChart1 = new Chart(document.getElementById('{{ $id }}'), {
        type: 'line',
        data: {
            labels: [1, 2, 3, 4, 5, 6, 7],
            datasets: [{
                label: 'Locations',
                backgroundColor: 'transparent',
                borderColor: 'rgba(255,255,255,.55)',
                pointBackgroundColor: '#ffffff',
                data: JSON.parse('{{ json_encode($chartData) }}')
            }]
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    gridLines: {
                    color: 'transparent',
                    zeroLineColor: 'transparent'
                    },
                    ticks: {
                    fontSize: 2,
                    fontColor: 'transparent'
                    }
                }],
                yAxes: [{
                    display: false,
                    ticks: {
                    display: false,
                    min: 35,
                    max: 89
                    }
                }]
            },
            elements: {
                line: {
                    borderWidth: 1
                },
                point: {
                    radius: 4,
                    hitRadius: 10,
                    hoverRadius: 4
                }
            },
            tooltips: {
                enabled: false
            },
            hover: {
                mode: null
            },
        },
    });
</script>
@endpush