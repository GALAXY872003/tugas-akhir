<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }

    include 'config.php';
    $user_id = $_GET['id'];
    $query = "SELECT *, reg_villages.name AS village_name, reg_districts.name AS district_name, reg_regencies.name AS regency_name, reg_provinces.name AS province_name FROM user
    JOIN religion ON user.religion_id=religion.religion_id
    JOIN marital ON user.marital_id=marital.marital_id
    JOIN reg_villages ON user.village_id=reg_villages.id
    JOIN reg_districts ON reg_villages.district_id=reg_districts.id
    JOIN reg_regencies ON reg_districts.regency_id=reg_regencies.id
    JOIN reg_provinces ON reg_regencies.province_id=reg_provinces.id
    WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
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
            <form>
                <div class="form-group">
                    <label>Nama Lengkap:</label>
                    <input type="text" class="form-control" name="fullname" value="<?= @$row['user_fullname']; ?>" placeholder="Fullname" readonly>
                </div>
                <div class="form-group">
                    <label>Nama Pengguna:</label>
                    <input type="text" class="form-control" name="username" value="<?= @$row['user_name']; ?>" placeholder="Username" readonly>
                </div>
                <div class="form-group">
                    <label>Tempat Lahir:</label>
                    <input type="text" class="form-control" name="birth_place" value="<?= @$row['birth_place']; ?>" placeholder="Tempat lahir" readonly>
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir:</label>
                    <input type="date" class="form-control" name="birth_date" value="<?= @$row['birth_date']; ?>" placeholder="Tanggal lahir" readonly>
                </div>
                <div class="form-group">
                    <label>NIK:</label>
                    <input type="text" class="form-control" name="citizen_id" value="<?= @$row['citizen_id']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin:</label>
                    <input type="text" class="form-control" name="gender" value="<?= @$row['gender']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Golongan Darah:</label>
                    <input type="text" class="form-control" name="blood_type" value="<?= @$row['blood_type']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Alamat:</label>
                    <textarea class="form-control" name="address" placeholder="Alamat" readonly><?= @$row['address']; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Provinsi:</label>
                    <input type="text" class="form-control" name="province" value="<?= @$row['province_name']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Kabupaten/Kota:</label>
                    <input type="text" class="form-control" name="regency" value="<?= @$row['regency_name']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Kecamatan:</label>
                    <input type="text" class="form-control" name="district" value="<?= @$row['district_name']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Kelurahan:</label>
                    <input type="text" class="form-control" name="village" value="<?= @$row['village_name']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Agama:</label>
                    <input type="text" class="form-control" name="religion" value="<?= @$row['religion_name']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Status Perkawinan:</label>
                    <input type="text" class="form-control" name="marital" value="<?= @$row['marital_name']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Pekerjaan:</label>
                    <input type="text" class="form-control" name="job_title" value="<?= @$row['job_title']; ?>" placeholder="Pekerjaan" readonly>
                </div>
                <div class="form-group">
                    <label>Kewarganegaraan:</label>
                    <input type="text" class="form-control" name="citizen_type" value="<?= @$row['citizen_type']; ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Tanggal Terbit:</label>
                    <input type="date" class="form-control" name="issued_date" value="<?= @$row['issued_date']; ?>" readonly>
                </div>
                <br>
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
