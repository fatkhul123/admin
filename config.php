<?php
//Kredensial database, dengan asumsi username : root, password : ''
define('DB_SERVER', 'localhost'); //url atau alamat server, dapat diganti dengan 127.0.0.1
define('DB_USERNAME', 'root'); //username yang digunakan untuk akses database engine
define('DB_PASSWORD', ''); //password yang digunakan untuk akses database engine
define('DB_NAME', 'crud'); //nama database yang akan digunakan
 
//fungsi untuk mengoneksikan ke database
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// fungsi untuk cek config
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>