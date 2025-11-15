<div class="auth-center">
    <form id="registerForm" method="POST" class="form-card mx-auto">
        <div class="card card-elevated">
            <div class="card-body">
                <div class="text-center mb-2">
                    <h2>Mendaftar</h2>
                    <p class="small-muted">Buat akun baru secara cepat</p>
                </div>
                <hr>

                <!-- Tempat pesan -->
                <div id="message" class="mb-3"></div>

                <div class="form-group mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" name="name" required>
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
                    <button type="submit" class="btn btn-primary" id="registerButton">Daftar</button>
                </div>

                <hr>
                <p class="text-center small-muted">Sudah memiliki akun? <a href="/auth/login">Masuk</a></p>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const btn = document.getElementById('registerButton');
    btn.disabled = true;
    btn.innerText = 'Mendaftarkan...';

    const form = e.target;
    const formData = new FormData(form);

    try {
        const response = await fetch('/api/auth/register', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();

        const messageBox = document.getElementById('message');
        if (result.success) {
           window.location.href = '/auth/login';
        } else {
            messageBox.innerHTML = `<div class="alert alert-danger">${result.message}</div>`;
        }
    } catch (err) {
        document.getElementById('message').innerHTML = '<div class="alert alert-danger">Terjadi kesalahan jaringan.</div>';
    } finally {
        btn.disabled = false;
        btn.innerText = 'Daftar';
    }
});
</script>
