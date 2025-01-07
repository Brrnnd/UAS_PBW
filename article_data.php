<?php
session_start();
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<table class="table table-hover">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th class="w-25">Judul</th>
            <th class="w-75">Isi</th>
            <th class="w-25">Gambar</th>
            <th class="w-25">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include "koneksi.php";
        // Pagination parameters
        $hlm = isset($_POST['hlm']) ? (int)$_POST['hlm'] : 1; // Current page
        $limit = 3; // Articles per page
        $limit_start = ($hlm - 1) * $limit;

        // Query for articles with limit and offset
        $sql = "SELECT * FROM article ORDER BY tanggal DESC LIMIT ?, ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $limit_start, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        $no = $limit_start + 1; // Start numbering
        while ($row = $result->fetch_assoc()) {
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td>
                    <strong><?= $row["judul"] ?></strong>
                    <br>pada : <?= $row["tanggal"] ?>
                    <br>oleh : <?= $row["username"] ?>
                </td>
                <td><?= substr($row["isi"], 0, 50) ?>...</td>
                <td>
                    <?php if ($row["gambar"] && file_exists('foto/' . $row["gambar"])): ?>
                        <img src="foto/<?= $row["gambar"] ?>" width="100">
                    <?php endif; ?>
                </td>
                <td>
                    <a href="#" title="edit" class="badge rounded-pill text-bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row["id"] ?>"><i class="bi bi-pencil"></i></a>
                    <a href="#" title="delete" class="badge rounded-pill text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row["id"] ?>"><i class="bi bi-x-circle"></i></a>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<!-- Modal Edit -->
<?php 
// Reset pointer result untuk mendapatkan kembali data
$result->data_seek(0); 
while ($row = $result->fetch_assoc()) { 
?>
<div class="modal fade" id="modalEdit<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Article</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Judul</label>
                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                        <input type="text" class="form-control" name="judul" placeholder="Tuliskan Judul Artikel" value="<?= $row["judul"] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="floatingTextarea2">Isi</label>
                        <textarea class="form-control" placeholder="Tuliskan Isi Artikel" name="isi" required><?= $row["isi"] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput2" class="form-label">Ganti Gambar</label>
                        <input type="file" class="form-control" name="gambar">
                    </div>
                    <div class="mb-3">
                        <label for="formGroupExampleInput3" class="form-label">Gambar Lama</label>
                        <?php if ($row["gambar"] != '' && file_exists('foto/' . $row["gambar"])): ?>
                            <br><img src="foto/<?= $row["gambar"] ?>" width="100">
                        <?php endif; ?>
                        <input type="hidden" name="gambar_lama" value="<?= $row["gambar"] ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" value="simpan" name="simpan" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>

<?php } ?>

<!-- Modal Hapus -->
<?php 
$result->data_seek(0); // Reset pointer
while ($row = $result->fetch_assoc()) { 
?>
<div class="modal fade" id="modalHapus<?= $row['id'] ?>" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalHapusLabel">Hapus Article</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="artikel.php">
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus artikel ini?</p>
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <input type="hidden" name="gambar" value="<?= $row['gambar'] ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <input type="submit" name="hapus" value="Hapus" class="btn btn-danger">
                </div>
            </form>
        </div>
    </div>
</div>
<?php } ?>



<?php
// Query for total records
$sql_total = "SELECT COUNT(*) AS total FROM article";
$result_total = $conn->query($sql_total);
$total_records = $result_total->fetch_assoc()['total'];

// Pagination logic
$total_pages = ceil($total_records / $limit);
?>
<p>Total article: <?= $total_records ?></p>
<nav class="mb-2">
    <ul class="pagination justify-content-end">
        <?php if ($hlm > 1): ?>
            <li class="page-item halaman" id="1"><a class="page-link">First</a></li>
            <li class="page-item halaman" id="<?= $hlm - 1 ?>"><a class="page-link">&laquo;</a></li>
        <?php else: ?>
            <li class="page-item disabled"><a class="page-link">First</a></li>
            <li class="page-item disabled"><a class="page-link">&laquo;</a></li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item halaman <?= $hlm == $i ? 'active' : '' ?>" id="<?= $i ?>">
                <a class="page-link"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($hlm < $total_pages): ?>
            <li class="page-item halaman" id="<?= $hlm + 1 ?>"><a class="page-link">&raquo;</a></li>
            <li class="page-item halaman" id="<?= $total_pages ?>"><a class="page-link">Last</a></li>
        <?php else: ?>
            <li class="page-item disabled"><a class="page-link">&raquo;</a></li>
            <li class="page-item disabled"><a class="page-link">Last</a></li>
        <?php endif; ?>
    </ul>
</nav>
