<?= $this->extend('layout/user') ?>

<?= $this->section('content') ?>
<h1 class="mb-4">Booking Saya</h1>

<?php if (empty($bookings)): ?>
    <div class="alert alert-info text-center" role="alert">
        Anda belum memiliki booking.
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-danger text-white">
                <tr>
                    <th>ID Booking</th>
                    <th>Lapangan</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Total Harga</th>
                    <th>Status Pembayaran</th>
                    <th>Status Booking</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?= esc($booking['id']) ?></td>
                        <td><?= esc($booking['lapangan_name']) ?></td>
                        <td><?= esc(date('d M Y', strtotime($booking['booking_date']))) ?></td>
                        <td><?= esc(date('H:i', strtotime($booking['start_time']))) ?> - <?= esc(date('H:i', strtotime($booking['end_time']))) ?></td>
                        <td>Rp<?= number_format($booking['total_price'], 0, ',', '.') ?></td>
                        <td>
                            <?php
                            $paymentStatusClass = '';
                            switch ($booking['payment_status']) {
                                case 'Menunggu Konfirmasi':
                                    $paymentStatusClass = 'badge bg-warning text-dark';
                                    break;
                                case 'Sudah Dibayar':
                                    $paymentStatusClass = 'badge bg-info text-dark';
                                    break;
                                case 'Disetujui':
                                    $paymentStatusClass = 'badge bg-success';
                                    break;
                                case 'Ditolak':
                                    $paymentStatusClass = 'badge bg-danger';
                                    break;
                            }
                            ?>
                            <span class="<?= $paymentStatusClass ?>"><?= esc(ucfirst($booking['payment_status'])) ?></span>
                        </td>
                        <td>
                            <?php
                            $bookingStatusClass = '';
                            switch ($booking['booking_status']) {
                                case 'Menunggu Konfirmasi':
                                    $bookingStatusClass = 'badge bg-secondary';
                                    break;
                                case 'Disetujui':
                                    $bookingStatusClass = 'badge bg-success';
                                    break;
                                case 'Ditolak':
                                    $bookingStatusClass = 'badge bg-danger';
                                    break;
                                case 'Selesai':
                                    $bookingStatusClass = 'badge bg-primary';
                                    break;
                                case 'Dibatalkan':
                                    $bookingStatusClass = 'badge bg-dark';
                                    break;
                            }
                            ?>
                            <span class="<?= $bookingStatusClass ?>"><?= esc(ucfirst($booking['booking_status'])) ?></span>
                        </td>
                        <td>
                            <?php if ($booking['payment_status'] == 'Menunggu Konfirmasi'): ?>
                                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#uploadPaymentModal<?= $booking['id'] ?>">
                                    Upload Bukti Bayar
                                </button>
                                <div class="modal fade" id="uploadPaymentModal<?= $booking['id'] ?>" tabindex="-1" aria-labelledby="uploadPaymentModalLabel<?= $booking['id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="uploadPaymentModalLabel<?= $booking['id'] ?>">Upload Bukti Pembayaran #<?= esc($booking['id']) ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Total yang harus dibayar: <strong>Rp<?= number_format($booking['total_price'], 0, ',', '.') ?></strong></p>
                                                <p>Silakan transfer ke rekening: BCA - 0000000000 A.N. Lapanganku</p>
                                                <form action="<?= base_url('booking/upload-payment/' . $booking['id']) ?>" method="post" enctype="multipart/form-data">
                                                    <?= csrf_field() ?>
                                                    <div class="mb-3">
                                                        <label for="payment_proof" class="form-label">Pilih File Bukti Pembayaran (JPG/PNG, maks 2MB)</label>
                                                        <input class="form-control" type="file" id="payment_proof" name="payment_proof" accept=".jpg, .jpeg, .png" required>
                                                    </div>
                                                    <div class="d-grid">
                                                        <button type="submit" class="btn btn-danger">Unggah Bukti</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php elseif ($booking['payment_status'] == 'paid'): ?>
                                <span class="text-info small">Menunggu verifikasi admin</span>
                            <?php elseif ($booking['payment_status'] == 'rejected'): ?>
                                <span class="text-danger small">Pembayaran ditolak. Silakan hubungi admin.</span>
                            <?php endif; ?>

                            <?php if ($booking['payment_proof']): ?>
                                <a href="<?= base_url($booking['payment_proof']) ?>" target="_blank" class="btn btn-sm btn-outline-primary mt-1">Lihat Bukti</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>