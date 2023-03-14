<?php
require("./layout/db.php");
if(!isset($_SESSION)) 
{ 
    session_start(); 
}
if(isset($_SESSION["id"]) && $_GET["id"]){
    $iid = $_GET["id"];
    $uid = $_SESSION["id"];
}else{
    header("Location: /?err=Try Login or Create Account to View the Image!");
    die();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Share</title>
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
</head>
<body>
    <?php
    $result2 = $conn->query("SELECT * FROM access WHERE iid='$iid' AND uid='$uid'");
    if($result2->num_rows > 0) {
        while($row2 = $result2->fetch_assoc()){
            if($row2["status"]=="OK"){
            ?>
                <a target="_blank" href="/user/uploads/" class="btn btn-secondary my-2">view</a>
            <?php
            }else{
            ?>
                <p style="color:gray;text-align:center">Waiting for approval</p>
            <?php
            }
        }
    }else{
        ?>
        <form method="post" action="/user/request.php">
            <input type="hidden" name="id" value="<?php echo($iid)?>">
            <button class="btn btn-primary my-2 w-100">Request Access</button>
        </form>
        <?php
    }
    ?>
</body>
</html>