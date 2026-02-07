<?php
include('koneksi.php');

// hitung total pelanggan
$query_pelanggan = mysqli_query($connection, "SELECT COUNT(*) as total from tbl_pelanggan");
$total_pelanggan = mysqli_fetch_array($query_pelanggan)['total'];

// hitung total pesanan
$query_pesanan = mysqli_query($connection, "SELECT COUNT(*) as total FROM tbl_pesanan");
$total_pesanan = mysqli_fetch_array($query_pesanan)['total'];

// hitung pesanan aktif
$query_aktif = mysqli_query($connection, "SELECT COUNT(*) as total from tbl_pesanan WHERE status_pesanan != 'Selesai'");
$pesanan_aktif = mysqli_fetch_array($query_aktif)['total'];

// hitung total pendapatan
$query_pendapatan = mysqli_query($connection, "SELECT SUM(harga) as total FROM tbl_pesanan WHERE status_pesanan = 'Selesai'");
$total_pendapatan = mysqli_fetch_array($query_pendapatan)['total'];
if (!$total_pendapatan) $total_pendapatan = 0;
?>

<style>
    .stat-card {
        border-left: 4px solid;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .stat-card-primary {
        border-left-color: #4e73df;
    }

    .stat-card-success {
        border-left-color: #1cc88a;
    }

    .stat-card-warning {
        border-left-color: #f6c23e;
    }

    .stat-card-danger {
        border-left-color: #e74a3b;
    }

    .stat-icon {
        font-size: 2rem;
        opacity: 0.3;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #5a5c69;
    }

    .stat-label {
        font-size: 0.85rem;
        color: #858796;
        text-transform: uppercase;
        font-weight: 700;
    }

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
        background-color: #1cc88a;
        color: white;
    }
</style>

<!-- Statistik Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card stat-card-primary">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="stat-label">Total Pelanggan</div>
                        <div class="stat-number"><?php echo $total_pelanggan ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users stat-icon" style="color: #4e73df"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card stat-card-success">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="stat-label">Total Pesanan</div>
                        <div class="stat-number"><?php echo $total_pesanan ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-bag stat-icon" style="color: #1cc88a"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card stat-card-warning">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="stat-label">Pesanan Aktif</div>
                        <div class="stat-number"><?php echo $pesanan_aktif ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock stat-icon" style="color: #f6c23e"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card stat-card-danger">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="stat-label">Total Pendapatan</div>
                        <div class="stat-number" style="font-size: 1.5rem">Rp <?php echo number_format($total_pendapatan, 0, ',', '.') ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign stat-icon" style="color: #e74a3b"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Pesanan Terbaru -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-list me-2"></i>Pesanan Terbaru
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Pelanggan</th>
                                <th>Jenis Pakaian</th>
                                <th>Status</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = mysqli_query($connection, "SELECT p.*, pl.nama as nama_pelanggan FROM tbl_pesanan p LEFT JOIN tbl_pelanggan pl ON p.id_pelanggan = pl.id_pelanggan ORDER BY p.created_at DESC LIMIT 5");
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
                                    <td><?php echo $row['nama_pelanggan'] ?></td>
                                    <td><?php echo $row['jenis_pakaian'] ?></td>
                                    <td><span class="badge badge-status <?php echo $status_class ?>"><?php echo $row['status_pesanan'] ?></span></td>
                                    <td><strong>Rp <?php echo number_format($row['harga'], 0, ',', '.') ?></strong></td>
                                </tr>
                            <?php   } ?>
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <a href="index.php?page=pesanan" class="btn btn-primary">
                        <i class="fas fa-eye me-2"></i>Lihat Semua Pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Status -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-pie me-2"></i>Ringkasan Status Pesanan
            </div>
            <div class="card-body">
                <?php
                // Hitung per status
                $query_menunggu = mysqli_query($connection, "SELECT COUNT(*) as total FROM tbl_pesanan WHERE status_pesanan = 'Menunggu'");
                $total_menunggu = mysqli_fetch_array($query_menunggu)['total'];

                $query_potong = mysqli_query($connection, "SELECT COUNT(*) as total FROM tbl_pesanan WHERE status_pesanan ='Potong'");
                $total_potong = mysqli_fetch_array($query_potong)['total'];

                $query_jahit = mysqli_query($connection, "SELECT COUNT(*) as total FROM tbl_pesanan WHERE status_pesanan = 'Jahit'");
                $total_jahit = mysqli_fetch_array($query_jahit)['total'];

                $query_selesai = mysqli_query($connection, "SELECT COUNT(*) as total FROM tbl_pesanan WHERE status_pesanan = 'Selesai'");
                $total_selesai = mysqli_fetch_array($query_selesai)['total'];
                ?>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span><span class="badge status-menunggu">Menunggu</span></span>
                        <strong><?php echo $total_menunggu ?> pesanan</strong>
                    </div>
                    <div class="progress" style="height:10px;">
                        <div class="progress-bar" style="width: <?php echo ($total_pesanan > 0) ? ($total_menunggu / $total_pesanan * 100) : 0 ?>%; background: #f6c23e" ;></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span><span class="badge status-potong">Potong</span></span>
                        <strong><?php echo $total_potong  ?> pesanan</strong>
                    </div>
                    <div class="progress" style="height:10px;">
                        <div class="progress-bar" style="width: <?php echo ($total_pesanan > 0) ? ($total_potong / $total_pesanan * 100) : 0 ?>%; background: #4e73df" ;></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span><span class="badge status-jahit">Jahit</span></span>
                        <strong><?php echo $total_jahit ?> pesanan</strong>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar" style="width: <?php echo ($total_pesanan > 0) ? ($total_jahit / $total_pesanan * 100) : 0 ?>%; background:#6f42c1" ;></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span><span class="badge status-selesai">Selesai</span></span>
                        <strong><?php echo $total_selesai ?> pesanan</strong>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar" style="width: <?php echo ($total_pesanan > 0) ? ($total_selesai / $total_pesanan * 100) : 0 ?>%; background: #1cc88a;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mt-4">
            <div class="card-header">
                <i class="fas fa-bolt me-2"></i>Aksi Cepat
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="index.php?page=pelanggan" class="btn btn-primary">
                        <i class="fas fa-user-plus me-2"></i>Tambah Pelanggan
                    </a>
                    <a href="index.php?page=pesanan" class="btn btn-success">
                        <i class="fas fa-plus-circle me-2"></i>Buat Pesanan Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>