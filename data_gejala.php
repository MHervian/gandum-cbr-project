<?php
session_start();
if ( empty( $_SESSION['username'] ) )
    header('location:http://localhost/gandum_cbr');
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Halaman Data Gejala</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="res/css/bootstrap.min.css">
        <link rel="stylesheet" href="res/css/icofont.min.css">
        <link rel="stylesheet" href="res/css/style.css">
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <header class="pt-2 pb-2 bg-blue shadow-sm">
            <div class="container-fluid d-flex justify-content-between">
                <h1 class="m-0 h4">Sistem CBR Penyakit Tanaman Gandum</h1>
                <a href="php_modules/logout.php" class="btn-logout">Logout</a>
            </div>
        </header>

        <div class="container-fluid mt-4">
            <div class="row">

                <div class="col-md-3">
                    <div class="side-navigation pt-4 shadow-sm bg-white">
                        <figure class="mb-3">
                            <img src="res/img/wheat_wallpaper.jpg" class="circle-img">
                        </figure>
                        <div class="pl-2 pr-2 mb-4">
                            <span class="d-block text-center" style="color: #999999;">Halo</span>
                            <span class="d-block text-center h4"><?php echo $_SESSION['username']; ?></span>
                        </div>
                        <?php
                        include 'navigasi.php';
                        ?>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="bg-white shadow-sm">
                        <h2 class="m-0 pt-2 pl-3 pr-3">Data Gejala</h2>
                        <div class="mt-4 pt-2 pb-2 pl-3 pr-3">
                            <?php
                            // Query semua data penyakit
                            require 'php_modules/koneksi.php';

                            $query = "SELECT * FROM gejala";
                            $result = mysqli_query( $conn, $query ) or die (mysqli_error($conn));
                            ?>
                            <table class="table table-striped">
                                <tr>
                                    <th>No.</th>
                                    <th>Kode Gejala</th>
                                    <th>Keterangan Gejala</th>
                                    <!-- <th>Aksi</th> -->
                                </tr>
                            <?php
                            $count = 1;
                            while ( $data = mysqli_fetch_array( $result )) {
                            ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $data['id_gejala']; ?></td>
                                    <td><?php echo $data['keterangan']; ?></td>
                                    <!-- <td>
                                        <a href="detail_penyakit.php?id_penyakit=<?php echo $data['id_penyakit']; ?>" class="btn btn-info">Detail</a>
                                        <a href="#" class="btn btn-primary">Update</a>
                                        <a href="#" class="btn btn-danger">Hapus</a>
                                    </td> -->
                                </tr>
                            <?php
                                $count++;
                            }
                            ?>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        
        <div class="mt-4 pt-3 pb-3 bg-darkblue">
            <p class="m-0 text-white text-center">&copy;Copyright 2020</p>
        </div>
        
        <!-- JQuery -->
        <script src="res/js/jquery.min.js"></script>
        <!-- Bootstrap JS -->
        <script src="res/js/bootstrap.min.js"></script>
    </body>
</html>