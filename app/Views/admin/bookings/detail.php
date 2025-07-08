<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-3">
        <?= $this->include('admin/sidebar') ?>
    </div>
    <div class="col-md-9">
        <h1 class="mb-4">Detail Booking #<?= esc($booking['id']) ?></h1>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Informasi Booking</h5>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">Pengguna</div>
                    <div class="col-sm-8"><?= esc($booking['username']) ?> (<?= esc($booking['email']) ?>)</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">No. HP</div>
                    <div class="col-sm-8"><?= esc($booking['no_hp']) ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">Lapangan</div>
                    <div class="col-sm-8"><?= esc($booking['lapangan_name']) ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">Tanggal Booking</div>
                    <div class="col-sm-8"><?= esc(date('d M Y', strtotime($booking['booking_date']))) ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">Waktu Booking</div>
                    <div class="col-sm-8"><?= esc(date('H:i', strtotime($booking['start_time']))) ?> - <?= esc(date('H:i', strtotime($booking['end_time']))) ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">Harga per Jam</div>
                    <div class="col-sm-8">Rp<?= number_format($booking['price_per_hour'], 0, ',', '.') ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">Total Harga</div>
                    <div class="col-sm-8"><strong>Rp<?= number_format($booking['total_price'], 0, ',', '.') ?></strong></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">Status Pembayaran</div>
                    <div class="col-sm-8">
                        <?php
                        $paymentStatusClass = match ($booking['payment_status']) {
                            'Menunggu Konfirmasi' => 'badge bg-warning text-dark',
                            'Sudah Dibayar'    => 'badge bg-info text-dark',
                            'Disetujui' => 'badge bg-success',
                            'Ditolak' => 'badge bg-danger',
                            default   => 'badge bg-secondary'
                        };
                        ?>
                        <span class="<?= $paymentStatusClass ?>"><?= esc(ucfirst($booking['payment_status'])) ?></span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">Status Booking</div>
                    <div class="col-sm-8">
                        <?php
                        $bookingStatusClass = match ($booking['booking_status']) {
                            'Menunggu Konfirmasi'   => 'badge bg-secondary',
                            'Disetujui'  => 'badge bg-success',
                            'Ditolak'  => 'badge bg-danger',
                            'Selesai' => 'badge bg-primary',
                            'Dibatalkan' => 'badge bg-dark',
                            default     => 'badge bg-light'
                        };
                        ?>
                        <span class="<?= $bookingStatusClass ?>"><?= esc(ucfirst($booking['booking_status'])) ?></span>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">Dibuat Pada</div>
                    <div class="col-sm-8"><?= esc(date('d M Y H:i', strtotime($booking['created_at']))) ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 fw-bold">Terakhir Diperbarui</div>
                    <div class="col-sm-8"><?= esc(date('d M Y H:i', strtotime($booking['updated_at']))) ?></div>
                </div>
            </div>

        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Bukti Pembayaran</h5>
            </div>
            <div class="card-body text-center">
                <?php if ($booking['payment_proof']): ?>
                    <img src="<?= base_url($booking['payment_proof']) ?>" class="img-fluid rounded" alt="Bukti Pembayaran" style="max-height: 400px;">
                    <p class="mt-3"><a href="<?= base_url($booking['payment_proof']) ?>" target="_blank" class="btn btn-outline-primary">Lihat Gambar Ukuran Penuh</a></p>
                <?php else: ?>
                    <p class="text-muted">Belum ada bukti pembayaran diunggah.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Aksi Admin</h5>
            </div>
            <div class="card-body">
                <?php if ($booking['payment_status'] == 'Sudah Dibayar' || $booking['payment_status'] == 'Menunggu Konfirmasi'): ?>
                    <p><strong>Catatan Admin:</strong></p>
                    <form action="<?= base_url('admin/bookings/approve-payment/' . $booking['id']) ?>" method="post" class="mb-3">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <textarea name="admin_notes" class="form-control" rows="3" placeholder="Tambahkan catatan admin (opsional)"><?= esc($booking['admin_notes'] ?? '') ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-success me-2" onclick="return confirm('Setujui pembayaran ini dan konfirmasi booking?');"><i class="fas fa-check-circle"></i> Setujui Pembayaran</button>
                    </form>

                    <form action="<?= base_url('admin/bookings/reject-payment/' . $booking['id']) ?>" method="post" class="mb-3">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <textarea name="admin_notes" class="form-control" rows="3" placeholder="Tambahkan alasan penolakan (wajib jika menolak)"><?= esc($booking['admin_notes'] ?? '') ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tolak pembayaran ini dan batalkan booking?');"><i class="fas fa-times-circle"></i> Tolak Pembayaran</button>
                    </form>
                <?php else: ?>
                    <p class="text-muted">Pembayaran sudah <?= esc($booking['payment_status']) ?>.</p>
                <?php endif; ?>

                <?php if ($booking['booking_status'] != 'cancelled' && $booking['booking_status'] != 'completed'): ?>
                    <hr>
                    <p><strong>Batalkan Booking:</strong></p>
                    <form action="<?= base_url('admin/bookings/cancel-booking/' . $booking['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <textarea name="admin_notes" class="form-control" rows="3" placeholder="Alasan pembatalan (opsional)"><?= esc($booking['admin_notes'] ?? '') ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-secondary" onclick="return confirm('Apakah Anda yakin ingin membatalkan booking ini?');"><i class="fas fa-ban"></i> Batalkan Booking</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <a href="<?= base_url('admin/bookings') ?>" class="btn btn-outline-secondary">Kembali ke Daftar Booking</a>
    </div>
</div>
<?= $this->endSection() ?>