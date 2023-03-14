<?php require("./layout/Header.php") ?>
<?php require("./layout/db.php") ?>

<div class="container mt-3">

    <button type="button" style="color:#fff;background-color:#2b74e2;position:fixed;bottom:50px;right:50px"  class="btn" data-bs-toggle="modal" data-bs-target="#myModal">
        +
    </button>

    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style="color:#2b74e2">Upload Image</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form onsubmit="document.getElementById('loader').style.display='block'" enctype="multipart/form-data" action="/user/img.php" method="post">
                    <div class="form-floating mb-3 mt-3">
                        <input required type="file" class="form-control"  name="image" placeholder="Select Image">
                        <label>Select Image</label>
                    </div>
                    <div style="display:flex;justify-content:flex-end">
                        <button class="btn  w-25" style="background-color:#2b74e2;color:#fff">Upload</button>
                    </div>
                </form>
            </div>

            </div>
        </div>
    </div>

    <main class="row mt-4">
        <?php
            if(!isset($_SESSION)) 
            { 
                session_start(); 
            }
            $sid = $_SESSION["id"];
            $result = $conn->query("SELECT * FROM photo WHERE NOT uid='$sid'");
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $uid=$row["uid"];
                    $iid=$row["id"];
                    $result1 = $conn->query("SELECT * FROM user WHERE id='$uid'");
                    while($row1 = $result1->fetch_assoc()){
                    ?>
                    <section class="col-3 card p-2">
                        <p style="color:gray">User : <span style="color:#2b74e2"><?php echo($row1["name"]) ?></span></p>
                        <?php
                        $result2 = $conn->query("SELECT * FROM access WHERE iid='$iid' AND uid='$sid'");
                        if($result2->num_rows > 0) {
                            while($row2 = $result2->fetch_assoc()){
                                if($row2["status"]=="OK"){
                                ?>
                                    <a target="_blank" href="/user/uploads/<?php echo($row["img"]) ?>" class="btn btn-secondary my-2">view</a>
                                    <a target="_blank" href="whatsapp://send?text=<?php echo(str_replace("home.php","",$_SERVER["HTTP_REFERER"])."share.php?id=$iid") ?>" class="btn btn-warning my-2">Share</a>
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