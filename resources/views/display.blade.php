@extends('layout')
@section('title')
    หน้าแสดงผล
@endsection
@section('content')
    <div class="container mt-3 w-100">
        <ul class="nav border border-1 shadow-sm rounded-3 fs-3 mb-3 d-flex align-items-center">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ route('welcome') }}">
                    <i class="bi bi-arrow-left-circle-fill text-dark"></i>
                </a>
            </li>
            <li class="nav-item d-flex align-items-center">
                <p class="mb-0">หน้าแสดงการทำงาน</p>
            </li>
        </ul>
        <div>
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="row p-2">
                        <div class="col-12">
                            สถานะโดยรวม
                        </div>
                    </div>
                    <div class="w-100">
                        <div class="position-relative" style="aspect-ratio: 16/9;">
                            <canvas id="allStatusChart" class="position-absolute top-0 start-0 w-100 h-100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2 g-2 mt-2">
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        น้ำหนักของผลิตภัณฑ์ 2.38g
                        <i class="bi bi-train-lightrail-front-fill"></i>
                        <div class="w-100">
                            <div class="position-relative" style="aspect-ratio: 16/6;">
                                <canvas id="weightChart" class="position-absolute top-0 start-0 w-100 h-100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm p-2">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col text-start">
                                <span>สถานะการทำงาน</span>
                            </div>
                            <div class="col text-end">
                                <span>กำลังทำงาน</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col text-start">
                                <label class="form-label mb-0">เปิดปิดการทำงาน</label>
                            </div>
                            <div class="col text-end">
                                <div class="form-check form-switch d-inline-block">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="flexSwitchCheckChecked" checked>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="{{ route('history') }}" type="button" class="btn btn-primary">ข้อมูลย้อนหลัง</a>
                            <a href="{{ route('setting') }}" type="button" class="btn btn-primary">การตั้งค่า</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-2 mt-2">
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <p>อุณหภูมิภายในตู้ 68 องศาเซลเซียส</p>
                        <i class="bi bi-thermometer-sun"></i>
                        <div class="w-100">
                            <div class="position-relative" style="aspect-ratio: 16/6;">
                                <canvas id="tempChart" class="position-absolute top-0 start-0 w-100 h-100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <p>ความชื้นสัมพัทธ์ 50%</p>
                        <i class="bi bi-droplet-half"></i>
                        <div class="w-100">
                            <div class="position-relative" style="aspect-ratio: 16/6;">
                                <canvas id="humidityChart" class="position-absolute top-0 start-0 w-100 h-100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <p>ความเข้มแสง 369</p>
                        <i class="bi bi-brightness-high-fill"></i>
                        <div class="w-100">
                            <div class="position-relative" style="aspect-ratio: 16/6;">
                                <canvas id="lightChart" class="position-absolute top-0 start-0 w-100 h-100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        async function fetchData() {
            const response = await fetch('/get-esp32-data');
            const data = await response.json();

            if (!Array.isArray(data) || data.length === 0) {
                console.log("❌ ไม่มีข้อมูลจากเซ็นเซอร์");
                return;
            }

            const labels = data.map(item => new Date(item.created_at).toLocaleTimeString());
            const temperatures = data.map(item => item.temperature);
            const humidities = data.map(item => item.humidity);
            const lightIntensities = data.map(item => item.LightIntensity);
            const weights = data.map(item => item.weight);

            updateChart(tempChart, labels, temperatures);
            updateChart(humidityChart, labels, humidities);
            updateChart(lightChart, labels, lightIntensities);
            updateChart(weightChart, labels, weights);
            updateAllStatusChart(labels, temperatures, humidities, lightIntensities, weights);
        }

        function updateChart(chart, labels, data) {
            chart.data.labels = labels.reverse();
            chart.data.datasets[0].data = data.reverse();
            chart.update();
        }

        function updateAllStatusChart(labels, temp, hum, light, weight) {
            labels.reverse(); // กลับลำดับข้อมูล
            allStatusChart.data.labels = labels;
            allStatusChart.data.datasets[0].data = temp;
            allStatusChart.data.datasets[1].data = hum;
            allStatusChart.data.datasets[2].data = light;
            allStatusChart.data.datasets[3].data = weight;
            allStatusChart.update();
        }

        const createChart = (id, label, color) => {
            return new Chart(document.getElementById(id).getContext('2d'), {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label,
                        data: [],
                        borderColor: color,
                        fill: false
                    }]
                },
                options: {
                    responsive: false,
                    scales: {
                        x: {
                            reverse: true // ตั้งค่าให้แกน X เรียงข้อมูลจากขวาไปซ้าย
                        }
                    }
                }
            });
        };

        const tempChart = createChart('tempChart', 'อุณหภูมิ (°C)', 'red');
        const humidityChart = createChart('humidityChart', 'ความชื้น (%)', 'blue');
        const lightChart = createChart('lightChart', 'ความเข้มแสง', 'yellow');
        const weightChart = createChart('weightChart', 'น้ำหนัก (g)', 'cyan');

        const allStatusChart = new Chart(document.getElementById('allStatusChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                        label: 'อุณหภูมิ (°C)',
                        borderColor: 'red',
                        data: []
                    },
                    {
                        label: 'ความชื้น (%)',
                        borderColor: 'blue',
                        data: []
                    },
                    {
                        label: 'ความเข้มแสง',
                        borderColor: 'yellow',
                        data: []
                    },
                    {
                        label: 'น้ำหนัก (g)',
                        borderColor: 'cyan',
                        data: []
                    }
                ]
            },
            options: {
                responsive: true
            }
        });

        setInterval(fetchData, 5000);
    </script>
@endsection
