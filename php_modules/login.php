<?php
require 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM data_pengguna WHERE username = '".$username."' AND password = '".$password."'";
$result = mysqli_query( $conn, $query ) or die (mysqli_error($conn));
$data = mysqli_fetch_array( $result );

if ( mysqli_num_rows( $result ) != 0 ) {

    session_start();
    $_SESSION['username'] = $data['username'];
    $_SESSION['level_akses'] = $data['level_akses'];
    header('location:http://localhost/gandum_cbr/dashboard.php');
}

header('location:http://localhost/gandum_cbr');

?>