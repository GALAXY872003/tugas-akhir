<?php
    include "config.php";

    $district_id = $_POST['district'];

    $html = "<option></option>";
    $query = "SELECT * FROM `reg_villages` WHERE `district_id` = '$district_id';";
    $result = mysqli_query($conn, $query);

    if($result->num_rows > 0){
        $row = mysqli_fetch_all($result);
        foreach ($row as $r){
            $html .= "<option value='".$r[0]."'>".$r[2]."</option>";
        }
    }

    $callback = array('village'=>$html);

    echo json_encode($callback);
?>