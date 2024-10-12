<?php
require_once('koneksi.php');

function query($query) {
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function generateUserId($username) {
    $usernamePart = substr($username, 0, 5);
    $timestampPart = date('His');
    $timestampPart = substr($timestampPart, 0, 5);
    return $usernamePart . $timestampPart; 
}

function generateIdBarang() {
    global $koneksi;

    $query = mysqli_query($koneksi, "SELECT MAX(br_kode) AS kodeTerbesar FROM tm_barang_inventaris");
    $data =mysqli_fetch_array($query);

    if (!$data['kodeTerbesar']) {
        return 'BR001';
    }

    $kodeTerakhir = $data['kodeTerbesar'];
    $urutan = (int) substr($kodeTerakhir, 2);
    $urutan++;

    $kodeBarangBaru = 'BR' . str_pad($urutan, 3, '0', STR_PAD_LEFT); 
    
    return $kodeBarangBaru;
}

function register($data) {
    global $koneksi;

    $username = htmlspecialchars($data['user_nama']);
    $user_id = generateUserId($username); 

    $password = htmlspecialchars($data['user_pass']);
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $checkQuery = "SELECT * FROM tm_user WHERE user_id = '$user_id'";
    $result = mysqli_query($koneksi, $checkQuery);
    if (mysqli_num_rows($result) > 0) {
        return false; 
    }

    $query = "INSERT INTO tm_user (user_id, user_nama, user_pass) VALUES ('$user_id', '$username', '$password_hash')";
    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi); 
}

function getJenisBarang() {
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT * FROM tr_jenis_barang");
    $jenis_barang= [];
    while ($row = mysqli_fetch_assoc($result)) {
        $jenis_barang[] = $row;
    }

    return $jenis_barang;
}

function tambah_barang($data) {
    global $koneksi;

    session_start();
    $user_id = $_SESSION['user_id'];

    $barang_id = isset($data['br_kode']) ? htmlspecialchars($data['br_kode']) : null;
    $jns_barang = isset($data['jns_brg_kode']) ? htmlspecialchars($data['jns_brg_kode']) : null;
    $nama_barang = isset($data['br_nama']) ? htmlspecialchars($data['br_nama']) : null;
    $br_tgl_terima = isset($data['br_tgl_terima']) ? htmlspecialchars($data['br_tgl_terima']) : null; 
    $br_tgl_entry = isset($data['br_tgl_entry']) ? htmlspecialchars($data['br_tgl_entry']) : date('Y-m-d H:i:s'); 
    $br_status = isset($data['br_status']) ? htmlspecialchars($data['br_status']) : null;

    error_log("br_tgl_entry: " . $br_tgl_entry); 
    error_log("br_tgl_terima: " . $br_tgl_terima);

    if (!$nama_barang || !$jns_barang || !$br_status || !$br_tgl_terima || !$br_tgl_entry) {
        return 0; 
    }

    $query = "INSERT INTO tm_barang_inventaris (br_kode, jns_brg_kode, user_id, br_nama, br_tgl_terima, br_tgl_entry, br_status) VALUES('$barang_id', '$jns_barang', '$user_id', '$nama_barang', '$br_tgl_terima', '$br_tgl_entry', '$br_status')";

    mysqli_query($koneksi, $query);
    
    return mysqli_affected_rows($koneksi);
}
