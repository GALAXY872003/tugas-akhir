<?php
    include 'config.php';
    session_start();

    if(isset($_POST['username'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $md5_password = md5($password);

        $query = "SELECT * FROM user WHERE user_name = '$username' AND user_password = '$md5_password'";
        $result = mysqli_query($conn, $query);

        if($result->num_rows > 0){
            $row = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['user_name'];
            $_SESSION['fullname'] = $row['user_fullname'];
            header("Location: home.php");
            exit();
        }else{
            echo "<script>alert('Username atau password Anda salah. Silakan coba lagi!')</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <style>
            body {
                background-color: #f8f9fa;
            }

            .container {
                margin-top: 100px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Login</div>
                        <div class="card-body">
                            <form method="post" action="index.php">
                                <div class="form-group">
                                    <label>Username:</label>
                                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                                </div>
                                <div class="form-group">
                                    <label>Password:</label>
                                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>