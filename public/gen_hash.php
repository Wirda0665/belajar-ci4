<?php
// Akses: http://localhost:8080/gen_hash.php
// PENTING: Hapus file ini segera setelah digunakan!
$data = [
    'Admin@perpus.id' => password_hash('Admin@perpus.id', PASSWORD_DEFAULT),
    'Petugas@perpus.id' => password_hash('Petugas@perpus.id', PASSWORD_DEFAULT),
    'Anggota@perpus.id' => password_hash('Anggota@perpus.id', PASSWORD_DEFAULT),
];
foreach ($data as $plain => $hash) {
    echo "<p><b>$plain</b>: $hash</p>";
}
