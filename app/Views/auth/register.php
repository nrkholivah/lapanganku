<?= $this->extend('layout/user') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm mt-5">
            <div class="card-header bg-danger text-white text-center">
                <h4>Daftar Akun Baru</h4>
            </div>
            <div class="card-body">
                <?= form_open(base_url('register')) ?>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?= old('username') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="no_hp" class="form-label">Nomor HP</label>
                    <input type="tel" class="form-control" id="no_hp" name="no_hp" required placeholder="Contoh: 081234567890">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="pass_confirm" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="pass_confirm" name="pass_confirm" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-danger">Daftar</button>
                </div>
                <?= form_close() ?>
                <p class="mt-3 text-center">Sudah punya akun? <a href="<?= base_url('login') ?>">Login di sini</a></p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>