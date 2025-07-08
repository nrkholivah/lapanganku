<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-3">
        <?= $this->include('admin/sidebar') ?>
    </div>
    <div class="col-md-9">
        <h1 class="mb-4">Dashboard Admin</h1>

        <div class="row mb-4">
            <div class="col-md-6 col-lg-3 mb-3">
                <div class="card text-white bg-primary shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-users"></i> Total Pengguna</h5>
                        <p class="card-text fs-3"><?= esc($total_users) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-3">
                <div class="card text-white bg-success shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-futbol"></i> Total Lapangan</h5>
                        <p class="card-text fs-3"><?= esc($total_lapangan) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-3">
                <div class="card text-white bg-info shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-calendar-check"></i> Total Booking</h5>
                        <p class="card-text fs-3"><?= esc($total_bookings) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-3">
                <div class="card text-white bg-warning shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-hourglass-half"></i> Pembayaran Pending</h5>
                        <p class="card-text fs-3"><?= esc($pending_payments) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Booking Terbaru</h5>
            </div>
            <div class="card-body">
                <?php if (empty($recent_bookings)): ?>
                    <p class="text-center">Belum ada booking terbaru.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Pengguna</th>
                                    <th>Lapangan</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Status Pembayaran</th>
                                    <th>Status Booking</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_bookings as $booking): ?>
                                    <tr>
                                        <td><?= esc($booking['id']) ?></td>
                                        <td><?= esc($booking['username']) ?></td>
                                        <td><?= esc($booking['lapangan_name']) ?></td>
                                        <td><?= esc(date('d M Y', strtotime($booking['booking_date']))) ?></td>
                                        <td><?= esc(date('H:i', strtotime($booking['start_time']))) ?> - <?= esc(date('H:i', strtotime($booking['end_time']))) ?></td>
                                        <td><span class="badge bg-<?= ($booking['payment_status'] == 'approved') ? 'success' : (($booking['payment_status'] == 'pending') ? 'warning text-dark' : 'danger') ?>"><?= esc(ucfirst($booking['payment_status'])) ?></span></td>
                                        <td><span class="badge bg-<?= ($booking['booking_status'] == 'approved') ? 'success' : (($booking['booking_status'] == 'pending') ? 'secondary' : 'danger') ?>"><?= esc(ucfirst($booking['booking_status'])) ?></span></td>
                                        <td>
                                            <a href="<?= base_url('admin/bookings/detail/' . $booking['id']) ?>" class="btn btn-sm btn-outline-primary">Detail</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>