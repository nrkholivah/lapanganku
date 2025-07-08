<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-3">
        <?= $this->include('admin/sidebar') ?>
    </div>
    <div class="col-md-9">
        <h1 class="mb-4">Laporan & Grafik</h1>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Grafik Penggunaan Lapangan</h5>
            </div>
            <div class="card-body">
                <canvas id="lapanganUsageChart"></canvas>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Laporan Semua Booking</h5>
            </div>
            <div class="card-body text-center">
                <a href="<?= base_url('admin/reports/download') ?>" class="btn btn-danger">
                    <i class="bi bi-download"></i> Download Laporan PDF
                </a>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lapanganNames = <?= $lapangan_names ?>;
        const bookingCounts = <?= $booking_counts ?>;

        const ctx = document.getElementById('lapanganUsageChart').getContext('2d');
        new Chart(ctx, {
            type: 'line', // Bisa diganti 'line', 'pie', dll.
            data: {
                labels: lapanganNames,
                datasets: [{
                    label: 'Jumlah Booking',
                    data: bookingCounts,
                    backgroundColor: 'rgba(220, 53, 69, 0.7)',
                    borderColor: 'rgba(220, 53, 69, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Booking'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Nama Lapangan'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Grafik Jumlah Booking per Lapangan'
                    }
                }
            }
        });
    });
</script>
<?= $this->endSection() ?>