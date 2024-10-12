<?php
include_once("template/header.php");
require_once("function.php")
?>

<div class="main-panel m-4">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <h2 class="card-title mr-5">Barang Inventaris</h2>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambahBarangModal">Tambah Barang</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th> No</th>
                                <th> Nama Barang </th>
                                <th> Kode Barang </th>
                                <th> Tanggal Masuk </th>
                                <th> Tanggal Terima </th>
                                <th> Status Barang </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $table_barang = query("SELECT * FROM tm_barang_inventaris");
                            foreach ($table_barang as $barang): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($barang['br_nama']) ?></td>
                                    <td><?= htmlspecialchars($barang['jns_brg_kode']) ?></td>
                                    <td><?= htmlspecialchars($barang['br_tgl_entry'])?></td>
                                    <td><?= htmlspecialchars($barang['br_tgl_terima'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($barang['br_status']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// $query = mysqli_query($koneksi, "SELECT * max(br_kode) as kodeTerbesar FROM tm_barang_inventaris");
// $data = mysqli_fetch_array($query);
// $kodeBarang = $data['kodeTerbesar'];

// $urutan = (int) substr($kodeBarang, 2, 3);

// $urutan ++;

// $huruf = 'JB';
// $kodeBarang = $huruf . sprintf("$03s", $urutan)
?>

<!-- Modal -->
<?php $jenis_barang_list = getJenisBarang(); ?>
<!-- Modal -->
<div class="modal fade" id="tambahBarangModal" tabindex="-1" role="dialog" aria-labelledby="tambahBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahBarangModalLabel">Tambah Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-tambah-barang" action="proses_tambah_barang.php" method="POST">
                    <div class="form-group">
                        <label for="namaBarang">Nama Barang</label>
                        <input type="text" class="form-control" id="namaBarang" name="nama_barang" placeholder="Nama Barang" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggalMasuk">Tanggal Masuk</label>
                        <input type="date" class="form-control" id="tanggalMasuk" name="tanggal_masuk" required>
                    </div>
                    <div class="form-group">
                        <label for="tanggalTerima">Tanggal Terima</label>
                        <input type="date" class="form-control" id="tanggalTerima" name="tanggal_terima" required>
                    </div>
                    <div class="form-group">
                        <label for="jnsBarang">Jenis Barang</label>
                        <select class="form-control" id="jnsBarang" name="jns_brg_kode" required>
                            <option value="">Pilih Jenis Barang</option>
                            <?php foreach ($jenis_barang_list as $jenis): ?>
                                <option value="<?= htmlspecialchars($jenis['jns_brg_kode']) ?>"><?= htmlspecialchars($jenis['jns_brg_nama']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="statusBarang">Status Barang</label>
                        <select class="form-control" id="statusBarang" name="status_barang" required>
                            <option value="Ad">Tersedia</option>
                            <option value="Td">Tidak Tersedia</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include_once("template/footer.php");
?>