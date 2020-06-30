<?php
    session_start();
    $diaryContent="";
    if(array_key_exists("id" , $_COOKIE)){
        $_SESSION['id']=$_COOKIE['id'];
    }

    if(array_key_exists("id" , $_SESSION) ){
        include("connection.php");
        $query="SELECT name, diary FROM user WHERE id='".$_SESSION['id']."'";
        $result=mysqli_query($link , $query);
        $row=mysqli_fetch_array($result);
        $diaryContent=$row['diary'];
        ?>
        <div class="container-fluid">
        <p id="welcome-text">Welcome <?php echo $row['name']; ?>
        
        <a href='index.php?logout=1'><input type="button" class="btn btn-success lgout" value="Logout"></a></p>
        </div>
        <?php
    }
    else{
        header("Location: ../index.php");
    }
    include("header.php");
?>
<body>
    
    <div class="form-group container-fluid">
         <textarea id="diary" class="form-control" name="diary" autofocus><?php echo $diaryContent?></textarea>
    </div>
        


<?php include("footer.php"); ?>