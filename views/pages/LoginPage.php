<div class="auth-center">
    <form method="POST" class="form-card mx-auto">
        <div class="card card-elevated">
            <div class="card-body">
                <div class="text-center mb-2">
                    <h2>Login</h2>
                    <p class="small-muted">Masuk untuk melanjutkan</p>
                </div>

                <!-- Tempat pesan -->
                <div class="mb-3">
                <?php
                if (isset($_SESSION['error']) && $_SESSION['error']) {
                    echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['error']) . '</div>';
                    $_SESSION['error'] = null;  // Hapus pesan setelah ditampilkan
                }

                if (isset($_SESSION['success']) && $_SESSION['success']) {
                    echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['success']) . '</div>';
                    $_SESSION['success'] = null;  // Hapus pesan setelah ditampilkan
                }
                ?>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Kata Sandi</label>
                    <input type="password" class="form-control" name="password" required>
                </div>

                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-primary">Masuk</button>
                </div>

                <hr>
                <p class="text-center small-muted">Belum memiliki akun? <a href="/auth/register">Daftar</a></p>
            </div>
        </div>
    </form>
</div>
