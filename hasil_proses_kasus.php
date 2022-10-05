<?php
session_start();
if (empty($_SESSION['username']))
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
    <title>Halaman Hasil Proses Kasus</title>
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

    <?php
    require 'php_modules/koneksi.php';
    require 'php_modules/proses_hitung_bobot/hitung_bobot.php';

    if (empty($_POST['kecamatan']) || empty($_POST['desa'])) {
    ?>
        <div class="container">
            <p class="bg-danger text-center rounded pt-2 pb-2 mt-5 mb-5 text-white">Data nama kecamatan atau desa belum lengkap. Silahkan melengkapi dahulu.</p>
        </div>
    <?php
        return;
    }

    if (empty($_POST['pilihan'])) {
    ?>
        <div class="container">
            <p class="bg-danger text-center rounded pt-2 pb-2 mt-5 mb-5 text-white">Anda belum menginput pilihan yang diberikan.</p>
        </div>
    <?php
        return;
    } else {
        $nama_kecamatan = $_POST['kecamatan'];
        $nama_desa = $_POST['desa'];
        $pilihan = $_POST['pilihan'];

        // Query jumlah data kasus
        $query = "SELECT COUNT(id_lokasi_kasus) AS jml_kasus FROM lokasi_kasus";
        $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
        $data_kasus = mysqli_fetch_array($result);
        $jumlah_kasus = $data_kasus['jml_kasus'];

        // Query semua data kasus beserta penyakitnya secara lengkap
        $query = "SELECT id_lokasi_kasus, id_penyakit FROM lokasi_kasus";
        $result_kasus_lama = mysqli_query($conn, $query) or die(mysqli_error($conn));

        // Membuat variabel array simpanan hasil similarity
        $array_nilai_similaritas = [];
        $iterasi = 0;

        while ($data_kasus_lama = mysqli_fetch_array($result_kasus_lama)) {
            // Ambil data id_lokasi_kasus dan id_penyakit
            $id_lokasi_kasus = $data_kasus_lama['id_lokasi_kasus'];
            $id_penyakit = $data_kasus_lama['id_penyakit'];

            // Query gejala kasus lama tersebut
            $query = "SELECT * FROM gejala_kasus WHERE id_lokasi_kasus = " . $id_lokasi_kasus;
            $result_gejala_kasus = mysqli_query($conn, $query) or die(mysqli_error($conn));

            $pembilang = 0;
            $penyebut = 0;

            for ($i = 0; $i < count($pilihan); $i++) {
                while ($data_gejala_kasus = mysqli_fetch_array($result_gejala_kasus)) {
                    if ($pilihan[$i] == $data_gejala_kasus['id_gejala']) {
                        $id_gejala = $data_gejala_kasus['id_gejala'];

                        $pembilang += (1 * $bobot[$id_penyakit][$id_gejala]);
                        // $penyebut += $bobot[$id_penyakit][$id_gejala];
                    }
                }

                mysqli_data_seek($result_gejala_kasus, 0);
            }

            $penyebut = $bobot[$id_penyakit]['penyebut'];

            $array_nilai_similaritas['K' . $id_lokasi_kasus] = ($pembilang / $penyebut) * 1.0;

            $iterasi++;
        }

        // echo "Nilai Similaritas<br><pre>";
        // print_r($array_nilai_similaritas);
        // echo "</pre><br><br>";

        arsort($array_nilai_similaritas);

        // echo "Nilai Similaritas<br><pre>";
        // print_r($array_nilai_similaritas);
        // echo "</pre><br><br>";

        $keys = array_keys($array_nilai_similaritas);

        // echo "<pre>";
        // print_r($keys);
        // echo "</pre>"

        // Get the first key
        $key = $keys[0];
        $id_kasus = str_replace('K', '', $key);
    ?>

        <div class="bg-light">
            <div class="container pt-4 pb-4">
                <div class="mt-4 mb-4">
                    <table class="table">
                        <tr>
                            <td>Kecamatan</td>
                            <td>:</td>
                            <td><?php echo $nama_kecamatan; ?></td>
                        </tr>
                        <tr>
                            <td>Desa</td>
                            <td>:</td>
                            <td><?php echo $nama_desa; ?></td>
                        </tr>
                    </table>
                </div>
                <h2 class="mb-3">Gejala yang Dipilih</h1>
                    <table class="table table-striped">
                        <tr>
                            <th>No.</th>
                            <th>Kode Gejala</th>
                            <th>Gejala</th>
                        </tr>
                        <?php
                        for ($i = 0; $i < count($pilihan); $i++) {
                            $query = "SELECT id_gejala, keterangan FROM gejala WHERE id_gejala = '" . $pilihan[$i] . "'";
                            $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                            $data_gejala_keterangan = mysqli_fetch_array($result);
                        ?>
                            <tr>
                                <td><?php echo ($i + 1); ?></td>
                                <td><?php echo $data_gejala_keterangan['id_gejala']; ?></td>
                                <td><?php echo $data_gejala_keterangan['keterangan']; ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>

                    <h2 class="mt-3 mb-3">Kasus - Kasus yang Similar</h2>
                    <table class="table table-striped">
                        <tr>
                            <th>No.</th>
                            <th>Kecamatan</th>
                            <th>Desa</th>
                            <th>Penyakit</th>
                            <th>Latin</th>
                            <th>Nilai Similar</th>
                        </tr>
                        <?php
                        for ($i = 0; $i < count($array_nilai_similaritas); $i++) {
                            $key = $keys[$i];
                            $id_lokasi_kasus = str_replace('K', '', $keys[$i]);
                            $query = "SELECT 
                                lokasi_kasus.kecamatan AS kecamatan, 
                                lokasi_kasus.desa AS desa, 
                                penyakit.nama_penyakit AS nama_penyakit, 
                                penyakit.bahasa_latin AS bahasa_latin 
                                FROM penyakit INNER JOIN lokasi_kasus ON lokasi_kasus.id_penyakit = penyakit.id_penyakit 
                                WHERE id_lokasi_kasus = " . $id_lokasi_kasus;
                            $result_penyakit = mysqli_query($conn, $query) or die(mysqli_error($conn));
                            $data_penyakit = mysqli_fetch_array($result_penyakit);
                        ?>
                            <tr>
                                <td><?php echo ($i + 1); ?></td>
                                <td><?php echo $data_penyakit['kecamatan']; ?></td>
                                <td><?php echo $data_penyakit['desa']; ?></td>
                                <td><?php echo $data_penyakit['nama_penyakit']; ?></td>
                                <td style="font-style: italic;"><?php echo $data_penyakit['bahasa_latin']; ?></td>
                                <td><?php echo $array_nilai_similaritas[$key]; ?></td>
                            </tr>
                        <?php
                        }

                        $query = "SELECT 
                            penyakit.id_penyakit AS id_penyakit, 
                            penyakit.nama_penyakit AS nama_penyakit 
                            FROM penyakit INNER JOIN lokasi_kasus ON lokasi_kasus.id_penyakit = penyakit.id_penyakit 
                            WHERE lokasi_kasus.id_lokasi_kasus = " . $id_kasus;

                        $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                        $data = mysqli_fetch_array($result);

                        $id_penyakit = $data['id_penyakit'];
                        ?>
                    </table>

                    <h2 class="text-center">Kesimpulan</h2>
                    <p class="text-center bg-primary h4 text-white pt-2 pb-2"><?php echo $data['nama_penyakit']; ?></p>

                    <!-- Form buat proses simpan data hasil perhitungan kasus ke basis data -->
                    <?php
                    $address = (isset($_POST['proses_edit'])) ? "php_modules/proses_update/update_kasus.php" : "php_modules/proses_insert/simpan_kasus.php";
                    ?>

                    <form action="<?php echo $address; ?>" method="POST">
                        <?php
                        $btn_name = "Simpan Hasil Perhitungan";
                        if (isset($_POST['proses_edit'])) {
                            $btn_name = "Update Hasil Perhitungan";
                        ?>
                            <input type="hidden" name="id_lokasi_kasus" value="<?php echo $_POST['id_lokasi_kasus']; ?>">
                        <?php
                        }
                        ?>
                        <input type="hidden" name="kecamatan" value="<?php echo $nama_kecamatan; ?>">
                        <input type="hidden" name="desa" value="<?php echo $nama_desa; ?>">
                        <input type="hidden" name="id_penyakit" value="<?php echo $id_penyakit; ?>">
                        <?php
                        for ($i = 0; $i < count($pilihan); $i++) {
                        ?>
                            <input type="hidden" name="pilihan[]" value="<?php echo $pilihan[$i]; ?>">
                        <?php
                        }
                        ?>
                        <div class="mt-5" style="text-align: right;">
                            <button type="submit" class="btn btn-primary btn-lg"><?php echo $btn_name; ?></button>
                        </div>
                    </form>
            </div>
        </div>

    <?php } ?>

    <div class="mt-4 pt-3 pb-3 bg-darkblue">
        <p class="m-0 text-white text-center">&copy;Copyright 2020</p>
    </div>

    <!-- JQuery -->
    <script src="res/js/jquery.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="res/js/bootstrap.min.js"></script>
</body>

</html>