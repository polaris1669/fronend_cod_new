@extends('layout')
@section('title')
    หน้าแรก
@endsection
@section('content')
    <div class="contianer mt-3 w-100">

        <ul class="nav border border-1 shadow-sm rounded-3 fs-3 mb-3 d-flex align-items-center">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ route('display') }}">
                    <i class="bi bi-arrow-left-circle-fill text-dark"></i>
                </a>
            </li>
            <li class="nav-item d-flex align-items-center">
                <p class="mb-0">ประวัติย้อนหลัง</p>
            </li>
        </ul>

        <ul class="nav justify-content-center align-items-center fs-3">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-chevron-left text-primary"></i>
                </a>
            </li>
            <li class="nav-item mx-3">
                <span class="text-dark">29/07/2024</span>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="bi bi-chevron-right text-primary"></i>
                </a>
            </li>
        </ul>

        <div class="card mb-3">
            <div class="card-header">
                <div class="row p-2">
                    <div class="col-12">
                        น้ำหนักของผลิตภัณฑ์ 2.38g
                        <i class="bi bi-train-lightrail-front-fill"></i>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="w-100 ">
                    <div class="position-relative" style="aspect-ratio: 16/9;">
                        <canvas id="weightChart" class="position-absolute top-0 start-0 w-100 h-100"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                <div class="row p-2">
                    <div class="col-12">
                        อุณหภูมิภายในตู้ 68 องศาเซลเซียส
                        <i class="bi bi-thermometer-sun"></i>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="w-100">
                    <div class="position-relative" style="aspect-ratio: 16/6;">
                        <canvas id="tempChart" class="position-absolute top-0 start-0 w-100 h-100"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                <div class="row p-2">
                    <div class="col-12">
                        ความชื้นสัมพัทธ์ 50%
                        <i class="bi bi-droplet-half"></i>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="w-100">
                    <div class="position-relative" style="aspect-ratio: 16/6;">
                        <canvas id="humidityChart" class="position-absolute top-0 start-0 w-100 h-100"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                <div class="row p-2">
                    <div class="col-12">
                        ความเข้มแสง 369
                        <i class="bi bi-brightness-high-fill"></i>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="w-100">
                    <div class="position-relative" style="aspect-ratio: 16/6;">
                        <canvas id="lightChart" class="position-absolute top-0 start-0 w-100 h-100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data สำหรับกราฟ
        const data = {
            labels: ['10:00', '10:10', '10:20', '10:30', '10:40', '10:50'], // แสดงเวลาเป็นทุก 10 นาที
            datasets: [{
                label: 'น้ำหนัก (g)',
                data: [2.35, 2.36, 2.38, 2.37, 2.39, 2.38], // น้ำหนักในกรัม
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.3,
                fill: true
            }]
        };

        // Config สำหรับกราฟ
        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'เวลา (นาที)'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'น้ำหนัก (g)'
                        },
                        beginAtZero: false
                    }
                }
            }
        };

        // กราฟอุณหภูมิ
        new Chart(document.getElementById('tempChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: ['10:00', '10:10', '10:20', '10:30', '10:40', '10:50'],
                datasets: [{
                    label: 'อุณหภูมิ (°C)',
                    data: [66, 67, 68, 69, 70, 68],
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        title: {
                            display: true,
                            text: 'อุณหภูมิ (°C)'
                        }
                    }
                }
            }
        });

        // กราฟความชื้นสัมพัทธ์
        new Chart(document.getElementById('humidityChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: ['10:00', '10:10', '10:20', '10:30', '10:40', '10:50'],
                datasets: [{
                    label: 'ความชื้นสัมพัทธ์ (%)',
                    data: [45, 46, 48, 50, 49, 50],
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'ความชื้นสัมพัทธ์ (%)'
                        }
                    }
                }
            }
        });

        // กราฟความเข้มแสง
        new Chart(document.getElementById('lightChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: ['10:00', '10:10', '10:20', '10:30', '10:40', '10:50'],
                datasets: [{
                    label: 'ความเข้มแสง',
                    data: [350, 360, 365, 370, 375, 369],
                    borderColor: 'rgba(255, 206, 86, 1)',
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'ความเข้มแสง'
                        }
                    }
                }
            }
        });
        // Render กราฟ
        const ctx = document.getElementById('weightChart').getContext('2d');
        new Chart(ctx, config);
    </script>
@endsection
