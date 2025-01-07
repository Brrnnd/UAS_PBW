<?php
session_start();
include "koneksi.php"; 

// Tambah User
if (isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Simpan password dengan password_hash
    $role = $_POST['role'];
    $photo = $_FILES['photo']['name'];
    $target_dir = "foto/";
    $target_file = $target_dir . basename($photo);
    move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);

    // Validasi unik username
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Username sudah digunakan!";
    } else {
        $stmt = $conn->prepare("INSERT INTO user (username, password, role, photo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $password, $role, $target_file);

        if ($stmt->execute()) {
            $success = "User berhasil ditambahkan!";
        } else {
            $error = "Gagal menambahkan user!";
        }
    }
}

// Hapus User
if (isset($_POST['delete_user'])) {
    $username = $_POST['username'];
    $stmt = $conn->prepare("DELETE FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        $success = "User berhasil dihapus!";
    } else {
        $error = "Gagal menghapus user!";
    }
}

// Edit User
if (isset($_POST['edit_user'])) {
    $username = $_POST['username'];
    $role = $_POST['role'];

    // Validasi apakah role baru berbeda dengan yang lama
    $stmt = $conn->prepare("SELECT role FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $current_role = $result->fetch_assoc()['role'];

    if ($current_role !== $role) {
        // Update role jika berbeda
        $stmt = $conn->prepare("UPDATE user SET role = ? WHERE username = ?");
        $stmt->bind_param("ss", $role, $username);

        if ($stmt->execute()) {
            $success = "Role user berhasil diperbarui!";
        } else {
            $error = "Gagal memperbarui role user!";
        }
    } else {
        $error = "Role baru harus berbeda dari yang sebelumnya!";
    }
}


// Ambil total user
$total_users = $conn->query("SELECT COUNT(*) FROM user")->fetch_row()[0];
$limit = 5; // Batas per halaman
$total_pages = ceil($total_users / $limit);

// Ambil data user untuk halaman saat ini
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $limit;
$result = $conn->query("SELECT username, role, photo FROM user LIMIT $limit OFFSET $offset");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="foto/logo.png">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light sticky-top p-2">
    <div class="container-fluid">
        <b class="navbar-brand fs-3 text-primary" href="#">ADMIN</b>
        <div class="d-flex align-items-center">
            <button class="navbar-toggler me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse ms-md-0" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto">
                <a class="nav-link fs-5 text-primary" href="dashboard.php">Dashboard</a>
                <a class="nav-link fs-5 text-primary" href="artikel.php">Article</a>
                <a class="nav-link fs-5 text-primary" href="gallery.php">Gallery</a>
                <a class="nav-link fs-5 text-primary" href="user_management.php">User</a>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <?php if (isset($_SESSION['username'])): ?>
                <div class="dropdown">
                    <a href="#" class="nav-link p-0" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="foto/gambar login.png" class="rounded-circle" alt="User" style="width: 50px; height: 50px;">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a href="logout.php" class="dropdown-item text-danger">Logout</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="login.php" class="btn btn-success fs-5">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav><br>
<h3 class="p-3">Manajemen User</h3><hr>  
<div class="container mt-5">
    
    <?php if (isset($success)) { ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php } ?>
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php } ?>

    <!-- Form Tambah User -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">Tambah User</button>

    <!-- Tabel User -->
    <table class="table table-bordered" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Role</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <!-- SOAL NO 1 -->
            <?php $no = $offset + 1; while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['username'] ?></td>
                    <td><?= ucfirst($row['role']) ?></td>
                    <td><img src="<?= $row['photo'] ?>" alt="Foto User" style="width: 50px; height: 50px;" class="rounded-circle"></td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal<?= $row['username'] ?>">Edit</button>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="username" value="<?= $row['username'] ?>">
                            <button type="submit" name="delete_user" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>

                <!-- Modal Edit User -->
                <div class="modal fade" id="editUserModal<?= $row['username'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <form method="POST">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="username" value="<?= $row['username'] ?>">
                                    <div class="mb-3">
                                        <label>Role</label>
                                        <select name="role" class="form-select">
                                            <option value="admin" <?= $row['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                            <option value="user" <?= $row['role'] === 'user' ? 'selected' : '' ?>>User</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" name="edit_user" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </tbody>
    </table>
    
    <!-- Paginasi SOAL NO 3-->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <!-- First Page -->
            <li class="page-item <?= $current_page == 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= $current_page == 1 ? '#' : '?page=1' ?>">First</a>
            </li>

            <!-- Page Numbers -->
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <!-- Last Page -->
            <li class="page-item <?= $current_page == $total_pages ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= $current_page == $total_pages ? '#' : '?page=' . $total_pages ?>">Last</a>
            </li>
        </ul>
    </nav>


</div>

<!-- Modal Tambah User SOAL NO 2-->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Role</label>
                        <select name="role" class="form-select">
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Foto</label>
                        <input type="file" name="photo" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="add_user" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
