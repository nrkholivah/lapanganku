<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-3">
        <?= $this->include('admin/sidebar') ?>
    </div>
    <div class="col-md-9">
        <h1 class="mb-4"><?= esc($title) ?></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="<?= isset($lapangan) ? base_url('admin/lapangan/update/' . $lapangan['id']) : base_url('admin/lapangan/store') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <label for="name" class="form-label">Nama Lapangan</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= old('name', $lapangan['name'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= old('description', $lapangan['description'] ?? '') ?></textarea>
            </div>
            <div class="mb-3">
                <label for="price_per_hour" class="form-label">Harga per Jam</label>
                <input type="number" step="0.01" class="form-control" id="price_per_hour" name="price_per_hour" value="<?= old('price_per_hour', $lapangan['price_per_hour'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Gambar Lapangan</label>
                <input class="form-control" type="file" id="image" name="image" accept=".jpg, .jpeg, .png">
                <?php if (isset($lapangan) && $lapangan['image']): ?> <small class="form-text text-muted">Gambar saat ini: <a href="<?= base_url($lapangan['image']) ?>" target="_blank">Lihat Gambar</a></small> <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="Tersedia" <?= (isset($lapangan) && $lapangan['status'] == 'Tersedia') ? 'selected' : '' ?>>Tersedia</option>
                    <option value="Perawatan" <?= (isset($lapangan) && $lapangan['status'] == 'Perawatan') ? 'selected' : '' ?>>Perawatan</option>
                    <option value="Penuh" <?= (isset($lapangan) && $lapangan['status'] == 'Penuh') ? 'selected' : '' ?>> Penuh</option>
                </select>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-danger">Simpan</button>
                <a href="<?= base_url('admin/lapangan') ?>" class="btn btn-secondary">Batal</a>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
<?= $this->endSection() ?>