<?php
session_start();
require_once("function.php"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_barang = $_POST['nama_barang'];
    $tanggal_masuk = $_POST['tanggal_masuk']; // Ambil tanggal masuk dari form
    $tanggal_terima = $_POST['tanggal_terima'];
    $jns_brg_kode = $_POST['jns_brg_kode'];
    $status_barang = $_POST['status_barang'];
    $user_id =

    // Debugging: Cek nilai tanggal masuk dan tanggal terima
    error_log("Tanggal Masuk: " . $tanggal_masuk);
    error_log("Tanggal Terima: " . $tanggal_terima);
    error_log("User Id: ". $user_id);

    // Siapkan data untuk disimpan
    $data = [
        'br_kode' => generateIdBarang(), // Memanggil fungsi
        'br_nama' => $nama_barang,
        'br_tgl_entry' => $tanggal_masuk,
        'br_tgl_terima' => $tanggal_terima,
        'jns_brg_kode' => $jns_brg_kode,
        'br_status' => $status_barang,
        'user_id' => $user_id,
    ];

    // Debugging: Cek nilai yang akan disimpan
    error_log("Data yang akan disimpan: " . print_r($data, true));

    if (tambah_barang($data) > 0) {
        echo "<script>
                alert('Data barang berhasil ditambahkan!');
                window.location.href = 'barang_inventaris.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menambahkan data barang.');
                window.history.back();
              </script>";
    }
}
