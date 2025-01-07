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
            
    <H3 class="p-3">Dashboard</H3> <hr>  
    
    
    <?php
    //query untuk mengambil data article
    $sql1 = "SELECT * FROM article ORDER BY tanggal DESC";
    $hasil1 = $conn->query($sql1);

    //menghitung jumlah baris data article
    $jumlah_article = $hasil1->num_rows;

    //query untuk mengambil data gallery
    $sql2 = "SELECT * FROM gallery ORDER BY tanggal DESC";
    $hasil2 = $conn->query($sql2);

    //menghitung jumlah baris data gallery
    $jumlah_gallery = $hasil2->num_rows;

     //query untuk mengambil data user
     $sql3 = "SELECT * FROM user ORDER BY id DESC";
     $hasil3 = $conn->query($sql3);
 
     //menghitung jumlah baris data user
     $jumlah_user = $hasil3->num_rows;


    ?>
    <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center pt-4">
        <div class="col">
            <div class="card border border-danger mb-3 shadow" style="max-width: 18rem;">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="p-3">
                            <h5 class="card-title"><i class="bi bi-newspaper"></i> Article</h5> 
                        </div>
                        <div class="p-3">
                            <span class="badge rounded-pill text-bg-danger fs-2"><?php echo $jumlah_article; ?></span>
                        </div> 
                    </div>
                </div>
            </div>
        </div> 
        <div class="col">
            <div class="card border border-danger mb-3 shadow" style="max-width: 18rem;">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="p-3">
                            <h5 class="card-title"><i class="bi bi-camera"></i> Gallery</h5> 
                        </div>
                        <div class="p-3">
                            <span class="badge rounded-pill text-bg-danger fs-2"><?php echo $jumlah_gallery; ?></span>
                        </div> 
                    </div>
                </div>
            </div>
        </div> 
        <div class="col">
            <div class="card border border-danger mb-3 shadow" style="max-width: 18rem;">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="p-3">
                            <h5 class="card-title"><i class="bi bi-person"></i> User</h5> 
                        </div>
                        <div class="p-3">
                            <span class="badge rounded-pill text-bg-danger fs-2"><?php echo $jumlah_user; ?></span>
                        </div> 
                    </div>
                </div>
            </div>
        </div> 
    </div>

    
    <!-- <footer class="bg-dark text-white py-3 mt-4 d-flex flex-column mt-auto min-vh-100vh">
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