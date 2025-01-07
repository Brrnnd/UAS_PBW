<?php
session_start();
include "koneksi.php";
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Diary</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="foto/logo.png">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light sticky-top p-2">
        <div class="container-fluid">
            <b class="navbar-brand fs-3" href="#">MY DIARY</b>
            
            <!-- Tombol Login dan Hamburger -->
            <div class="d-flex align-items-center">
                <!-- Tombol Hamburger -->
                <button class="navbar-toggler me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            
            <!-- Menu Navbar -->

            <div class="collapse navbar-collapse ms-md-0" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                    
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'user'): ?>
                      <a class="nav-link fs-5" href="#home">Home</a>
                      <a class="nav-link fs-5" href="#artikel">Article</a>
                      <a class="nav-link fs-5" href="#galeri">Gallery</a>
                      <a class="nav-link fs-5" href="#schedule">Schedule</a>
                      <a class="nav-link fs-5" href="#profile">Profile</a>
                    <?php endif; ?>
                    
                    
                    <!-- Menu Tambahan Khusus Admin -->
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a class="nav-link fs-5 text-primary " href="dashboard.php">Dashboard</a>
                        <a class="nav-link fs-5 text-primary " href="artikel.php">Article</a>
                    <?php endif; ?>
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
    </nav>


      <section id="home" class="hero py-5">
        <div class="container h-100">
          <div class="row align-items-center h-100">
            <div class="col-lg-7">
              <h1 class="display-4 fw-bold mb-3">Welcome to My Diary</h1>
              <p class="lead mb-4">
                Saya setiap hari Senin sampai Jumat sibuk kuliah dan mengerjakan banyak tugas. Saya healing pada Sabtu dan Minggu, karena jika tidak healing akan menyebabkan stress muda. Kuliah itu berat apalagi di kelas unggulan, tapi tidak apa-apa, robot rakitan bapak dan ibu ini tidak akan tumbang.
              </p>
              
            </div>
      
            <div class="col-lg-5">
              <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="foto/5.jpg" class="d-block w-100 rounded" alt="Image 1">
                  </div>
                  <div class="carousel-item">
                    <img src="foto/6.jpg" class="d-block w-100 rounded" alt="Image 2">
                  </div>
                  <div class="carousel-item">
                    <img src="foto/7.jpg" class="d-block w-100 rounded" alt="Image 3">
                  </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </section>


      

    <section id="artikel" class="py-5 bg-light-subtle justify-content-center">

        <?php


        // Query untuk mendapatkan data artikel
        $sql = "SELECT * FROM article";
        $result = $conn->query($sql);
        ?>
        <br><br>
        <h2 class="text-center mb-4">Article</h2>        
        <div class="container">
            <div class="row text-center">
                <?php
                if ($result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= 'foto/' . $row['gambar'] ?>" class="card-img-top" alt="<?= $row['judul'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $row['judul'] ?></h5>
                            <p class="card-text"><?= $row['isi'] ?></p>
                        </div>
                    </div>
                </div>
                <?php
                    endwhile;
                else:
                ?>
                <p class="text-center">Tidak ada artikel tersedia.</p>
                <?php
                endif;
                ?>
            </div>
        </div>
    </section>



    
      

      <section>
      <?php


      // Query untuk mendapatkan data galeri SOAL NO 2
      $sql = "SELECT * FROM gallery";
      $result = $conn->query($sql);
      ?>
        <div class="container-fluid py-5" id="galeri">
        <br><br>
          <h2 class="text-center mb-4">Gallery</h2>
          <div class="container my-5">
            <div class="row g-4">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="col-md-4">
                            <div class="card h-100 shadow">
                                <img src="uploads/<?= $row['gambar'] ?>" class="card-img-top" alt="<?= $row['nama'] ?>" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $row['nama'] ?></h5>
                                    <p class="card-text"><?= $row['deskripsi'] ?></p>
                                    <p class="text-muted small align-items-center"><?= date("d M Y", strtotime($row['tanggal'])) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center">Tidak ada data di gallery.</p>
                <?php endif; ?>
            </div>
        </div>
      </section>

      <section id="schedule" class="py-5 bg-light-subtle" >
        <br><br>

        <h2 class="text-center mb-4">Jadwal Kuliah & Kegiatan Mahasiswa</h2>        
        <div class="container">
          <div class="row text-center justify-content-center">
            <div class="col-md-1 col-lg-3 mb-4">
              <div class="card h-100 shadow-sm">
                <div class="card-header bg-danger text-white">
                  <p>Senin</p>
                </div>

                <div class="card-body text-center">
                  <b>09.00-10.30</b>
                  <p>Basis Data</p>
                  <p>Ruang H.3.4</p>
                </div>

                
                <div class="card-body text-center">
                  <b>13.00-15.00</b>
                  <p>Dasar Pemrograman</p>
                  <p>Ruang H.3.1</p>
                </div>
              </div>
            </div>
            <div class="col-md-1 col-lg-3 mb-4">
              <div class="card h-100 shadow-sm">
                <div class="card-header bg-primary text-white">
                  <p>Selasa</p>
                </div>

                <div class="card-body text-center">
                  <b>08.00-09.30</b>
                  <p>Pemrograman Berbasis Web</p>
                  <p>Ruang D.2.J</p>
                </div>

                
                <div class="card-body text-center">
                  <b>14.00-16.00</b>
                  <p>Basis Data</p>
                  <p>Ruang D.3.M</p>
                </div>
              </div>
            </div>
            <div class="col-md-1 col-lg-3 mb-4">
              <div class="card h-100 shadow-sm">
                <div class="card-header bg-warning text-white">
                  <p>Rabu</p>
                </div>

                <div class="card-body text-center">
                  <b>10.00-12.00</b>
                  <p>Pemrograman Berbasis Object</p>
                  <p>Ruang D.2.A</p>
                </div>

                
                <div class="card-body text-center">
                  <b>13.30-15.00</b>
                  <p>Pemrograman Sisi Server</p>
                  <p>Ruang D.2.A</p>
                </div>
              </div>
            </div>
            <div class="col-md-1 col-lg-3 mb-4">
              <div class="card h-100 shadow-sm">
                <div class="card-header bg-info text-white">
                  <p>Kamis</p>
                </div>

                <div class="card-body text-center">
                  <b>08.00-10.00</b>
                  <p>Pengantar Teknologi Informasi</p>
                  <p>Ruang D.3.N</p>
                </div>

                
                <div class="card-body text-center">
                  <b>11.00-13.00</b>
                  <p>Rapat Kordinasi Doscom</p>
                  <p>Ruang Rapat G.1</p>
                </div>
              </div>
            </div>

           
            
            <div class="col-md-1 col-lg-3 mb-4 align-items-center">
              <div class="card h-100 shadow-sm">
                <div class="card-header bg-secondary text-white">
                  <p>Jumat</p>
                </div>

                <div class="card-body text-center">
                  <b>09.00-11.00</b>
                  <p>Data Mining</p>
                  <p>Ruang G.2.3</p>
                </div>

                
                <div class="card-body text-center">
                  <b>13.00-15.00</b>
                  <p>Information Retriveal</p>
                  <p>Ruang G.2.4</p>
                </div>
              </div>
            </div>
            <div class="col-md-1 col-lg-3 mb-4 ">
              <div class="card h-100 shadow-sm">
                <div class="card-header bg-dark text-white">
                  <p>Sabtu</p>
                </div>

                <div class="card-body text-center">
                  <b>08.00-10.00</b>
                  <p>Bimbingan Karir</p>
                  <p>Online</p>
                </div>

                
                <div class="card-body text-center">
                  <b>10.30-12.00</b>
                  <p>Bimbingan Skripsi</p>
                  <p>Online</p>
                </div>
              </div>
            </div>
            <div class="col-md-1 col-lg-3 mb-4 align-items-center">
              <div class="card h-100 shadow-sm">
                <div class="card-header bg-success text-white">
                  <p>Minggu</p>
                </div>

                <div class="card-body text-center">
                  <p>Tidak Ada Jadwal</p>
                  <p>Ketua Capek</p>
                </div>

              </div>
            </div>
          </div>
        </div>
      </section>

      <section id="profile" class="py-5 bg-light">
        <div class="container">
          <div class="row align-items-center ">
                      <h2 class="text-center mb-4 ">Profil Mahasiswa</h2><br>

            <div class="col-md-7 col-lg-4 text-center">
              <img src="foto/foto almet.jpg" class="rounded-circle mb-3 mb-md-0" alt="Foto Mahasiswa" style="width: 200px; height: 200px; object-fit: cover;">
            </div>
            <div class="col-md-6 col-lg-8 align-items-center">
     
                  <table class="table table-borderless">

                    
                    <tbody>
                      <div class="card-body " style="text-align: center;" >
                        <tr >
                          <th scope="row" colspan="2" >
                            <h4 class="card-title text-center text-md-start " >Brenendra Putra Oktaviansyah</h4>
  
                          </th>
                        </tr>
                  

                      </div>
                     
                      <tr >
                        <th scope="row">NIM</th>
                        <td>: A11.2023.15020</td>
                      </tr>
                      <tr>
                        <th scope="row">Program Studi</th>
                        <td>: Teknik Informatika</td>
                      </tr>
                      <tr>
                        <th scope="row">Email</th>
                        <td>: 111202315020@mhs.dinus.ac.id</td>
                      </tr>
                      <tr>
                        <th scope="row">Telepon</th>
                        <td>: +62 895 423 693 800</td>
                      </tr>
                      <tr>
                        <th scope="row">Alamat</th>
                        <td>: Jl Bumiharjo Kec Guntur Kab Demak</td>
                      </tr>
                    </tbody>
                  </table>
            </div>
          </div>
        </div>
      </section>


     
      <footer class="bg-dark text-white py-3 mt-4">
        <div class="container text-center">
          <a href="https://www.instagram.com/brennndra/profilecard/?igsh=MW9vdzVwb2YzbW01ZA==" target="_blank" class="text-white">
            <i class="bi bi-instagram" style="font-size: 2rem;"></i>
          </a><br>
          <b class="mt-3 mb-0">Brenendra &copy; 2024</b>
        </div>
      </footer>


<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>