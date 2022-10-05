<?php
require '../koneksi.php';

$nama_kecamatan = $_POST['kecamatan'];
$nama_desa = $_POST['desa'];
$pilihan = $_POST['pilihan'];
$id_penyakit = $_POST['id_penyakit'];

// Insert lokasi kasus
$query = "INSERT INTO lokasi_kasus(kecamatan, desa, id_penyakit) VALUES('$nama_kecamatan','$nama_desa', '$id_penyakit')";
$result = mysqli_query( $conn, $query ) or die (mysqli_error($conn));

$id_lokasi_kasus = mysqli_insert_id($conn);

// Insert gejala di lokasi kasus
for ( $i = 0; $i < count($pilihan); $i++ ){
    $tmp_id_gejala = $pilihan[$i];
    $query = "INSERT INTO gejala_kasus(id_gejala, id_lokasi_kasus) VALUES('$tmp_id_gejala', $id_lokasi_kasus)";
    $result = mysqli_query( $conn, $query ) or die (mysqli_error($conn));
}

header('location:http://localhost/gandum_cbr/data_kasus.php');

?>