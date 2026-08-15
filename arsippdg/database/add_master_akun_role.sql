-- Jalankan file ini bila kolom role sudah dibuat sebelumnya
-- dan saat ini hanya berisi arsip_surat serta sistem_nilai.
ALTER TABLE `users`
    MODIFY COLUMN `role` ENUM('arsip_surat', 'sistem_nilai', 'master_akun')
    NOT NULL DEFAULT 'arsip_surat';

-- Bootstrap akun Master Akun pertama. Pada proyek ini user awal adalah id = 1.
-- Setelah login sebagai akun ini, buat akun operasional baru dari menu Akun Master.
UPDATE `users`
SET `role` = 'master_akun'
WHERE `id` = 1;
