<?php
session_start();
include "koneksi.php";
// Tambah Data
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = '';

    if ($_FILES['gambar']['name']) {
        $gambar = basename($_FILES['gambar']['name']);
        $target = "uploads/" . $gambar;
        if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
            echo "<script>alert('Gagal mengupload gambar');</script>";
            exit();
        }
    }

    $stmt = $conn->prepare("INSERT INTO gallery (nama, deskripsi, gambar) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama, $deskripsi, $gambar);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Edit Data
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $gambar_lama = $_POST['gambar_lama'];
    $gambar = $gambar_lama;

    if ($_FILES['gambar']['name']) {
        $gambar = basename($_FILES['gambar']['name']);
        $target = "uploads/" . $gambar;

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
            if (file_exists("uploads/" . $gambar_lama)) {
                unlink("uploads/" . $gambar_lama);
            }
        } else {
            echo "<script>alert('Gagal mengganti gambar');</script>";
            exit();
        }
    }

    $stmt = $conn->prepare("UPDATE gallery SET nama = ?, deskripsi = ?, gambar = ? WHERE id = ?");
    $stmt->bind_param("sssi", $nama, $deskripsi, $gambar, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Hapus Data
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $sql = "SELECT gambar FROM gallery WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        if (file_exists("uploads/" . $data['gambar'])) {
            unlink("uploads/" . $data['gambar']);
        }
    }

    $stmt = $conn->prepare("DELETE FROM gallery WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Pagination
$hlm = isset($_GET['hlm']) ? $_GET['hlm'] : 1;
$limit = 5;
$start = ($hlm - 1) * $limit;

$sql_count = "SELECT COUNT(*) AS total FROM gallery";
$result_count = $conn->query($sql_count);
$total_records = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_records / $limit);

$sql = "SELECT * FROM gallery ORDER BY id DESC LIMIT $start, $limit";
$result = $conn->query($sql);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Galeri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="foto/logo.png">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light sticky-top p-2">
        <div class="container-fluid">
            <b class="navbar-brand fs-3 text-primary" href="#">ADMIN</b>
            
           
            <div class="d-flex align-items-center">
                <!-- Tombol Hamburger -->
                <button class="navbar-toggler me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <!-- Menu Navbar -->

            <div class="collapse navbar-collapse ms-md-0" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">

                        <a class="nav-link fs-5 text-primary" href="dashboard.php">Dashboard</a>
                        <a class="nav-link fs-5 text-primary" href="artikel.php">Article</a>
                        <a class="nav-link fs-5 text-primary" href="gallery.php">Gallery</a>
                        <a class="nav-link fs-5 text-primary" href="user_management.php">User</a>



                </div>
            </div>

            <!-- Login atau Gambar User -->
            <div class="d-flex align-items-center">
                <?php if (isset($_SESSION['username'])): ?>
                    <!-- Jika sudah login -->
                    <div class="dropdown">
                        <a href="#" class="nav-link p-0" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="foto/gambar login.png" class="rounded-circle" alt="User" style="width: 50px; height: 50px;">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a href="logout.php" class="dropdown-item text-danger">Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <!-- Jika belum login -->
                    <a href="login.php" class="btn btn-success fs-5">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav><br>
    <H3 class="p-3">Manajemen Galeri</H3> <hr>  
<div class="container mt-5">
       
    
    <!-- Tambah Gallery -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Gallery</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            
             <!-- soal no 1 dan 3-->
            <?php
            $no = $start + 1;
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                    <td>
                        <?php if ($row['gambar']): ?>
                            <img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" width="100">
                        <?php endif; ?>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id'] ?>">Edit</button>
                        <a href="?hapus=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="modalEdit<?= $row['id'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Gallery</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <input type="hidden" name="gambar_lama" value="<?= $row['gambar'] ?>">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($row['nama']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                        <textarea name="deskripsi" class="form-control" required><?= htmlspecialchars($row['deskripsi']) ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="gambar" class="form-label">Gambar</label>
                                        <input type="file" name="gambar" class="form-control">
                                        <p class="mt-2">Gambar saat ini:</p>
                                        <?php if ($row['gambar']): ?>
                                            <img src="uploads/<?= $row['gambar'] ?>" width="100">
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" name="edit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
            }
            ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <!-- First Page -->
            <li class="page-item <?= $hlm == 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="?hlm=1">First</a>
            </li>

            <!-- Page Numbers -->
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i == $hlm ? 'active' : '' ?>">
                    <a class="page-link" href="?hlm=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <!-- Last Page -->
            <li class="page-item <?= $hlm == $total_pages ? 'disabled' : '' ?>">
                <a class="page-link" href="?hlm=<?= $total_pages ?>">Last</a>
            </li>
        </ul>
    </nav>
</div>

<!-- Modal Tambah SOAL NO 4--> 
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Gallery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar</label>
                        <input type="file" name="gambar" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
