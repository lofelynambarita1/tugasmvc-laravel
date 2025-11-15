-- Pastikan ekstensi UUID aktif
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- Hapus tabel users jika sudah ada (untuk keperluan pengujian ulang)
DROP TABLE IF EXISTS users;

-- Buat tabel users
CREATE TABLE users (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    name VARCHAR(100) NOT NULL,
    email VARCHAR(250) UNIQUE NOT NULL,
    password TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
