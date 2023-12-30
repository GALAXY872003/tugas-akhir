<?php
    include "config.php";

    $province_id = $_POST['province'];

    $html = "<option></option>";
    $query = "SELECT * FROM `reg_regencies` WHERE `province_id` = '$province_id';";
    $result = mysqli_query($conn, $query);

    if($result->num_rows > 0){
        $row = mysqli_fetch_all($result);
        foreach ($row as $r){
            $html .= "<option value='".$r[0]."'>".$r[2]."</option>";
        }
    }

    $callback = array('regency'=>$html);

    echo json_encode($callback);
?>