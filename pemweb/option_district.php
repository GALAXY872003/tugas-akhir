<?php
    include "config.php";

    $regency_id = $_POST['regency'];

    $html = "<option></option>";
    $query = "SELECT * FROM `reg_districts` WHERE `regency_id` = '$regency_id';";
    $result = mysqli_query($conn, $query);

    if($result->num_rows > 0){
        $row = mysqli_fetch_all($result);
        foreach ($row as $r){
            $html .= "<option value='".$r[0]."'>".$r[2]."</option>";
        }
    }

    $callback = array('district'=>$html);

    echo json_encode($callback);
?>