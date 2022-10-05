<?php

require '../koneksi.php';

$id_lokasi_kasus = $_GET['id_lokasi_kasus'];

// Hapus semua data gejala pada kasus
$query = "DELETE FROM gejala_kasus WHERE id_lokasi_kasus = " . $id_lokasi_kasus;
mysqli_query($conn, $query) or die (mysqli_error($conn));

// Hapus lokasi data kasus
$query = "DELETE FROM lokasi_kasus WHERE id_lokasi_kasus = " . $id_lokasi_kasus;
mysqli_query($conn, $query) or die (mysqli_error($conn));

header('location:http://localhost/gandum_cbr/data_kasus.php');