<?php
require("./layout/db.php");

$iid = $_POST["id"];
if(!isset($_SESSION)) 
{ 
    session_start(); 
}
$sid = $_SESSION["id"];


$conn->query("INSERT INTO access(uid,iid,status) VALUE('$sid','$iid','NOT')");
header("Location: /user?page=1&msg=Permission Requested!");
die();

?>