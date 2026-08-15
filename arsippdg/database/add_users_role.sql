-- Jalankan SEKALI pada database yang tabel users-nya sudah ada.
-- Pengguna lama (misalnya id = 1) otomatis menjadi admin arsip surat.
ALTER TABLE `users`
    ADD COLUMN `role` ENUM('arsip_surat', 'sistem_nilai', 'master_akun') NOT NULL DEFAULT 'arsip_surat' AFTER `password`;

UPDATE `users`
SET `role` = 'arsip_surat'
WHERE `role` IS NULL OR `role` = '';
