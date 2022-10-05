<?php

require '../koneksi.php';

echo "<pre>";
var_dump($_POST);
echo "</pre>";

$id_lokasi_kasus = $_POST['id_lokasi_kasus'];
$kecamatan = $_POST['kecamatan'];
$desa = $_POST['desa'];
$id_penyakit = $_POST['id_penyakit'];
$pilihan = $_POST['pilihan'];
$length = count($pilihan);

// Update lokasi kasus
$query = "UPDATE lokasi_kasus SET 
    kecamatan = '$kecamatan', 
    desa = '$desa', 
    id_penyakit = '$id_penyakit' 
    WHERE id_lokasi_kasus = " . $id_lokasi_kasus;
mysqli_query( $conn, $query ) or die (mysqli_error($conn));

// Hapus data gejala di tabel gejala_kasus
$query = "DELETE FROM gejala_kasus WHERE id_lokasi_kasus = " . $id_lokasi_kasus;
mysqli_query( $conn, $query ) or die (mysqli_error($conn));

// Insert dengan gejala baru ke tabel gejala_kasus
for ( $i = 0; $i < $length; $i++ ){
    $tmp_data_pilihan = $pilihan[$i];
    $query = "INSERT INTO gejala_kasus(id_gejala, id_lokasi_kasus) VALUES('$tmp_data_pilihan', $id_lokasi_kasus)";
    mysqli_query( $conn, $query ) or die (mysqli_error( $conn ));
}

header('location:http://localhost/gandum_cbr/data_kasus.php');

?>