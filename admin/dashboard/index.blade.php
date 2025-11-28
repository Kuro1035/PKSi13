@extends('layout.adminlayouts')

@section('title', 'Dashboard')

@push('styles')
<!-- Styles khusus untuk mencegah "goyang" / resize chart -->
<style>
/* Pastikan scrollbar vertikal selalu ada untuk menghindari content shift */
html { overflow-y: scroll; }

/* Atur tinggi chart agar tidak ikut resize otomatis */
.chart {
    max-height: 350px;
    height: 350px !important;
    display: block;
}

/* Untuk card-body agar canvas tidak saling dorong */
.card-body.d-flex-chart {
    display: flex !important;
    flex-direction: column;
    align-items: stretch;
    justify-content: center;
    padding: 1rem;
}
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fa fa-tachometer"></i> Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <button class="btn btn-sm btn-primary">Share</button>
            <button class="btn btn-sm btn-primary">Export</button>
        </div>
        <button class="btn btn-sm btn-primary dropdown-toggle">
            <i class="fa fa-calendar"></i>
            This week
        </button>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-12 pr-0 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-header"><i class="fa fa-user-plus"></i> Pengguna Registrasi</div>
            <div class="card-body">
                <h3 class="card-title">{{ $userRegistrations ?? 44 }}</h3>
            </div>
            <a class="card-footer text-right text-white" href="{{ route('admin.users') }}">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-12 pr-0 mb-3">
        <div class="card text-white bg-info">
            <div class="card-header"><i class="fa fa-user-plus"></i> welcome najwa</div>
            <div class="card-body">
                <h3 class="card-title">{{ $dosenRegistrations ?? 44 }}</h3>
            </div>
            <a class="card-footer text-right text-white" href="{{ route('admin.users') }}">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-12 pr-0 mb-3">
        <div class="card text-white bg-success">
            <div class="card-header"><i class="fa fa-user-plus"></i> Admin ardi</div>
            <div class="card-body">
                <h3 class="card-title">{{ $adminRegistrations ?? 44 }}</h3>
            </div>
            <a class="card-footer text-right text-white" href="{{ route('admin.users') }}">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>

        <!-- ===================== PERUBAHAN DITAMBAHKAN DI SINI ===================== -->
    <div class="col-lg-3 col-md-3 col-sm-12 pr-0 mb-3"> <!-- Tambahan card baru -->
        <div class="card text-white bg-primary"> <!-- Warna card baru -->
            <div class="card-header"><i class="fa fa-eye"></i> Total Pengunjung</div> <!-- Judul baru -->
            <div class="card-body">
                <h3 class="card-title">{{ $totalVisitors ?? 120 }}</h3> <!-- Data baru -->
            </div>
            <a class="card-footer text-right text-white" href="#">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a> <!-- Link baru -->
        </div>
    </div>
    <!-- ======================================================================== -->

    <div class="col-lg-3 col-md-3 col-sm-12 pr-0 mb-3">
        <div class="card text-white bg-danger">
<<<<<<< HEAD
            <div class="card-header"><i class="fa fa-user-plus"></i> ardi</div>
=======
            <div class="card-header"><i class="fa fa-user-plus"></i> jua /div>
>>>>>>> bac21b52092266a08d7baa6262f0eb61233ddb9b
            <div class="card-body">
                <h3 class="card-title">{{ $approvedRegistrations ?? 65 }}</h3>
            </div>
            <a class="card-footer text-right text-white" href="{{ route('admin.users') }}">More info 
                <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 pr-0 mb-3">
        <div class="card-collapsible card">
            <div class="card-header">Doughnut Chart</div>
            <div class="card-body d-flex flex-column">
    <canvas class="chart w-100" id="pieChart"></canvas>
</div>

        </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-12 pr-0 mb-3">
        <div class="card-collapsible card">
            <div class="card-header">Bar Chart</div>
            <div class="card-body d-flex-chart">
                <canvas class="chart w-100" id="barChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Ambil data dari variabel PHP
const userRegistrations = <?= json_encode($userRegistrations) ?> || [];
const dosenRegistrations = <?= json_encode($dosenRegistrations) ?> || [];
const adminRegistrations = <?= json_encode($adminRegistrations) ?> || [];

// Hitung total untuk persentase
const totalRegistrations = userRegistrations + dosenRegistrations + adminRegistrations;

// Data untuk doughnut chart
const pieCtx = document.getElementById('pieChart').getContext('2d');
new Chart(pieCtx, {
    type: 'doughnut',
    data: {
        labels: ['User', 'Dosen', 'Admin'],
        datasets: [{
            data: [userRegistrations, dosenRegistrations, adminRegistrations],
            backgroundColor: [
                '#ffc107', // Warning color for User
                '#17a2b8', // Info color for Dosen
                '#28a745'  // Success color for Admin
            ]
        }]
    },
    options: {
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var dataset = data.datasets[tooltipItem.datasetIndex];
                    var total = dataset.data.reduce(function(previousValue, currentValue) {
                        return previousValue + currentValue;
                    });
                    var currentValue = dataset.data[tooltipItem.index];
                    var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                    return data.labels[tooltipItem.index] + ': ' + percentage + '%';
                }
            }
        }
    }
});

const barCtx = document.getElementById('barChart').getContext('2d');
new Chart(barCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($dates) ?>,
        datasets: [{
            label: 'Jumlah Pengunjung',
            data: <?= json_encode($visitorsData) ?>,
            backgroundColor: '#007bff'
        }]
    },
    options: {
        responsive: true,
        scales: {
            yAxes: [{
                ticks: { beginAtZero:true }
            }]
        }
    }
});

</script>
@endpush