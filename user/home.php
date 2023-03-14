<?php require("./layout/Header.php") ?>
<?php require("./layout/db.php") ?>

<div class="container mt-3">

    <main class="row mt-4">
        <?php
            if(!isset($_SESSION)) 
            { 
                session_start(); 
            }
            $sid = $_SESSION["id"];
            $result = $conn->query("SELECT * FROM photo WHERE uid='$sid'");
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $uid=$row["uid"];
                    $iid=$row["id"];
                    $result1 = $conn->query("SELECT * FROM user WHERE id='$uid'");
                    while($row1 = $result1->fetch_assoc()){
                    ?>
                    <section class="col-3 card p-2">
                        <p style="color:gray">Owner: <span style="color:#2b74e2"><?php echo($row1["name"]) ?></span></p>
                        <p style="color:gray">Image : <a target="_blank" href="/user/uploads/<?php echo($row["img"]) ?>" style="color:#2b74e2">Click here</a></p>
                        <a target="_blank" href="whatsapp://send?text=<?php echo(str_replace("home.php","",$_SERVER["HTTP_REFERER"])."share.php?id=$iid") ?>" class="btn btn-warning my-2">Share</a>
                        <?php
                        $result2 = $conn->query("SELECT * FROM access WHERE iid='$iid' AND status='NOT'");
                        if($result2->num_rows > 0) {
                            while($row2=$result2->fetch_assoc()){
                            ?>
                                <form method="post" action="/user/access.php">
                                    <input type="hidden" value="<?php echo($row2["id"])?>" name="id">
                                    <?php
                                        $mid=$row2["uid"];
                                        $result5 = $conn->query("SELECT name from user WHERE id='$mid'");
                                        while($row5 = $result5->fetch_assoc()){
                                    ?>
                                        <label for=""><?php echo($row5["name"]) ?> : </label>
                                    <?php
                                        }
                                    ?>
                                    <button class="btn btn-success">Grant</button>
                                </form>
                            <?php
                            }
                        }
                        ?>
                    </section>
                    <?php
                    }
                }
            }else{
                echo("<p style='color:gray;text-align:center'>Nothing Found</p>");
            }
        ?>
    </main>


<script>
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    if(urlParams.get('err')){
      document.write("<div id='err' style='position:fixed;bottom:30px; right:30px;background-color:#FF0000;padding:10px;border-radius:10px;box-shadow:2px 2px 4px #aaa;color:white;font-weight:600'>"+urlParams.get('err')+"</div>")
    }
    setTimeout(()=>{
        document.getElementById("err").style.display="none"
    }, 3000)
</script>

<script>
    if(urlParams.get('msg')){
      document.write("<div id='msg' style='position:fixed;bottom:30px; right:30px;background-color:#4CAF50;padding:10px;border-radius:10px;box-shadow:2px 2px 4px #aaa;color:white;font-weight:600'>"+urlParams.get('msg')+"</div>")
    }
    setTimeout(()=>{
        document.getElementById("msg").style.display="none"
    }, 3000)
</script>


<?php require("./layout/Footer.php") ?>