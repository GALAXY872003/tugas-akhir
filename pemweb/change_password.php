<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }

    include 'config.php';

    $user_id = $_SESSION['user_id'];
    if(isset($_POST['old_password'])){
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $repassword = $_POST['repassword'];

        if($old_password){
            $md5_old_password = md5($old_password);
            $query = "SELECT * FROM user WHERE user_id = '$user_id' AND user_password = '$md5_old_password'";
            $result = mysqli_query($conn, $query);
            if($result->num_rows > 0){
                if($new_password != $repassword){
                    echo "<script>alert('Password Baru dan Konfirmasi Password tidak sesuai!')</script>";
                }else{
                    $md5_new_password = md5($new_password);
                    $query = "UPDATE `user` SET `user_password`='$md5_new_password' WHERE `user_id`='$user_id'";
                    $result = mysqli_query($conn, $query);
                    echo "<script>alert('Berhasil mengubah password!')</script>";
                }
            }else{
                echo "<script>alert('Password Lama Anda tidak sesuai!')</script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Home</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <style>
            body {
                background-color: #f8f9fa;
            }

            .container {
                margin-top: 50px;
            }
        </style>
    </head>
    <body>
        <?php include 'menu.php'; ?>
        <div class="container">
            <form method="post" action="change_password.php">
                <div class="form-group">
                    <label>Password Lama:</label>
                    <input type="password" class="form-control" name="old_password" placeholder="Password Lama" required>
                </div>
                <div class="form-group">
                    <label>Password Baru:</label>
                    <input type="password" class="form-control" name="new_password" placeholder="Password Baru" required>
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password:</label>
                    <input type="password" class="form-control" name="repassword" placeholder="Konfirmasi Password" required>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Ganti Password</button>
                <a href="home.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>