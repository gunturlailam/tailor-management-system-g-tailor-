<?php
include('koneksi.php');

// proses tambah
if (isset($_POST['tambah'])) {
    $id_pelanggan = $_POST['id_pelanggan'];
    $tanggal_pesan = $_POST['tanggal_pesan'];
    $jenis_pakaian = $_POST['jenis_pakaian'];
    $lingkar_dada = $_POST['lingkar_dada'];
    $lingkar_pinggang = $_POST['lingkar_pinggang'];
    $lingkar_pinggul = $_POST['lingkar_pinggul'];
    $panjang_badan = $_POST['panjang_badan'];
    $panjang_lengan = $_POST['panjang_lengan'];
    $lebar_bahu = $_POST['lebar_bahu'];
    $status_pesanan = $_POST['status_pesanan'];
    $harga = $_POST['harga'];
    $catatan = $_POST['catatan'];

    $query = "INSERT INTO tbl_pesanan (id_pelanggan, tanggal_pesan, jenis_pakaian, lingkar_dada, lingkar_pinggang, lingkar_pinggul, panjang_badan, panjang_lengan, lebar_bahu, status_pesanan, harga, catatan) VALUES ('$id_pelanggan', '$tanggal_pesan', '$jenis_pakaian', '$lingkar_dada', '$lingkar_pinggang', '$lingkar_pinggul', '$panjang_badan', '$panjang_lengan', '$lebar_bahu', '$status_pesanan', '$harga', '$catatan')";

    if ($connection->query($query)) {
        echo "<script>window.location='index.php?page=pesanan&status=tambah_sukses';</script>";
    }
}

// proses edit
if (isset($_POST['edit'])) {
    $id_pesanan = $_POST['id_pesanan'];
    $id_pelanggan = $_POST['id_pelanggan'];
    $tanggal_pesan = $_POST['tanggal_pesan'];
    $jenis_pakaian = $_POST['jenis_pakaian'];
    $lingkar_dada = $_POST['lingkar_dada'];
    $lingkar_pinggang = $_POST['lingkar_pinggang'];
    $lingkar_pinggul = $_POST['lingkar_pinggul'];
    $panjang_badan = $_POST['panjang_badan'];
    $panjang_lengan = $_POST['panjang_lengan'];
    $lebar_bahu = $_POST['lebar_bahu'];
    $status_pesanan = $_POST['status_pesanan'];
    $harga = $_POST['harga'];
    $catatan = $_POST['catatan'];

    $query = "UPDATE tbl_pesanan SET id_pelanggan='$id_pelanggan', tanggal_pesan='$tanggal_pesan', jenis_pakaian='$jenis_pakaian', lingkar_dada='$lingkar_dada', lingkar_pinggang='$lingkar_pinggang', lingkar_pinggul='$lingkar_pinggul', panjang_badan='$panjang_badan', panjang_lengan='$panjang_lengan', lebar_bahu='$lebar_bahu', status_pesanan='$status_pesanan', harga='$harga', catatan='$catatan' WHERE id_pesanan=$id_pesanan";

    if ($connection->query($query)) {
        echo "<script>window.location='index.php?page=pesanan&status=edit_sukses';</script>";
    }
}

// proses hapus
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $query = "DELETE FROM tbl_pesanan WHERE id_pesanan = $id";
    if ($connection->query($query)) {
        echo "<script>window.location='index.php?page=pesanan&status=hapus_sukses';</script>";
    }
}
?>

<style>
    .badge-status {
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-menunggu {
        background: #f6c23e;
        color: white;
    }

    .status-potong {
        background: #4e73df;
        color: white;
    }

    .status-jahit {
        background: #6f42c1;
        color: white;
    }

    .status-selesai {
        background: #1cc88a;
        color: white;
    }

    .ukuran-grid {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 15px;
    }
</style>

<?php if (isset($_GET['status'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i>
        <?php
        switch ($_GET['status']) {
            case 'tambah_sukses':
                echo 'Pesanan berhasil ditambahkan!';
                break;
            case 'edit_sukses':
                echo 'Pesanan berhasil diupdate!';
                break;
            case 'hapus_sukses':
                echo 'Pesanan berhasil dihapus!';
                break;
        }
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-shopping-bag me-2"></i>Daftar Pesanan</span>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fas fa-plus me-2"></i>Tambah Pesanan
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="tablePesanan">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th>Harga</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query = mysqli_query($connection, "SELECT p.*, pl.nama as nama_pelanggan FROM tbl_pesanan p LEFT JOIN tbl_pelanggan pl ON p.id_pelanggan = pl.id_pelanggan ORDER BY p.tanggal_pesan DESC");
                    while ($row = mysqli_fetch_array($query)) {
                        $status_class = '';
                        switch ($row['status_pesanan']) {
                            case 'Menunggu':
                                $status_class = 'status-menunggu';
                                break;
                            case 'Potong':
                                $status_class = 'status-potong';
                                break;
                            case 'Jahit':
                                $status_class = 'status-jahit';
                                break;
                            case 'Selesai':
                                $status_class = 'status-selesai';
                                break;
                        }
                    ?>
                        <tr>
                            <td><strong><?php echo $no++ ?></strong></td>
                            <td><?php echo date('d/m/Y', strtotime($row['tanggal_pesan'])) ?></td>
                            <td><?php echo $row['nama_pelanggan'] ?></td>
                            <td><?php echo $row['jenis_pakaian'] ?></td>
                            <td><span class="badge badge-status <?php echo $status_class ?>"><?php echo $row['status_pesanan'] ?></span></td>
                            <td><strong>Rp <?php echo number_format($row['harga'], 0, ',', '.') ?></strong></td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?php echo $row['id_pesanan'] ?>">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <a href="index.php?page=pesanan&hapus=<?php echo $row['id_pesanan'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?');">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEdit<?php echo $row['id_pesanan'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Pesanan</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form method="POST" action="index.php?page=pesanan">
                                        <div class="modal-body">
                                            <input type="hidden" name="id_pesanan" value="<?php echo $row['id_pesanan'] ?>">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Pelanggan</label>
                                                    <select name="id_pelanggan" class="form-select" required>
                                                        <?php
                                                        $q_pel = mysqli_query($connection, "SELECT * FROM tbl_pelanggan");
                                                        while ($pel = mysqli_fetch_array($q_pel)) {
                                                            $selected = ($pel['id_pelanggan'] == $row['id_pelanggan']) ? 'selected' : '';
                                                            echo "<option value='{$pel['id_pelanggan']}' $selected>{$pel['nama']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Tanggal</label>
                                                    <input type="date" name="tanggal_pesan" class="form-control" value="<?php echo $row['tanggal_pesan'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Jenis Pakaian</label>
                                                    <input type="text" name="jenis_pakaian" class="form-control" value="<?php echo $row['jenis_pakaian'] ?>" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Status</label>
                                                    <select name="status_pesanan" class="form-select" required>
                                                        <option value="Menunggu" <?php echo ($row['status_pesanan'] == 'Menunggu') ? 'selected' : '' ?>>Menunggu</option>
                                                        <option value="Potong" <?php echo ($row['status_pesanan'] == 'Potong') ? 'selected' : '' ?>>Potong</option>
                                                        <option value="Jahit" <?php echo ($row['status_pesanan'] == 'Jahit') ? 'selected' : '' ?>>Jahit</option>
                                                        <option value="Selesai" <?php echo ($row['status_pesanan'] == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="ukuran-grid">
                                                <h6><i class="fas fa-ruler me-2"></i>Ukuran Badan (cm)</h6>
                                                <div class="row">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label form-label-sm">Lingkar Dada</label>
                                                        <input type="text" name="lingkar_dada" class="form-control form-control-sm" value="<?php echo $row['lingkar_dada'] ?>" required>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label form-label-sm">Lingkar Pinggang</label>
                                                        <input type="text" name="lingkar_pinggang" class="form-control form-control-sm" value="<?php echo $row['lingkar_pinggang'] ?>" required>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label form-label-sm">Lingkar Pinggul</label>
                                                        <input type="text" name="lingkar_pinggul" class="form-control form-control-sm" value="<?php echo $row['lingkar_pinggul'] ?>" required>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label form-label-sm">Panjang Badan</label>
                                                        <input type="text" name="panjang_badan" class="form-control form-control-sm" value="<?php echo $row['panjang_badan'] ?>" required>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label form-label-sm">Panjang Lengan</label>
                                                        <input type="text" name="panjang_lengan" class="form-control form-control-sm" value="<?php echo $row['panjang_lengan'] ?>" required>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label form-label-sm">Lebar Bahu</label>
                                                        <input type="text" name="lebar_bahu" class="form-control form-control-sm" value="<?php echo $row['lebar_bahu'] ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Harga (Rp)</label>
                                                    <input type="number" name="harga" class="form-control" value="<?php echo $row['harga'] ?>" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Catatan</label>
                                                    <textarea name="catatan" class="form-control" rows="2"><?php echo $row['catatan'] ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" name="edit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Tambah Pesanan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="index.php?page=pesanan">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pelanggan</label>
                            <select name="id_pelanggan" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <?php
                                $q_pel = mysqli_query($connection, "SELECT * FROM tbl_pelanggan ORDER BY nama");
                                while ($pel = mysqli_fetch_array($q_pel)) {
                                    echo "<option value='{$pel['id_pelanggan']}'>{$pel['nama']} - {$pel['no_hp']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal_pesan" class="form-control" value="<?php echo date('Y-m-d') ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Pakaian</label>
                            <input type="text" name="jenis_pakaian" class="form-control" placeholder="Contoh: Kebaya" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status_pesanan" class="form-select" required>
                                <option value="Menunggu">Menunggu</option>
                                <option value="Potong">Potong</option>
                                <option value="Jahit">Jahit</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                    </div>
                    <div class="ukuran-grid">
                        <h6><i class="fas fa-ruler me-2"></i>Ukuran Badan (cm)</h6>
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label class="form-label form-label-sm">Lingkar Dada</label>
                                <input type="text" name="lingkar_dada" class="form-control form-control-sm" placeholder="90" required>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="form-label form-label-sm">Lingkar Pinggang</label>
                                <input type="text" name="lingkar_pinggang" class="form-control form-control-sm" placeholder="70" required>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="form-label form-label-sm">Lingkar Pinggul</label>
                                <input type="text" name="lingkar_pinggul" class="form-control form-control-sm" placeholder="95" required>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="form-label form-label-sm">Panjang Badan</label>
                                <input type="text" name="panjang_badan" class="form-control form-control-sm" placeholder="100" required>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="form-label form-label-sm">Panjang Lengan</label>
                                <input type="text" name="panjang_lengan" class="form-control form-control-sm" placeholder="55" required>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="form-label form-label-sm">Lebar Bahu</label>
                                <input type="text" name="lebar_bahu" class="form-control form-control-sm" placeholder="40" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control" placeholder="250000" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan" class="form-control" rows="2" placeholder="Opsional"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="tambah" class="btn btn-primary"><i class="fas fa-save me-2"></i>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#tablePesanan').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            },
            "pageLength": 10,
            "order": [
                [1, "desc"]
            ]
        });
    });
</script>