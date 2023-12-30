<?php
    include 'config.php';

    $user_id = $_GET['id'];
    $query = "DELETE FROM `user` WHERE `user_id` = '$user_id'";
    $result = mysqli_query($conn, $query);
    header("Location: user.php");
    exit();
?>