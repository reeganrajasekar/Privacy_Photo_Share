<?php
require("./user/layout/db.php");

$name = $_POST["name"];
$email = $_POST["email"];
$password = $_POST["password"];

$sql="INSERT INTO user(name,email,password) VALUE('$name','$email','$password')";
$conn->query($sql);

header("Location: /?msg=Signup Successfully!");
die();
?>