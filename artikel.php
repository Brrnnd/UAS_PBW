<?php
session_start();
include "koneksi.php";
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
            
        <H3 class="p-3">Artikel</H3> <hr>


        <div class="container">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-lg"></i> Tambah Article
            </button>
            <div class="row">
                <div class="table-responsive" id="article_data">
                    
                </div>
                    <!-- Awal Modal Tambah-->
                    <div class="modal fade" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Article</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="formGroupExampleInput" class="form-label">Judul</label>
                                            <input type="text" class="form-control" name="judul" placeholder="Tuliskan Judul Artikel" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="floatingTextarea2">Isi</label>
                                            <textarea class="form-control" placeholder="Tuliskan Isi Artikel" name="isi" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="formGroupExampleInput2" class="form-label">Gambar</label>
                                            <input type="file" class="form-control" name="gambar">
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
                    <!-- Akhir Modal Tambah-->

            </div>
        </div>

        <script>
        $(document).ready(function(){
            load_data();
            function load_data(hlm){
                $.ajax({
                    url : "article_data.php",
                    method : "POST",
                    data : {hlm: hlm},
                    success : function(data){
                            $('#article_data').html(data);
                    }
                })
            } 
            $(document).on('click', '.halaman', function(){
                var hlm = $(this).attr("id");
                load_data(hlm);
            });
        });
        </script>

        <?php
            include "upload_foto.php";

            //jika tombol simpan diklik
            if (isset($_POST['simpan'])) {
                $judul = $_POST['judul'];
                $isi = $_POST['isi'];
                $tanggal = date("Y-m-d H:i:s");
                $username = $_SESSION['username'];
                $gambar = '';
                $nama_gambar = $_FILES['gambar']['name'];

                //jika ada file yang dikirim  
                if ($nama_gambar != '') {
                        //panggil function upload_foto untuk cek spesifikasi file yg dikirimkan user
                        //function ini memiliki 2 keluaran yaitu status dan message
                    $cek_upload = upload_foto($_FILES["gambar"]);

                            //cek status true/false
                    if ($cek_upload['status']) {
                            //jika true maka message berisi nama file gambar
                        $gambar = $cek_upload['message'];
                    } else {
                            //jika true maka message berisi pesan error, tampilkan dalam alert
                        echo "<script>
                            alert('" . $cek_upload['message'] . "');
                            document.location='artikel.php';
                        </script>";
                        die;
                    }
                }

                    //cek apakah ada id yang dikirimkan dari form
                if (isset($_POST['id'])) {
                    //jika ada id,    lakukan update data dengan id tersebut
                    $id = $_POST['id'];

                    if ($nama_gambar == '') {
                        //jika tidak ganti gambar
                        $gambar = $_POST['gambar_lama'];
                    } else {
                        //jika ganti gambar, hapus gambar lama
                        unlink("foto/" . $_POST['gambar_lama']);
                    }

                    $stmt = $conn->prepare("UPDATE article 
                                            SET 
                                            judul =?,
                                            isi =?,
                                            gambar = ?,
                                            tanggal = ?,
                                            username = ?
                                            WHERE id = ?");

                    $stmt->bind_param("sssssi", $judul, $isi, $gambar, $tanggal, $username, $id);
                    $simpan = $stmt->execute();
                } else {
                        //jika tidak ada id, lakukan insert data baru
                    $stmt = $conn->prepare("INSERT INTO article (judul,isi,gambar,tanggal,username)
                                            VALUES (?,?,?,?,?)");

                    $stmt->bind_param("sssss", $judul, $isi, $gambar, $tanggal, $username);
                    $simpan = $stmt->execute();
                }

                if ($simpan) {
                    echo "<script>
                        alert('Simpan data sukses');
                        document.location='artikel.php';
                    </script>";
                } else {
                    echo "<script>
                        alert('Simpan data gagal');
                        document.location='artikel.php';
                    </script>";
                }

                $stmt->close();
                $conn->close();
            }

            //jika tombol hapus diklik
            if (isset($_POST['hapus'])) {
                $id = $_POST['id'];
                $gambar = $_POST['gambar'];

                if ($gambar != '') {
                    //hapus file gambar
                    unlink("foto/" . $gambar);
                }

                $stmt = $conn->prepare("DELETE FROM article WHERE id =?");

                $stmt->bind_param("i", $id);
                $hapus = $stmt->execute();

                if ($hapus) {
                    echo "<script>
                        alert('Hapus data sukses');
                        document.location='artikel.php';
                    </script>";
                } else {
                    echo "<script>
                        alert('Hapus data gagal');
                        document.location='artikel.php';
                    </script>";
                }

                $stmt->close();
                $conn->close();
            }
            ?>


    <!-- <footer class="bg-dark text-white py-3 mt-4">
        <div class="container text-center">
          <a href="https://www.instagram.com/brennndra/profilecard/?igsh=MW9vdzVwb2YzbW01ZA==" target="_blank" class="text-white">
            <i class="bi bi-instagram" style="font-size: 2rem;"></i>
          </a><br>
          <b class="mt-3 mb-0">Brenendra &copy; 2024</b>
        </div>
      </footer> -->
</body>



<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>