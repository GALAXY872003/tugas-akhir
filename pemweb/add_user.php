<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }

    include 'config.php';
    if(isset($_POST['username'])){
        $fullname = $_POST['fullname'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $repassword = $_POST['repassword'];
        $birth_place = $_POST['birth_place'];
        $birth_date = $_POST['birth_date'];
        $gender = $_POST['gender'];
        $blood_type = $_POST['blood_type'];
        $address = $_POST['address'];
        $village_id = $_POST['village'];
        $religion_id = $_POST['religion'];
        $marital_id = $_POST['marital'];
        $job_title = $_POST['job_title'];
        $citizen_type = $_POST['citizen_type'];
        $md5_password = md5($password);
        $issued_date = date('Y-m-d');

        if($gender == 'Laki-Laki'){
            $generate_date = date('dmy', strtotime($birth_date));
        }else{
            $woman_date = date('d', strtotime($birth_date)) + 40;
            $generate_date = $woman_date.date('my', strtotime($birth_date));
        }

        $district_id = $_POST['district'] . $generate_date;

        // Check if the record with the generated district and birth date exists
        $check_query = "SELECT MAX(SUBSTRING(citizen_id, 13)) AS max_suffix FROM `user` WHERE citizen_id LIKE '$district_id%'";
        $check_result = mysqli_query($conn, $check_query);
        $row = mysqli_fetch_assoc($check_result);
        $suffix = $row['max_suffix'];
    
        if ($suffix !== null) {
            // If a record exists, increment the last four digits
            $suffix = str_pad((int)$suffix + 1, 4, '0', STR_PAD_LEFT);
        } else {
            // If no record exists, set the last four digits to '0001'
            $suffix = '0001';
        }
    
        $district_id .= $suffix;
        

        if($password != $repassword){
            echo "<script>alert('Password dan Konfirmasi Password tidak sesuai!')</script>";
        }else{
            $query = "INSERT INTO `user`(`user_fullname`, `user_name`, `user_password`, `citizen_id`, `birth_place`, `birth_date`, `gender`, `blood_type`, `address`, `village_id`, `religion_id`, `marital_id`, `job_title`, `citizen_type`, `issued_date`) VALUES ('$fullname','$username','$md5_password','$district_id','$birth_place','$birth_date','$gender','$blood_type','$address','$village_id','$religion_id','$marital_id','$job_title','$citizen_type','$issued_date')";
            $result = mysqli_query($conn, $query);
            header("Location: user.php");
            exit();
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
            <form method="post" action="add_user.php">
                <div class="form-group">
                    <label>Nama Lengkap:</label>
                    <input type="text" class="form-control" name="fullname" value="<?= @$_POST['fullname']; ?>" placeholder="Fullname" required>
                </div>
                <div class="form-group">
                    <label>Nama Pengguna:</label>
                    <input type="text" class="form-control" name="username" value="<?= @$_POST['username']; ?>" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password:</label>
                    <input type="password" class="form-control" name="repassword" placeholder="Konfirmasi Password" required>
                </div>
                <div class="form-group">
                    <label>Tempat Lahir:</label>
                    <input type="text" class="form-control" name="birth_place" value="<?= @$_POST['birth_place']; ?>" placeholder="Tempat lahir">
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir:</label>
                    <input type="date" class="form-control" name="birth_date" value="<?= @$_POST['birth_date']; ?>" placeholder="Tanggal lahir">
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin:</label>
                    <select class="form-select" name="gender" aria-label="Pilih Jenis Kelamin">
                        <option></option>
                        <option value="Laki-Laki">Laki-Laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Golongan Darah:</label>
                    <select class="form-select" name="blood_type" aria-label="Pilih Golongan Darah">
                        <option></option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Alamat:</label>
                    <textarea class="form-control" name="address" placeholder="Alamat"><?= @$_POST['address']; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Provinsi:</label>
                    <select class="form-select" id="province" name="province" aria-label="Pilih Provinsi" required>
                        <option></option>
                    <?php
                        $query = "SELECT * FROM `reg_provinces`;";
                        $result = mysqli_query($conn, $query);

                        if($result->num_rows > 0):
                            $row = mysqli_fetch_all($result);
                            foreach ($row as $r):
                    ?>
                        <option value="<?= $r[0]; ?>"><?= $r[1]; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kabupaten/Kota:</label>
                    <select class="form-select" id="regency" name="regency" aria-label="Pilih Kabupaten/Kota" required>
                        <option></option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kecamatan:</label>
                    <select class="form-select" id="district" name="district" aria-label="Pilih Kecamatan" required>
                        <option></option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kelurahan:</label>
                    <select class="form-select" id="village" name="village" aria-label="Pilih Kelurahan" required>
                        <option></option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Agama:</label>
                    <select class="form-select" name="religion" aria-label="Pilih Agama">
                        <option></option>
                    <?php
                        $query = "SELECT * FROM `religion`;";
                        $result = mysqli_query($conn, $query);

                        if($result->num_rows > 0):
                            $row = mysqli_fetch_all($result);
                            foreach ($row as $r):
                    ?>
                        <option value="<?= $r[0]; ?>"><?= $r[1]; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status Perkawinan:</label>
                    <select class="form-select" name="marital" aria-label="Pilih Status Perkawinan">
                        <option></option>
                    <?php
                        $query = "SELECT * FROM `marital`;";
                        $result = mysqli_query($conn, $query);

                        if($result->num_rows > 0):
                            $row = mysqli_fetch_all($result);
                            foreach ($row as $r):
                    ?>
                        <option value="<?= $r[0]; ?>"><?= $r[1]; ?></option>
                    <?php
                            endforeach;
                        endif;
                    ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Pekerjaan:</label>
                    <input type="text" class="form-control" name="job_title" value="<?= @$_POST['job_title']; ?>" placeholder="Pekerjaan">
                </div>
                <div class="form-group">
                    <label>Kewarganegaraan:</label>
                    <select class="form-select" name="citizen_type" aria-label="Pilih Kewarganegaraan">
                        <option></option>
                        <option value="WNI">Warga Negara Indonesia</option>
                        <option value="WNA">Warga Negara Asing</option>
                    </select>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Tambah</button>
                <a href="user.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.1.0.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function(){
                $("#province").change(function(){
                    $.ajax({
                        type: "POST",
                        url: "option_regency.php",
                        data: { province : $("#province").val() },
                        dataType: "json",
                        beforeSend: function(e) {
                            if(e && e.overrideMimeType) {
                                e.overrideMimeType("application/json;charset=UTF-8");
                            }
                        },
                        success: function(response){
                            $("#regency").html(response.regency);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError);
                        }
                    });
                });

                $("#regency").change(function(){
                    $.ajax({
                        type: "POST",
                        url: "option_district.php",
                        data: { regency : $("#regency").val() },
                        dataType: "json",
                        beforeSend: function(e) {
                            if(e && e.overrideMimeType) {
                                e.overrideMimeType("application/json;charset=UTF-8");
                            }
                        },
                        success: function(response){
                            $("#district").html(response.district);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError);
                        }
                    });
                });

                $("#district").change(function(){
                    $.ajax({
                        type: "POST",
                        url: "option_village.php",
                        data: { district : $("#district").val() },
                        dataType: "json",
                        beforeSend: function(e) {
                            if(e && e.overrideMimeType) {
                                e.overrideMimeType("application/json;charset=UTF-8");
                            }
                        },
                        success: function(response){
                            $("#village").html(response.village);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError);
                        }
                    });
                });
            });
        </script>
    </body>
</html>
