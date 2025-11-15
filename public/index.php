<?php
session_start();

// Mengambil method HTTP yang sedang digunakan (misal: GET, POST)
// Ini dipakai untuk membedakan antara tampilan form dan proses pengiriman data
$method = $_SERVER['REQUEST_METHOD'];

// Mengambil path/URL yang diminta user
// Contoh:
// - "/" → index
// - "/auth/login" → auth/login
$page = $_SERVER['REQUEST_URI'] ?? 'index';

// Menghilangkan karakter "/" di depan/belakang agar path lebih rapi dan mudah diproses
// Sekaligus mencegah teknik path traversal yang berbahaya
$page = trim($page, '/');

// Jika URL kosong (misalnya user hanya membuka "/"), maka diarahkan ke halaman index
if ($page === '') {
    $page = 'index';
}

// Memuat controller yang diperlukan oleh aplikasi
require_once __DIR__ . '/../controllers/HomeController.php';
require_once __DIR__ . '/../controllers/AuthController.php';

// Membuat objek dari controller agar bisa memanggil method di dalamnya
$homeController = new HomeController();
$authController = new AuthController();

// Routing sederhana berdasarkan nilai $page
// Routing memutuskan URL mana yang memanggil function (action) mana
switch ($page) {

    // Halaman utama (dashboard/home)
    case 'index':
        $homeController->home();
        break;

    // Halaman Login
    case 'auth/login':
        // Jika user menekan tombol submit (POST), maka proses login dilakukan
        // Jika halaman hanya dibuka (GET), maka tampilkan form login
        if ($method === 'POST') {
            $authController->postLogin();
        } else {
            $authController->getLogin();
        }
        break;

    // Halaman Register (form pendaftaran user baru)
    case 'auth/register':
        $authController->getRegister();
        break;

    // API untuk pendaftaran user baru (dipanggil melalui AJAX atau form submit tipe POST)
    case 'api/auth/register':
        if ($method === 'POST') {
            $authController->apiPostRegister();
        } else {
            http_response_code(405);  // Method Not Allowed (POST required)
        }
        break;

    // Logout (menghapus session dan mengembalikan ke halaman login)
    case 'auth/logout':
        $authController->logout();
        break;

    // Jika URL tidak dikenali → tampilkan halaman 404
    default:
        http_response_code(404);
        include __DIR__ . '/../views/pages/404Page.php';
        break;
}
