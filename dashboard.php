<?php
session_start();
if ( empty($_SESSION['username']) )
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
        <title>Halaman Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="res/css/bootstrap.min.css">
        <link rel="stylesheet" href="res/css/icofont.min.css">
        <link rel="stylesheet" href="res/css/style.css">
    </head>
    <body class="bg-gray">
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
                        <h2 class="m-0 pt-2 pl-3 pr-3">Dashboard</h4>
                        <figure class="mt-2 img-header">
                            <img src="res/img/wheat.jpg" class="img-fluid">
                        </figure>
                        <div class="mt-3 pt-2 pb-2 pl-3 pr-3">
                            <?php
                            // Melakukan query jumlah data kasus, penyakit, gejala
                            require 'php_modules/koneksi.php';

                            // Query jumlah data kasus
                            $query = "SELECT COUNT(id_lokasi_kasus) AS jumlah_kasus FROM lokasi_kasus";
                            $result = mysqli_query( $conn, $query ) or die (mysqli_error( $conn ));
                            $data = mysqli_fetch_array( $result );
                            $jml_kasus = $data['jumlah_kasus'];

                            // Query jumlah data penyakit
                            $query = "SELECT COUNT(id_penyakit) AS jumlah_penyakit FROM penyakit";
                            $result = mysqli_query( $conn, $query ) or die (mysqli_error( $conn ));
                            $data = mysqli_fetch_array( $result );
                            $jml_penyakit = $data['jumlah_penyakit'];

                            // Query jumlah data gejala
                            $query = "SELECT COUNT(id_gejala) AS jumlah_gejala FROM gejala";
                            $result = mysqli_query( $conn, $query ) or die (mysqli_error( $conn ));
                            $data = mysqli_fetch_array( $result );
                            $jml_gejala = $data['jumlah_gejala'];
                            ?>
                            <div class="d-flex">
                                <div class="flex-fill text-center">
                                    <p>Data Kasus</p>
                                    <p class="h1"><?php echo $jml_kasus; ?></p>
                                </div>
                                <div class="flex-fill text-center">
                                    <p>Data Penyakit</p>
                                    <p class="h1"><?php echo $jml_penyakit; ?></p>
                                </div>
                                <div class="flex-fill text-center">
                                    <p>Data Gejala</p>
                                    <p class="h1"><?php echo $jml_gejala; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 bg-white shadow-sm">
                        <div class="pt-3 pl-3 pr-3 d-flex">
                            <h4 class="d-inline-block m-0">Data Kasus</h3><a href="data_kasus.php" class="ml-3 align-self-center">More Data...</a>
                        </div>
                        <div class="mt-3 pt-2 pb-2 pl-3 pr-3">
                            <?php
                            // Query 3 data kasus
                            $query = "SELECT 
                                        lokasi_kasus.id_lokasi_kasus AS id_lokasi_kasus,
                                        lokasi_kasus.kecamatan AS kecamatan,
                                        lokasi_kasus.desa AS desa,
                                        penyakit.nama_penyakit AS nama_penyakit  
                                        FROM lokasi_kasus INNER JOIN penyakit ON penyakit.id_penyakit = lokasi_kasus.id_penyakit 
                                        LIMIT 3";
                            $result = mysqli_query( $conn, $query ) or die (mysqli_error( $conn ));
                            ?>
                            <table class="table table-striped">
                                <tr>
                                    <th>No.</th>
                                    <th>Kecamatan</th>
                                    <th>Desa</th>
                                    <th>Penyakit</th>
                                    <th>Aksi</th>
                                </tr>
                            <?php
                            $count = 1;
                            while ( $data = mysqli_fetch_array( $result )) {
                            ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $data['kecamatan']; ?></td>
                                    <td><?php echo $data['desa']; ?></td>
                                    <td><?php echo $data['nama_penyakit']?></td>
                                    <td>
                                        <a href="detail_kasus.php?id_lokasi_kasus=<?php echo $data['id_lokasi_kasus']; ?>" class="btn btn-info">Detail</a>
                                        <a href="edit_kasus.php?id_lokasi_kasus=<?php echo $data['id_lokasi_kasus']; ?>" class="btn btn-primary">Edit</a>
                                        <a href="php_modules/proses_hapus/hapus_data_kasus.php?id_lokasi_kasus=<?php echo $data['id_lokasi_kasus']; ?>" 
                                        class="btn btn-danger" onclick="return confirm('Tekan \'Ok\' untuk menghapus data')">Hapus</a>
                                    </td>
                                </tr>
                            <?php
                                $count++;
                            }
                            ?>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4 bg-white shadow-sm">
                        <div class="pt-3 pl-3 pr-3 d-flex">
                            <h4 class="d-inline-block m-0">Data Penyakit</h3><a href="data_penyakit.php" class="ml-3 align-self-center">More Data...</a>
                        </div>
                        <div class="mt-3 pt-2 pb-2 pl-3 pr-3">
                            <?php
                            // Query data penyakit
                            $query = "SELECT * FROM penyakit LIMIT 3";
                            $result = mysqli_query( $conn, $query ) or die (mysqli_error($conn));
                            ?>
                            <table class="table table-striped">
                                <tr>
                                    <th>No.</th>
                                    <th>Penyakit</th>
                                    <th>Nama Latin</th>
                                    <th>Aksi</th>
                                </tr>
                            <?php
                            $count = 1;
                            while ( $data = mysqli_fetch_array( $result )) {
                            ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $data['nama_penyakit']; ?></td>
                                    <td style="font-style: italic;"><?php echo $data['bahasa_latin']; ?></td>
                                    <td>
                                        <a href="detail_penyakit.php?id_penyakit=<?php echo $data['id_penyakit']; ?>" class="btn btn-info">Detail</a>
                                        <!-- <a href="#" class="btn btn-primary">Update</a>
                                        <a href="#" class="btn btn-danger">Hapus</a> -->
                                    </td>
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