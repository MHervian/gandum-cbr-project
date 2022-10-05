<?php
session_start();
if ( empty( $_SESSION['username'] ))
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
        <title>Halaman Detail Kasus</title>
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
            <div class="container d-flex justify-content-between">
                <h1 class="m-0 h4">Sistem CBR Penyakit Tanaman Gandum</h1>
                <a href="php_modules/logout.php" class="btn-logout">Logout</a>
            </div>
        </header>

        <div class="container mt-4">
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
                        <h2 class="m-0 pt-2 pl-3 pr-3">Detail Kasus</h2>
                        <div class="mt-3 pt-2 pb-2 pl-3 pr-3">
                            <a href="edit_kasus.php?id_lokasi_kasus=<?php echo $_GET['id_lokasi_kasus']; ?>" class="btn btn-primary mb-4">Edit Kasus</a>
                            <?php
                            // Query detail kasus 
                            require 'php_modules/koneksi.php';

                            $id_lokasi_kasus = $_GET['id_lokasi_kasus'];
                            $query = "SELECT 
                                        lokasi_kasus.id_lokasi_kasus AS id_lokasi_kasus,
                                        lokasi_kasus.kecamatan AS kecamatan,
                                        lokasi_kasus.desa AS desa,
                                        penyakit.id_penyakit AS id_penyakit, 
                                        penyakit.nama_penyakit AS nama_penyakit, 
                                        penyakit.bahasa_latin AS bahasa_latin 
                                        FROM lokasi_kasus INNER JOIN penyakit ON penyakit.id_penyakit = lokasi_kasus.id_penyakit 
                                        WHERE lokasi_kasus.id_lokasi_kasus = " . $id_lokasi_kasus;
                            $result = mysqli_query( $conn, $query ) or die (mysqli_error( $conn ));
                            $data = mysqli_fetch_array( $result );
                            ?>
                            <table class="table table-striped">
                                <tr>
                                    <td>Kecamatan</td>
                                    <td>:</td>
                                    <td><?php echo $data['kecamatan']; ?></td>
                                </tr>
                                <tr>
                                    <td>Desa</td>
                                    <td>:</td>
                                    <td><?php echo $data['desa']; ?></td>
                                </tr>
                                <tr>
                                    <td>Hasil Identifikasi</td>
                                    <td>:</td>
                                    <td><?php echo $data['nama_penyakit']; ?></td>
                                </tr>
                                <tr>
                                    <td>Nama Latin</td>
                                    <td>:</td>
                                    <td style="font-style:italic;"><?php echo $data['bahasa_latin']; ?></td>
                                </tr>
                            </table>

                            <h4 class="mt-4">Gejala - Gejala di Kasus</h4>
                            <?php
                            // Query gejala yang didapat dari kasus tersebut
                            $id_penyakit = $data['id_penyakit'];
                            $query = "SELECT * FROM gejala_kasus WHERE id_lokasi_kasus = '".$id_lokasi_kasus."'";
                            $result = mysqli_query( $conn, $query ) or die (mysqli_error($conn));
                            ?>
                            <table class="table">
                                <tr>
                                    <th>No.</th>
                                    <th>Gejala</th>
                                    <th>Kode Gejala</th>
                                </tr>
                            <?php
                            $count = 1;
                            while ( $data = mysqli_fetch_array( $result )) {
                                $query_gejala_penyakit = "SELECT id_gejala, keterangan FROM gejala WHERE id_gejala = '".$data['id_gejala']."'";
                                $result_gejala = mysqli_query( $conn, $query_gejala_penyakit ) or die (mysqli_error($conn));
                                $data_gejala = mysqli_fetch_array($result_gejala);
                            ?>
                                <tr>
                                    <td><?php echo $count; ?></td>
                                    <td><?php echo $data_gejala['keterangan'];?></td>
                                    <td><?php echo $data_gejala['id_gejala']; ?></td>
                                </tr>
                            <?php
                                $count++;
                            }
                            ?>
                            </table>
                        </div>
                        <div class="mt-3 pt-2 pb-2 pl-3 pr-3">
                            <h4>Penanganan Penyakit</h4>
                            <?php
                            // Query penanganan
                            $query = "SELECT * FROM penanganan WHERE id_penyakit = '$id_penyakit'";
                            $result = mysqli_query($conn, $query) or die (mysqli_error($conn));
                            $data = mysqli_fetch_array($result);
                            $penanganan = explode(";", $data['penanganan']);
                            $jmlh_penanganan = count($penanganan);
                            ?>
                            <table class="table table-striped">
                                <tr>
                                    <th>No.</th>
                                    <th>Upaya</th>
                                </tr>
                            <?php
                            for ( $i = 0; $i < $jmlh_penanganan; $i++ ) {
                            ?>
                                <tr>
                                    <td><?php echo ($i + 1);?></td>
                                    <td><?php echo $penanganan[$i]; ?></td>
                                </tr>
                            <?php
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