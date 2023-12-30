<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }

    include 'config.php';

    $user_id = $_GET['id'];
    if(isset($_POST['username'])){
        $fullname = $_POST['fullname'];
        $username = $_POST['username'];
        $birth_place = $_POST['birth_place'];
        $birth_date = $_POST['birth_date'];
        $citizen_id = $_POST['citizen_id'];
        $gender = $_POST['gender'];
        $blood_type = $_POST['blood_type'];
        $address = $_POST['address'];
        $village_id = $_POST['village'];
        $religion_id = $_POST['religion'];
        $marital_id = $_POST['marital'];
        $job_title = $_POST['job_title'];
        $citizen_type = $_POST['citizen_type'];
        $issued_date = date('Y-m-d');
        
        $query = "UPDATE `user` SET `user_fullname`='$fullname',`user_name`='$username',
        `birth_place`='$birth_place', `birth_date`='$birth_date',`citizen_id`='$citizen_id',`gender`='$gender',
        `blood_type`='$blood_type',`address`='$address',`village_id`='$village_id',`religion_id`='$religion_id',
        `marital_id`='$marital_id',`job_title`='$job_title',`citizen_type`='$citizen_type',`issued_date`='$issued_date' WHERE `user_id`='$user_id'";
        $result = mysqli_query($conn, $query);
        header("Location: user.php");
        exit();
    }else{
        $query = "SELECT * FROM user WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        if(@$row){
            $fullname = $row['user_fullname'];
            $username = $row['user_name'];
            $birth_place = $row['birth_place'];
            $birth_date = $row['birth_date'];
            $citizen_id = $row['citizen_id'];
            $gender = $row['gender'];
            $blood_type = $row['blood_type'];
            $address = $row['address'];
            $village_id = isset($row['village']) ? $row['village'] : '';
            $religion_id = isset($row['religion']) ? $row['religion'] : '';
            $marital_id = isset($row['marital']) ? $row['marital'] : '';
            $job_title = $row['job_title'];
            $citizen_type = $row['citizen_type'];
            $issued_date = date('Y-m-d');
        }else{
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
            <form method="post" action="edit_user.php?id=<?= $user_id; ?>">
                <div class="form-group">
                    <label>Nama Lengkap:</label>
                    <input type="text" class="form-control" name="fullname" value="<?= $fullname; ?>" placeholder="Fullname" required>
                </div>
                <div class="form-group">
                    <label>Nama Pengguna:</label>
                    <input type="text" class="form-control" name="username" value="<?= $username; ?>" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <label>Tempat Lahir:</label>
                    <input type="text" class="form-control" name="birth_place" value="<?= $birth_place; ?>" placeholder="Tempat lahir">
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir:</label>
                    <input type="date" class="form-control" name="birth_date" value="<?= $birth_date; ?>" placeholder="Tanggal lahir">
                </div>
                <div class="form-group">
                    <label>NIK:</label>
                    <input type="text" class="form-control" name="citizen_id" value="<?= $citizen_id; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin:</label>
                    <select class="form-select" name="gender" aria-label="Pilih Jenis Kelamin" required>
                        <option></option>
                        <option value="Laki-Laki">Laki-Laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Golongan Darah:</label>
                    <select class="form-select" name="blood_type" aria-label="Pilih Golongan Darah" required>
                        <option></option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Alamat:</label>
                    <input type="text" class="form-control" name="address" value="<?= $address; ?>" placeholder="Alamat">
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
                    <select class="form-select" name="marital" aria-label="Pilih Status Perkawinan" required>
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
                    <input type="text" class="form-control" name="job_title" value="<?= $job_title; ?>" placeholder="Pekerjaan">
                </div>
                <div class="form-group">
                    <label>Kewarganegaraan:</label>
                    <select class="form-select" name="citizen_type" aria-label="Pilih Kewarganegaraan" required>
                        <option></option>
                        <option value="WNI">Warga Negara Indonesia</option>
                        <option value="WNA">Warga Negara Asing</option>
                    </select>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Edit</button>
                <a href="user.php" class="btn btn-secondary">Kembali</a>
            </form>
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
