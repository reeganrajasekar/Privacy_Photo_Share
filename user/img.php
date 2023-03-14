<?php
require("./layout/db.php");
$target_dir = "./uploads/";
$file = strtotime("now").basename($_FILES["image"]["name"]);
$target_file = $target_dir . $file;

if(!isset($_SESSION)) 
{ 
    session_start(); 
}
$sid = $_SESSION["id"];

if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    $sql = "INSERT INTO photo(uid,img) VALUE('$sid','$file')";
    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        $conn->query("INSERT INTO access(uid,iid,status) VALUE('$sid','$last_id','OK')");
        header("Location: /user?page=1&msg=Image uploaded Successfully !");
        die();
    } else {
        header("Location: /user?page=1&err=Something went Wrong!");
        die();
    }
} else {
    header("Location: /user?page=1&err=Something went Wrong!");
    die();
}




?>