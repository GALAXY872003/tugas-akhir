<?php
    $host = '127.0.0.1';
    $username = 'root';
    $password = '';
    $database = 'db_project_unisnu';

    $conn = mysqli_connect($host, $username, $password, $database);

    if(!$conn){
        die("Koneksi database gagal: ".mysqli_connect_error());
    }
?>