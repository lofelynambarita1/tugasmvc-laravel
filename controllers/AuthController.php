<?php
require_once (__DIR__ . '/../models/UserModel.php');

class AuthController
{
    // Halaman Login (Method untuk menampilkan form login kepada user)
    // --------------------------------------------------------------------------------
    public function getLogin()
    {
        // Jika user sudah login (memiliki session), langsung arahkan ke halaman utama (dashboard/home)
        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }

        // Mengambil tampilan halaman login dari folder views
        ob_start();
        include __DIR__ . '\..\views\pages\LoginPage.php';
        $content = ob_get_clean();

        // Memasukkan halaman login ke dalam layout utama agar tampilan konsisten
        include __DIR__ . '\..\views\layouts\MainLayout.php';
    }

    public function postLogin()
    {
        // Mengambil input email dan password yang dikirim dari form login
        $email = $_POST['email'];
        $password = $_POST['password'];

        $userModel = new UserModel();
        $user = $userModel->getUserByEmail($email);

        // Mengecek apakah email terdaftar dan password sesuai
        if ($user && password_verify($password, $user['password'])) {
            // Jika login berhasil → simpan user_id ke session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['error'] = null;
            header('Location: /'); // Arahkan ke halaman utama
        } else {
            // Jika login gagal → kirim pesan error dan arahkan kembali ke halaman login
            $_SESSION['error'] = 'Email atau kata sandi salah.';
            header('Location: /auth/login');
        }
    }

    // Halaman Register (Method untuk menampilkan form pendaftaran user baru)
    // --------------------------------------------------------------------------------
    public function getRegister()
    {
        // Jika user sudah login, tidak perlu daftar lagi → langsung arahkan ke halaman utama
        if (isset($_SESSION['user_id'])) {
            header('Location: /');
        }

        // Mengambil tampilan halaman register
        ob_start();
        include __DIR__ . '\..\views\pages\RegisterPage.php';
        $content = ob_get_clean();

        // Memasukkan tampilan register ke dalam layout utama
        include __DIR__ . '\..\views\layouts\MainLayout.php';
    }

    public function apiPostRegister()
    {
        // Validasi input (nama, email, password wajib ada)
        if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['password'])) {
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Data tidak valid.'
            ]);
            return;
        }

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $userModel = new UserModel();
        $existingUser = $userModel->getUserByEmail($email);

        // Mengecek apakah email sudah digunakan user lain
        if ($existingUser) {
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Email sudah terdaftar.'
            ]);
            return;
        } else {
            // Proses pembuatan user baru di database
            $result = $userModel->createUser($name, $email, $password);
            if (!$result) {
                // Kasus jika terjadi masalah pada query database
                header('Content-Type: application/json; charset=utf-8');
                http_response_code(500);
                echo json_encode([
                    'success' => false,
                    'message' => 'Gagal melakukan pendaftaran. Terjadi kesalahan server.'
                ]);
                return;
            }

            // Pendaftaran berhasil, memberi notifikasi ke session
            $_SESSION['success'] = 'Pendaftaran berhasil. Silakan login!';

            // Mengirim respon sukses dalam bentuk JSON
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'success' => true,
                'message' => 'Pendaftaran berhasil. Silakan login!'
            ]);
            return;
        }
    }

    // Logout (Menghapus session login dan mengarahkan user ke halaman login)
    // --------------------------------------------------------------------------------
    public function logout()
    {
        session_destroy();
        header('Location: /auth/login');
    }
}
