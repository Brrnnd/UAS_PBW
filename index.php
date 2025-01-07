<?php
session_start();
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
                <a href="login.php" class="btn btn-success fs-5">Login</a>

                </div>
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


      

   