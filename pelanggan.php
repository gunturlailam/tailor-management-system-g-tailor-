<?php
include('koneksi.php');

// proses tambah data
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    $query = "INSERT INTO tbl_pelanggan (nama, no_hp, alamat) VALUES ('$nama', '$no_hp', '$alamat')";
    if ($connection->query($query)) {
        echo "<script>window.location='index.php?page=pelanggan&status=tambah_sukses';</script>";
    }
}

// proses edit data
if (isset($_POST['edit'])) {
    $id_pelanggan = $_POST['id_pelanggan'];
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    $query = "UPDATE tbl_pelanggan SET nama = '$nama', no_hp = '$no_hp', alamat= '$alamat' WHERE id_pelanggan = $id_pelanggan";
    if ($connection->query($query)) {
        echo "<script>window.location='index.php?page=pelanggan&status=edit_sukses';</script>";
    }
}

// proses hapus data
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $query = "DELETE FROM tbl_pelanggan WHERE id_pelanggan = $id";
    if ($connection->query($query)) {
        echo "<script>window.location='index.php?page=pelanggan&status=hapus_sukses';</script>";
    }
}
?>

<?php if (isset($_GET['status'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        <?php
        switch ($_GET['status']) {
            case 'tambah_sukses':
                echo 'Data pelanggan berhasil ditambahkan!';
                break;
            case 'edit_sukses':
                echo 'Data pelanggan berhasil diupdate';
                break;
            case 'hapus_sukses':
                echo 'Data pelanggan berhasil dihapus';
                break;
        }
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-users me-2"></i>Daftar Pelanggan</span>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fas fa-plus me-2"></i>Tambah Pelanggan
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="tablePelanggan">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query = mysqli_query($connection, "SELECT * FROM tbl_pelanggan ORDER BY id_pelanggan DESC");
                    while ($row = mysqli_fetch_array($query)) {
                    ?>
                        <tr>
                            <td><strong><?php echo $no++ ?></strong></td>
                            <td><?php echo $row['nama'] ?></td>
                            <td><code><?php echo $row['no_hp'] ?></code></td>
                            <td><?php echo substr($row['alamat'], 0, 50) . (strlen($row['alamat']) > 50  ? '...' : '') ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?php echo $row['id_pelanggan'] ?>">
                                    <i class="fas fa-edit"></i>Edit
                                </button>
                                <a href="index.php?page=pelanggan&hapus=<?php echo $row['id_pelanggan'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="fas fa-trash"></i>Hapus
                                </a>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="modalEdit<?php echo $row['id_pelanggan'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Pelanggan</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form method="POST" action="index.php?page=pelanggan">
                                        <div class="modal-body">
                                            <input type="hidden" name="id_pelanggan" value="<?php echo $row['id_pelanggan'] ?>">
                                            <div class="mb-3">
                                                <label class="form-label">Nama Lengkap</label>
                                                <input type="text" name="nama" class="form-control" value="<?php echo $row['nama'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">No HP</label>
                                                <input type="text" name="no_hp" class="form-control" value="<?php echo $row['no_hp'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Alamat</label>
                                                <textarea name="alamat" class="form-control" rows="3" required><?php echo $row['alamat'] ?></textarea>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-plus-circle me-2"></i>Tambah Pelanggan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="index.php?page=pelanggan">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No HP</label>
                        <input type="text" name="no_hp" class="form-control" placeholder="Contoh : 081234567890" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat lengkap" required></textarea>
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
        $('#tablePelanggan').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            },
            "pageLength": 10
        })
    })
</script>