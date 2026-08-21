<?= $this->extend('layout/admin_template') ?>

<?= $this->section('content') ?>
<div class="row">
    <!-- Box Total Kamar -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info shadow-sm">
            <div class="inner">
                <h3><?= $total_kamar; ?></h3>
                <p>Total Kamar</p>
            </div>
            <div class="icon"><i class="fas fa-bed"></i></div>
            <a href="<?= base_url('admin/kamar') ?>" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Box Kamar Terisi -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger shadow-sm">
            <div class="inner">
                <h3><?= $kamar_terisi; ?></h3>
                <p>Kamar Terisi</p>
            </div>
            <div class="icon"><i class="fas fa-user-check"></i></div>
            <a href="<?= base_url('admin/kamar') ?>" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Box Kamar Kosong -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success shadow-sm">
            <div class="inner">
                <h3><?= $kamar_kosong; ?></h3>
                <p>Kamar Kosong</p>
            </div>
            <div class="icon"><i class="fas fa-door-open"></i></div>
            <a href="<?= base_url('admin/kamar') ?>" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <!-- Box Pendapatan -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary shadow-sm">
            <div class="inner">
                <h3><sup style="font-size: 20px">Rp</sup> <?= number_format($pendapatan_bulan_ini, 0, ',', '.'); ?></h3>
                <p>Pendapatan Lunas</p>
            </div>
            <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
            <a href="<?= base_url('admin/transaksi') ?>" class="small-box-footer">Ke Transaksi <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<!-- Area Grafik Pendapatan -->
<div class="row mt-3">
    <div class="col-12">
        <div class="card card-primary card-outline shadow-sm">
            <div class="card-header border-0 d-flex justify-content-between align-items-center bg-white">
                <h3 class="card-title fw-bold text-dark m-0">
                    <i class="fas fa-chart-line text-primary mr-2"></i>Grafik Pendapatan Tahun <?= esc($tahun_ini); ?>
                </h3>
            </div>
            <div class="card-body">
                <div style="position: relative; height: 320px; width: 100%;">
                    <canvas id="incomeChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('incomeChart').getContext('2d');
        const dataPendapatan = <?= json_encode($grafik_pendapatan ?? array_fill(0, 12, 0)); ?>;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: dataPendapatan,
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.12)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#007bff',
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ' Pendapatan: Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000).toLocaleString('id-ID') + 'k';
                            }
                        },
                        grid: {
                            color: '#e9ecef'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    });
</script>
<?= $this->endSection() ?>