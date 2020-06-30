<?php
    session_start();
    $error="";
    $msg="";
    if(array_key_exists("logout", $_GET) ){
        unset($_SESSION);
        setcookie("id","",time()-60*60);
        $_COOKIE["id"] = ""; 
        header('Location: index.php');
        session_destroy();
    }
    else if((array_key_exists("id", $_SESSION) and $_SESSION['id'] ) or (array_key_exists("id", $_COOKIE ) and $_COOKIE['id'])){
        header("Location: webpages/my_diary.php");

    }
    if(array_key_exists('submit' , $_POST)){
        
        include("webpages/connection.php");
        if(!$_POST['email']){
            $error .="<p>Email Is Required <p>";
        }
        if(!$_POST['password']){
            $error .="<p>Password Is Required <p>";
        }
        if($error==""){
            if($_POST['signup']==1){
                $query= "SELECT id FROM user where email = '".mysqli_real_escape_string($link , $_POST['email'])."' ";
                $result=mysqli_query($link , $query);
                
                if(mysqli_num_rows($result) > 0){
                    $error .= "<p>This Email ID is Already Taken </p>";
                }
                else{
                                    
                    $query= "INSERT INTO user(name , email , password) VALUES( '".mysqli_real_escape_string($link , $_POST['name'])."' , '".mysqli_real_escape_string($link , $_POST['email'])."' , '".mysqli_real_escape_string($link , $_POST['password'])."')";
                    
                    if(!mysqli_query($link , $query)){
                        $error .="<p>Couldn't Sign Up ... Please Try Again Later </p>";
                    }
                    else{
                        $query="UPDATE user SET password= '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id=".mysqli_insert_id($link);
                        mysqli_query($link,$query);
                        $_SESSION['id']=mysqli_insert_id($link);
                        
                        $msg="<p>Sign Up Successfull !! You Can Now Login Into Your Account</p>";
                    }

                }
            }
            else{
                $query="SELECT * FROM user where email = '".mysqli_real_escape_string($link , $_POST['email'])."' ";
                $result=mysqli_query($link , $query);
                $row=mysqli_fetch_array($result);
                
                if(isset($row)){
                    $hashedPassword= md5(md5($row['id']).$_POST['password']);

                    if($hashedPassword==$row['password']){
                        $_SESSION['id']=$row['id'];
                        if($_POST['check']=='1'){
                            setcookie("id",$row['id'], time()+60*60*24*30);
                        }
                        header("Location: webpages/my_diary.php");
                    }
                    else{
                        $error.="<p>You Entered An Incorrect Password</p>";
                    }
                }
                else{
                    $error.="<p>User Not Found</p>";
                }
            }
        }

    }

?>

<?php include("webpages/header.php");?>
<head>
<link rel="stylesheet" href="css/style.css">
<style>
body { 
       
       background: url("img/background.jpg") no-repeat center center fixed; 
       -webkit-background-size: cover;
       -moz-background-size: cover;
       -o-background-size: cover;
       background-size: cover;
   }</style>
</head>
  <body>
    <div class="container">
        <h1 class="text-light" id="homepage">My Secret Diary</h1>
        <?php
            if($error != ""){?>
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">OOPS There Was An Error..!</h4><hr>
                    <?php echo $error ?>
                </div>
        <?php 
            }
            if($msg!=""){?>
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Wonderful..!</h4><hr>
                    <?php echo $msg ?>
                </div><?php
            }
        ?>


        <form method="post" id="reg-form" class="text-light">
            <p>Store Your Deepest Thoughts And Darkest Secret Here Securely And Permanently...Interested ..? <b>Register Now</b></p>
            <div class="form-group">
                
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your Name Here">
            </div>
            <div class="form-group">
                
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email Here">
            </div>
            <div class="form-group">
                
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Your Password here">
            </div>
            <div class="form-group text-light">
            <input type="hidden" name="signup"value=1>
            </div>
            <div class="form-group">
            <input type="submit" class="btn btn-primary" name="submit" value="Sign Up">
            </div>
            <p>Already Registerd ..?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="log"><b>Click Here To Login</b></a></p>
        </form>


        <form method="post" id="login-form" class="text-light">
        <div class="form-group" >
        <p>Store Your Deepest Thoughts And Darkest Secret Here Securely And Permanently...Interested ..? <b>Login Below</b></p>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email Here">
            </div>
            <div class="form-group">
                
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Your Password here">
            </div>
            <div class="form-group text-light">
            <input type="hidden" name="signup"value=0>
            <input type="checkbox" name="check" value=1> Keep Me Logged In
            </div>
            <div class="form-group">
            <input type="submit" class="btn btn-primary" name="submit" value="Log In">
            </div>
            <p>Not Registerd Yet..?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="reg"><b>Click Here To Register</b></a></p>
        </form>
    </div>
<?php include("webpages/footer.php")?>
        




