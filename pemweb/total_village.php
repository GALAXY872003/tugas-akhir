<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Home</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" rel="stylesheet" />
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
            <table id="myTable" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Provinsi</th>
                        <th scope="col">Total Kelurahan</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    include 'config.php';

                    $query = "SELECT `reg_provinces`.`name`, COUNT(*) AS total_village FROM `reg_villages`
                    JOIN `reg_districts` ON `reg_villages`.`district_id`=`reg_districts`.`id`
                    JOIN `reg_regencies` ON `reg_districts`.`regency_id`=`reg_regencies`.`id`
                    JOIN `reg_provinces` ON `reg_regencies`.`province_id`=`reg_provinces`.`id`
                    GROUP BY `reg_provinces`.`id`
                    ORDER BY total_village DESC;";
                    $result = mysqli_query($conn, $query);

                    if($result->num_rows > 0):
                        $row = mysqli_fetch_all($result);
                        $no = 1;
                        foreach ($row as $r):
                ?>
                    <tr>
                        <th scope="row"><?= $no++; ?></th>
                        <td><?= $r[0]; ?></td>
                        <td><?= $r[1]; ?></td>
                    </tr>
                <?php
                        endforeach;
                    endif;
                ?>
                </tbody>
            </table>
        </div>
        <script src="https://code.jquery.com/jquery-3.1.0.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
        <script>
            $(document).ready( function () {
                $('#myTable').DataTable();
            } );
        </script>
    </body>
</html>
