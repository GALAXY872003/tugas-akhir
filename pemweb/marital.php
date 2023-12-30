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
        <title>Status Perkawinan</title>
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
                        <th scope="col">Status Perkawinan</th>
                        <th scope="col">
                            <a href="add_marital.php" class="btn btn-primary btn-sm">Tambah</a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    include 'config.php';

                    $query = "SELECT * FROM `marital`;";
                    $result = mysqli_query($conn, $query);

                    if($result->num_rows > 0):
                        $row = mysqli_fetch_all($result);
                        $no = 1;
                        foreach ($row as $r):
                ?>
                    <tr>
                        <th scope="row"><?= $no++; ?></th>
                        <td><?= $r[1]; ?></td>
                        <td>
                            <a href="edit_marital.php?id=<?= $r[0]; ?>" class="btn btn-secondary btn-sm">Edit</a>
                            <a href="delete_marital.php?id=<?= $r[0]; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin?');">Hapus</a>
                        </td>
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
