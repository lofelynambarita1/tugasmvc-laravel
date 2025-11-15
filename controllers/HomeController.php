<?php
require_once (__DIR__ . '/../models/UserModel.php');

class HomeController
{
    // Halaman Home (Beranda)
    public function home()
    {
        // Mengecek apakah user sudah login atau belum melalui session.
        // Jika user belum login, arahkan ke halaman logout (yang akan menghapus session dan mengembalikan ke login).
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/logout');
            exit;
        }

        // Mengambil data user berdasarkan ID yang disimpan di session saat login
        $userModel = new UserModel();
        $user = $userModel->getUserById($_SESSION['user_id']);

        // Jika user tidak ditemukan dalam database (misal user dihapus)
        // Maka arahkan kembali ke halaman login
        if (!$user) {
            header('Location: /auth/login');
            exit;
        }

        // Menyimpan nama user untuk ditampilkan pada halaman dashboard/home
        $name = $user['name'];

        // Mengambil tampilan halaman Home (isi konten tertentu saja)
        ob_start();
        include __DIR__ . '\..\views\pages\HomePage.php';
        $content = ob_get_clean();

        // Memasukkan tampilan Home ke dalam template layout utama
        // sehingga tampilan halaman tetap konsisten (header, sidebar, footer, dll.)
        include __DIR__ . '\..\views\layouts\MainLayout.php';
    }
}
