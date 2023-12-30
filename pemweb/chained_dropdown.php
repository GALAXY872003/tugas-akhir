<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }

    include 'config.php';
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
