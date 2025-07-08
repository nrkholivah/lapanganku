<?= $this->extend('layout/user') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm mt-5">
            <div class="card-header bg-danger text-white text-center">
                <h4>Login ke Akun Anda</h4>
            </div>
            <div class="card-body">
                <?= form_open(base_url('login')) ?>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-danger">Login</button>
                </div>
                <?= form_close() ?>
                <p class="mt-3 text-center">Belum punya akun? <a href="<?= base_url('register') ?>">Daftar di sini</a></p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>