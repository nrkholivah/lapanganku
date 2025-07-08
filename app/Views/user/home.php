<?= $this->extend('layout/user') ?>

<?= $this->section('content') ?>
<h1 class="mb-4">Daftar Lapangan Tersedia</h1>

<div class="row">
    <?php if (empty($lapangans)): ?> <div class="col-12">
            <div class="alert alert-info" role="alert">
                Belum ada lapangan yang terdaftar.
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($lapangans as $lapangan): ?> <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <?php if ($lapangan['image']): ?> <img src="<?= base_url($lapangan['image']) ?>" class="card-img-top" alt="<?= esc($lapangan['name']) ?>" style="height: 200px; object-fit: cover;"> <?php else: ?>
                        <img src="https://placehold.co/600x400/FF0000/FFFFFF?text=No+Image" class="card-img-top" alt="No Image" style="height: 200px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= esc($lapangan['name']) ?></h5>
                        <p class="card-text text-muted small"><?= esc(word_limiter($lapangan['description'] ?? 'Tidak ada deskripsi.', 20)) ?></p>
                        <p class="card-text">
                            <strong>Harga:</strong> Rp<?= number_format($lapangan['price_per_hour'], 0, ',', '.') ?> / jam
                        </p>
                        <p class="card-text">
                            <strong>Status:</strong>
                            <?php if ($lapangan['status'] == 'Tersedia'): ?>
                                <span class="badge bg-success">Tersedia</span>
                            <?php elseif ($lapangan['status'] == 'Perawatan'): ?>
                                <span class="badge bg-warning text-dark">Perawatan</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Penuh</span>
                            <?php endif; ?>
                        </p>
                        <div class="mt-auto">
                            <a href="<?= base_url('lapangan/' . $lapangan['id']) ?>" class="btn btn-danger w-100">Lihat Detail & Booking</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>