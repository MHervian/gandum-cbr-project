<?php
// require("../koneksi.php");
// Query semua data id_lokasi_kasus, id_penyakit dari tabel lokasi_kasus
$query = "SELECT DISTINCT(id_penyakit) AS id_penyakit FROM lokasi_kasus";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));

$bobot = array();

// Memulai perulangan untuk menghitung setiap bobot gejala dari penyakit masing2
while ($data = mysqli_fetch_array($result)) {
    // Query jumlah kasus berdasarkan id_penyakit
    $query = "SELECT COUNT(id_lokasi_kasus) AS jmlh_kasus FROM lokasi_kasus WHERE id_penyakit = '" . $data['id_penyakit'] . "'";
    $result_jmlh_kasus = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $data_jml_kasus = mysqli_fetch_array($result_jmlh_kasus);

    $bobot[$data['id_penyakit']] = array();

    // Query jumlah masing2 gejala per kasus berdasarkan penyakit kasus 
    $query = "SELECT
        gejala_kasus.id_gejala AS id_gejala,
        COUNT(gejala_kasus.id_gejala) AS jmlh_gejala 
        FROM gejala_kasus INNER JOIN lokasi_kasus ON lokasi_kasus.id_lokasi_kasus = gejala_kasus.id_lokasi_kasus 
        WHERE lokasi_kasus.id_penyakit = '" . $data['id_penyakit'] . "' GROUP BY gejala_kasus.id_gejala";
    $result_jml_gejala_kasus = mysqli_query($conn, $query) or die(mysqli_error($conn));

    $jmlh_bobot = 0;

    while ($data_jml_gejala_kasus = mysqli_fetch_array($result_jml_gejala_kasus)) {
        $nilai_bobot = ($data_jml_gejala_kasus['jmlh_gejala'] / $data_jml_kasus['jmlh_kasus']) * 1.0;

        $id_gejala = $data_jml_gejala_kasus['id_gejala'];
        $id_penyakit = $data['id_penyakit'];
        $bobot[$id_penyakit][$id_gejala] = $nilai_bobot;
        $jmlh_bobot += $nilai_bobot;
    }

    $bobot[$id_penyakit]['penyebut'] = $jmlh_bobot;
}
