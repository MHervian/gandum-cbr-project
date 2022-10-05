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
        <title>Halaman Tambah Kasus</title>
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
            <div class="container">
                <a href="dashboard.php" class="btn btn-primary mr-2">Kembali</a>
                <span class="m-0 h5 d-inline-block text-white">Sistem CBR Penyakit Tanaman Gandum</span>
            </div>
        </header>

        <div class="bg-light">
            <div class="container pt-4 pb-4">
                <h1 class="mb-3">Form Input Kasus Baru</h1>
                <form action="hasil_proses_kasus.php" method="POST">
                    <div class="d-flex mb-3">
                        <div class="inline-form-group mr-4">
                            <label for="kecamatan">Kecamatan</label>
                            <input type="text" name="kecamatan" id="kecamatan" class="p-2 ml-1" placeholder="Nama kecamatan...">
                        </div>
                        <div class="inline-form-group form-group">
                            <label for="desa">Desa</label>
                            <input type="text" name="desa" id="desa" class="p-2 ml-1" placeholder="Nama desa...">
                        </div>
                    </div>

                    <?php
                    // Query gejala - gejala
                    require 'php_modules/koneksi.php';

                    $query = "SELECT * FROM gejala";
                    $result = mysqli_query( $conn, $query ) or die (mysqli_error($conn));
                    ?>

                    <span class="d-block h4 mb-3">Centang gejala yang ditemukan</span>
                    <table class="table">
                    <?php
                    $count = 1;
                    while ( $data = mysqli_fetch_array( $result )) {
                    ?>
                        <tr>
                            <td><?php echo $count; ?>.</td>
                            <td><?php echo $data['keterangan']; ?></td>
                            <td><input type="checkbox" name="pilihan[]" class="form-check-input" value="<?php echo $data['id_gejala']; ?>"></td>
                        </tr>
                    <?php
                        $count++;
                    }
                    mysqli_data_seek( $result, 0 );
                    ?>
                    </table>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-lg mr-3">Proses</button>
                        <button type="reset" class="btn btn-info btn-lg">Reset Ulang Input</button>
                    </div>

                </form>
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