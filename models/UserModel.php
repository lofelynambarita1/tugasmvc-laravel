<?php
require_once(__DIR__ . '/../config.php');

class UserModel
{
    private $conn;

    public function __construct()
    {
        // Koneksi ke database MySQL menggunakan MySQLi
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);

        // Jika koneksi gagal, hentikan proses
        if ($this->conn->connect_error) {
            die('Koneksi database gagal: ' . $this->conn->connect_error);
        }
    }

    // Mengambil seluruh data user
    public function getAllUsers()
    {
        $query = "SELECT * FROM users";
        $result = $this->conn->query($query);
        $users = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        return $users;
    }

    // Mengambil data user berdasarkan email
    public function getUserByEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        return ($result->num_rows === 1) ? $result->fetch_assoc() : null;
    }

    // Mengambil data user berdasarkan ID
    public function getUserById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return ($result->num_rows === 1) ? $result->fetch_assoc() : null;
    }

    // Membuat user baru (register)
    public function createUser($name, $email, $password)
    {
        $hashPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashPassword);

        return $stmt->execute();
    }

    // Update data user berdasarkan ID
    public function updateUser($id, $name, $email, $password)
    {
        $hashPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $email, $hashPassword, $id);

        return $stmt->execute();
    }

    // Menghapus user berdasarkan ID
    public function deleteUser($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}
?>
