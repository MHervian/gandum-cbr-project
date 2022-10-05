<?php
session_start();
if ( empty( $_SESSION['username'] ))
    header('location:http://localhost/gandum_cbr/');
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
        <title>Halaman Data Kasus</title>
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
                        <h2 class="m-0 pt-2 pl-3 pr-3">Data Kasus</h2>
                        <div class="mt-2 pb-2 pl-3 pr-3 border-bottom">
                            <a href="tambah_kasus.php" class="btn btn-primary">Tambah Data Kasus</a>
                        </div>
                        <div class="mt-4 pt-2 pb-2 pl-3 pr-3">
                            <table class="table table-striped table-responsive table-bordered">
                                <tr>
                                    <th rowspan="2" class="text-center">No.</th>
                                    <th rowspan="2" class="text-center">Kecamatan</th>
                                    <th rowspan="2" class="text-center">Desa</th>
                                    <th colspan="24" class="text-center">Kode Gejala</th>
                                    <th rowspan="2" class="text-center">Penyakit</th>
                                    <th colspan="3" rowspan="2" class="text-center">Aksi</th>
                                </tr>
                            <?php
                            // Query semua kode gejala dan menampilkan table heading
                            require 'php_modules/koneksi.php';

                            $query = "SELECT id_gejala FROM gejala";
                            $result = mysqli_query( $conn, $query ) or die (mysqli_error( $conn ));
                            $jumlah_gejala = mysqli_num_rows( $result );
                            ?>
                                <tr>
                            <?php
                            while ( $data_gejala = mysqli_fetch_array( $result ) ) {
                            ?>
                                    <th><?php echo $data_gejala['id_gejala']; ?></th>
                            <?php
                            }
                            ?>
                                </tr>

                            <?php
                            // Query data kasus beserta gejala di kasusnya
                            $query = "SELECT 
                                        lokasi_kasus.id_lokasi_kasus AS id_lokasi_kasus,
                                        lokasi_kasus.kecamatan AS kecamatan,
                                        lokasi_kasus.desa AS desa,
                                        penyakit.id_penyakit AS id_penyakit,
                                        penyakit.nama_penyakit AS nama_penyakit 
                                        FROM lokasi_kasus INNER JOIN penyakit ON penyakit.id_penyakit = lokasi_kasus.id_penyakit";
                            $result = mysqli_query( $conn, $query ) or die (mysqli_error( $conn ));

                            $count = 1;
                            while ( $data = mysqli_fetch_array($result) ) {
                            ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $data['kecamatan']; ?></td>
                                    <td><?php echo $data['desa']; ?></td>
                            <?php
                                $query_gejala_kasus = "SELECT id_gejala FROM gejala_kasus WHERE id_lokasi_kasus = " . $data['id_lokasi_kasus'];
                                $result_gejala_kasus = mysqli_query( $conn, $query_gejala_kasus ) or die (mysqli_error($conn));
                                $data_gejala_kasus = mysqli_fetch_array($result_gejala_kasus);
                                
                                for ( $i = 1; $i <= $jumlah_gejala; $i++ ) {
                                    $prefix = ($i < 10)? 'G0'.$i : 'G'.$i;
                                    
                                    if ( !empty( $data_gejala_kasus['id_gejala'] ) ) {
                                        if ( $data_gejala_kasus['id_gejala'] == $prefix ) {
                                            echo "<td> 1 </td>";
                                            $data_gejala_kasus = mysqli_fetch_array( $result_gejala_kasus );
                                        } else {
                                            echo "<td> - </td>";
                                        }
                                    } else {
                                        echo "<td> - </td>";
                                    }
                                }
                            ?>
                            <?php
                            
                            ?>
                                    <td><?php echo $data['nama_penyakit']; ?></td>
                                    <td>
                                        <a href="detail_kasus.php?id_lokasi_kasus=<?php echo $data['id_lokasi_kasus']; ?>" class="btn btn-info">Detail</a>
                                    </td>
                                    <td>
                                        <a href="edit_kasus.php?id_lokasi_kasus=<?php echo $data['id_lokasi_kasus'];?>" class="btn btn-primary">Edit</a>
                                    </td>
                                    <td>
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
                        <!-- <div class="mt-4 pt-2 pb-2 pl-3 pr-3">
                            <?php
                            require 'php_modules/koneksi.php';
                            // Query semua data kasus
                            $query = "SELECT 
                                        lokasi_kasus.id_lokasi_kasus AS id_lokasi_kasus,
                                        lokasi_kasus.kecamatan AS kecamatan,
                                        lokasi_kasus.desa AS desa,
                                        penyakit.nama_penyakit AS nama_penyakit  
                                        FROM lokasi_kasus INNER JOIN penyakit ON penyakit.id_penyakit = lokasi_kasus.id_penyakit";
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
                            while ( $data = mysqli_fetch_array( $result ) ) {
                            ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $data['kecamatan']; ?></td>
                                    <td><?php echo $data['desa']; ?></td>
                                    <td><?php echo $data['nama_penyakit']; ?></td>
                                    <td>
                                        <a href="detail_kasus.php?id_lokasi_kasus=<?php echo $data['id_lokasi_kasus']; ?>" class="btn btn-info">Detail</a>
                                        <a href="#" class="btn btn-primary">Update</a>
                                        <a href="#" class="btn btn-danger">Hapus</a>
                                    </td>
                                </tr>
                            <?php
                                $count++;
                            }
                            ?>
                            </table>
                        </div> -->
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