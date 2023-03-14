<?php
require("./layout/db.php");

$id = $_POST["id"];

$conn->query("UPDATE access SET status='OK' WHERE id='$id'");
header("Location: /user/home.php?msg=Access Granded Successfully !");
die();

?>